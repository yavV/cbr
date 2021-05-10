<?php

declare(strict_types=1);

namespace App\Service;

use App\Cache\CbrHttpClientCacheProvider;
use App\DTO\CurrencyExchangeRateDTO;
use App\HttpClient\CbrApiClientInterface;
use DateTimeInterface;

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
    public function getCurrenciesVocabulary(): ?array
    {
        return $this->cbrApiClient->getCurrenciesVocabulary();
    }

    /**
     * @param DateTimeInterface $dateTime
     * @param string $currencyCode
     * @return CurrencyExchangeRateDTO[]|null
     */
    public function getCurrencyExchangeRatesForDate(
        DateTimeInterface $dateTime,
        string $currencyCode
    ): ?array {
        $currentCurrencyExchangeRate = $this->getCurrencyExchangeRateForDate($dateTime, $currencyCode);

        $dateTime->modify('-1 day');

        $previousCurrencyExchangeRate = $this->getCurrencyExchangeRateForDate($dateTime, $currencyCode);

        if ($currentCurrencyExchangeRate === null || $previousCurrencyExchangeRate === null) {
            return null;
        }

        return [$currentCurrencyExchangeRate, $previousCurrencyExchangeRate];
    }

    /**
     * @param DateTimeInterface $dateTime
     * @param string $currencyCode
     * @return CurrencyExchangeRateDTO|null
     */
    private function getCurrencyExchangeRateForDate(
        DateTimeInterface $dateTime,
        string $currencyCode
    ): ?CurrencyExchangeRateDTO {
        $cacheKey = sprintf('%s_%s', 'currenciesExchangeRate', md5($dateTime->format('d/m/Y')));

        if ($this->cache->isHit($cacheKey) === true) {
            $currenciesExchangeRate = $this->cache->get($cacheKey);
        } else {
            $currenciesExchangeRate = $this->cbrApiClient->getCurrenciesExchangeRateForDate($dateTime);
            $this->cache->save($cacheKey, $currenciesExchangeRate);
        }

        $currencyExchangeRate = array_filter($currenciesExchangeRate,
            static function ($currencyExchangeRate) use ($currencyCode) {
                return $currencyExchangeRate->getCharcode() === $currencyCode;
            });

        if (count($currencyExchangeRate) === 0) {
            return null;
        }

        return array_shift($currencyExchangeRate);
    }
}
