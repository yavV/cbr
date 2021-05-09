<?php

declare(strict_types=1);

namespace App\Service;

use App\Cache\CbrHttpClientCacheProvider;
use App\DTO\CurrencyExchangeRateDTO;
use App\HttpClient\CbrApiClientInterface;
use DateTimeInterface;
use function Clue\StreamFilter\fun;

class CurrencyService
{
    private CbrApiClientInterface $cbrApiClient;

    private CbrHttpClientCacheProvider $cache;

    /**
     * CurrencyExchangeRateService constructor.
     * @param CbrApiClientInterface $cbrApiClient
     * @param CbrHttpClientCacheProvider $cache
     */
    public function __construct(CbrApiClientInterface $cbrApiClient, CbrHttpClientCacheProvider $cache)
    {
        $this->cbrApiClient = $cbrApiClient;
        $this->cache = $cache;
    }

    /**
     * @return array|null
     */
    public function getCurrenciesVocabulary(): ?array{
        return $this->cbrApiClient->getCurrenciesVocabulary();
    }

    /**
     * @param DateTimeInterface $dateTime
     * @param string $currencyCode
     * @return CurrencyExchangeRateDTO|null
     */
    public function getCurrencyExchangeRateForDate(DateTimeInterface $dateTime, string $currencyCode): ?CurrencyExchangeRateDTO{
        $cacheKey = sprintf('%s_%s', 'currenciesExchangeRate', md5($dateTime->format('d/m/Y')));

        $currenciesExchangeRate = null;
        if ($this->cache->isHit($cacheKey)) {
            return $this->cache->get($cacheKey);
        }

        $currenciesExchangeRate = $this->cbrApiClient->getCurrenciesExchangeRateForDate($dateTime);
        $this->cache->save($cacheKey, $currenciesExchangeRate);

        $currencyExchangeRate = array_filter($currenciesExchangeRate, function ($currencyExchangeRate, $k) use($currencyCode){
           return $currencyExchangeRate->getCharcode() === $currencyCode;
        }, ARRAY_FILTER_USE_BOTH);

        return array_shift($currencyExchangeRate);
    }
}
