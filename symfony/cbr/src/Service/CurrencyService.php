<?php

declare(strict_types=1);

namespace App\Service;

use App\Cache\CbrHttpClientCacheProvider;
use App\HttpClient\CbrApiClientInterface;

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

    public function getCurrenciesVocabulary(): ?array{
        return $this->cbrApiClient->getCurrenciesVocabulary();
    }

    public function getCurrenciesExchangeRateForDate(\DateTimeInterface $dateTime){

        $cacheKey = sprintf('%s_%s', 'currenciesExchangeRate', md5($dateTime->format('d/m/Y')));
        if ($this->cache->isHit($cacheKey)) {
            return $this->cache->get($cacheKey);
        }

        $currenciesExchangeRate = $this->cbrApiClient->getCurrenciesExchangeRateForDate($dateTime);
        $this->cache->save($cacheKey, $currenciesExchangeRate);

        return $this->cbrApiClient->getCurrenciesExchangeRateForDate($dateTime);
    }
}
