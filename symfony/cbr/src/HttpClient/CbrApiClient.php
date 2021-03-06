<?php

declare(strict_types=1);

namespace App\HttpClient;

use App\DTO\CurrencyDTO;
use App\DTO\CurrencyExchangeRateDTO;
use DateTimeInterface;
use Http\Client\HttpClient;
use Http\Message\MessageFactory;
use JMS\Serializer\ArrayTransformerInterface;
use Symfony\Component\HttpFoundation\Request;

final class CbrApiClient extends AbstractApiClient implements CbrApiClientInterface
{
    public function __construct(
        ArrayTransformerInterface $transformer,
        HttpClient $httpClient,
        MessageFactory $messageFactory,
        $host
    ) {
        parent::__construct($transformer, $httpClient, $messageFactory, $host);
    }

    /**
     * @return CurrencyDTO[]|null
     * @throws \Http\Client\Exception
     * @throws \Psr\Http\Client\ClientExceptionInterface
     */
    public function getCurrenciesVocabulary(): ?array
    {
        return $this->process(
            Request::METHOD_GET,
            'scripts/XML_valFull.asp',
            'StaticHtml/File/92172/XML_valFull.xsd',
            [],
            'array< ' . CurrencyDTO::class . '>',
            'Item'
        );
    }

    /**
     * @param DateTimeInterface $dateTime
     * @return CurrencyExchangeRateDTO[]|null
     * @throws \Http\Client\Exception
     * @throws \Psr\Http\Client\ClientExceptionInterface
     */
    public function getCurrenciesExchangeRateForDate(DateTimeInterface $dateTime): ?array
    {
        return $this->process(
            Request::METHOD_GET,
            'scripts/XML_daily.asp',
            'StaticHtml/File/92172/ValCurs.xsd',
            ['date_req' => $dateTime->format('d/m/Y')],
            'array< ' . CurrencyExchangeRateDTO::class . '>',
            'Valute'
        );
    }
}
