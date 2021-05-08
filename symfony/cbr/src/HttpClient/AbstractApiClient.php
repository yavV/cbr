<?php

namespace App\HttpClient;

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
    /**
     * @var MessageFactory
     */
    protected $messageFactory;

    /**
     * @var HttpClient
     */
    protected $httpClient;

    /**
     * @var string
     */
    protected $host;

    /**
     * @var ArrayTransformerInterface
     */
    protected $transformer;

    /**
     * AbstractApiClient constructor.
     *
     * @param ArrayTransformerInterface $transformer
     * @param HttpClient                $httpClient
     * @param MessageFactory            $messageFactory
     * @param string                    $host
     */
    public function __construct(
        ArrayTransformerInterface $transformer,
        HttpClient $httpClient,
        MessageFactory $messageFactory,
        $host
    ) {
        $this->transformer = $transformer;
        $this->httpClient = $httpClient;
        $this->messageFactory = $messageFactory;
        $this->host = $host;
    }

    /**
     * @param            $method
     * @param            $path
     * @param array      $query
     * @param array|null $data
     * @param array      $headers
     *
     * @return RequestInterface
     */
    protected function createRequest($method, $path, array $query = [], array $data = null, array $headers = []): RequestInterface
    {
        $uri = (new Uri($this->host))
            ->withPath($path)
            ->withQuery(http_build_query($query));

        $body = null;
        if (null !== $data) {
            if (
                in_array($method, [Request::METHOD_POST, Request::METHOD_PUT]) &&
                array_key_exists('Content-Type', $headers) &&
                $headers['Content-Type'] === 'application/json'
            ) {
                $body = json_encode($data);
            } else {
                $body = http_build_query($data);
            }
        }

        return $this->messageFactory->createRequest($method, $uri, $headers, $body);
    }

    /**
     * @param ResponseInterface $response
     * @param string            $deserializationType
     * @param string|null       $deserializationRoot
     *
     * @return mixed
     */
    protected function processResponse(
        ResponseInterface $response,
        $deserializationType = 'array',
        $deserializationRoot = null
    ) {
        $contents = $response->getBody()->getContents();

        if ('' === $contents) {
            return null;
        }

        $aux = json_decode($contents, true);

        //handle scalars and null
        if (false === is_array($aux))    {
            return $aux;
        }

        if ($deserializationRoot !== null) {
            if (strpos($deserializationRoot, '.') === false) {
                $aux = $aux[$deserializationRoot];
            } else {
                $path = explode('.', $deserializationRoot);
                foreach ($path as $p) {
                    $aux = $aux[$p];
                }
            }
        }
        return is_array($aux) ? $this->transformer->fromArray($aux, $deserializationType) : null;
    }

    /**
     * @param $method
     * @param $path
     * @param array $query
     * @param array|null $data
     * @param array $headers
     * @param string $deserializationType
     * @param null $deserializationRoot
     *
     * @return mixed
     * @throws ClientExceptionInterface
     */
    protected function process(
        $method,
        $path,
        array $query = [],
        array $data = null,
        array $headers = [],
        $deserializationType = 'array',
        $deserializationRoot = null
    )
    {
        if ($headers === []) {
            $headers = [
                'Content-Type' => 'application/json'
            ];
        }
        $request = $this->createRequest($method, $path, $query, $data, $headers);

        $response = $this->httpClient->sendRequest($request);

        return $this->processResponse(
            $response,
            $deserializationType,
            $deserializationRoot
        );
    }
}
