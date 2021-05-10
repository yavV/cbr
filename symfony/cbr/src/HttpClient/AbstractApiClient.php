<?php

namespace App\HttpClient;

use DOMDocument;
use GuzzleHttp\Psr7\Uri;
use Http\Client\HttpClient;
use Http\Message\MessageFactory;
use JMS\Serializer\ArrayTransformerInterface;
use Psr\Http\Client\ClientExceptionInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * Abstract client for DRY purposes.
 */
abstract class AbstractApiClient
{
    protected MessageFactory $messageFactory;

    protected HttpClient $httpClient;

    protected string $host;

    protected ArrayTransformerInterface $transformer;

    /**
     * AbstractApiClient constructor.
     *
     * @param ArrayTransformerInterface $transformer
     * @param HttpClient $httpClient
     * @param MessageFactory $messageFactory
     * @param string $host
     */
    public function __construct(
        ArrayTransformerInterface $transformer,
        HttpClient $httpClient,
        MessageFactory $messageFactory,
        string $host
    ) {
        $this->transformer = $transformer;
        $this->httpClient = $httpClient;
        $this->messageFactory = $messageFactory;
        $this->host = $host;
    }

    /**
     * @param            $method
     * @param            $path
     * @param array $query
     *
     * @return RequestInterface
     */
    protected function createRequest($method, $path, array $query = []): RequestInterface
    {
        $uri = (new Uri($this->host))
            ->withPath($path)
            ->withQuery(http_build_query($query))
        ;

        $body = null;
        $headers = [];

        return $this->messageFactory->createRequest($method, $uri, $headers, $body);
    }

    /**
     * @param ResponseInterface $response
     * @param string $deserializationType
     * @param null $deserializationElements
     *
     * @param $validation
     * @return mixed
     */
    protected function processResponse(
        ResponseInterface $response,
        $deserializationType = 'array',
        $deserializationElements = null,
        ResponseInterface $validation = null
    ) {
        $contents = $response->getBody()->getContents();

        if ('' === $contents) {
            return null;
        }

        $xml = new DOMDocument('1.0', 'win-1251');

        $xml->loadXML($contents);

        if (null !== $validation) {
            $xsdContent = $validation->getBody()->getContents();

            if (!$xml->schemaValidateSource($xsdContent)) {
                return null;
            }
        }

        $elements = $xml->getElementsByTagName($deserializationElements);

        $elementsArray = [];

        foreach ($elements as $element) {
            $elementArray = [];
            if ($element->childNodes->length) {
                foreach ($element->childNodes as $childNode) {
                    $elementArray[strtolower($childNode->nodeName)] = $childNode->nodeValue;
                }
            }

            $elementsArray[] = $elementArray;
        }

        return count($elementsArray) > 0 ? $this->transformer->fromArray($elementsArray, $deserializationType) : null;
    }

    /**
     * @param $method
     * @param $path
     * @param $validationPath
     * @param array $query
     * @param string $deserializationType
     * @param null $deserializationElements
     *
     * @return mixed
     * @throws ClientExceptionInterface
     * @throws \Http\Client\Exception
     */
    protected function process(
        $method,
        $path,
        $validationPath,
        array $query = [],
        $deserializationType = 'array',
        $deserializationElements = null
    ) {
        $request = $this->createRequest($method, $path, $query);

        $response = $this->httpClient->sendRequest($request);

        $validationRequest = $this->createRequest(Request::METHOD_GET, $validationPath);

        $validation = $this->httpClient->sendRequest($validationRequest);

        return $this->processResponse(
            $response,
            $deserializationType,
            $deserializationElements,
            $validation
        );
    }
}
