<?php

declare(strict_types=1);

namespace App\Service;

use App\Cache\CbrHttpClientCacheProvider;
use App\DTO\CurrencyExchangeRateDTO;
use App\Entity\Currency;
use App\Enum\CurrencyEnum;
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
     * @param Currency $currency
     * @param Currency $currencyBase
     * @return CurrencyExchangeRateDTO[]|null
     */
    public function getCurrencyExchangeRatesForDate(
        DateTimeInterface $dateTime,
        Currency $currency,
        Currency $currencyBase
    ): ?array {
        $currentCurrencyExchangeRate = $this->getCurrencyExchangeRateForDate($dateTime, $currency);

        $dateTime->modify('-1 day');

        $previousCurrencyExchangeRate = $this->getCurrencyExchangeRateForDate($dateTime, $currency);

        if ($currentCurrencyExchangeRate === null || $previousCurrencyExchangeRate === null) {
            return null;
        }

        if ($currencyBase->getIsoCharCode() === CurrencyEnum::RUBLE) {
            return [$currentCurrencyExchangeRate, $previousCurrencyExchangeRate];
        }

        $currentCurrencyBaseExchangeRate = $this->getCurrencyExchangeRateForDate($dateTime, $currencyBase);

        $dateTime->modify('-1 day');

        $previousCurrencyBaseExchangeRate = $this->getCurrencyExchangeRateForDate($dateTime, $currencyBase);

        if ($currentCurrencyBaseExchangeRate === null || $previousCurrencyBaseExchangeRate === null) {
            return null;
        }

        return [
            $this->getCrossRate($currentCurrencyExchangeRate, $currentCurrencyBaseExchangeRate),
            $this->getCrossRate($previousCurrencyExchangeRate, $previousCurrencyBaseExchangeRate)
        ];
    }

    /**
     * @param DateTimeInterface $dateTime
     * @param Currency $currency
     * @return CurrencyExchangeRateDTO|null
     */
    private function getCurrencyExchangeRateForDate(
        DateTimeInterface $dateTime,
        Currency $currency
    ): ?CurrencyExchangeRateDTO {
        $cacheKey = sprintf('%s_%s', 'currenciesExchangeRate', md5($dateTime->format('d/m/Y')));

        if ($this->cache->isHit($cacheKey) === true) {
            $currenciesExchangeRate = $this->cache->get($cacheKey);
        } else {
            $currenciesExchangeRate = $this->cbrApiClient->getCurrenciesExchangeRateForDate($dateTime);
            $this->cache->save($cacheKey, $currenciesExchangeRate);
        }

        $currencyExchangeRate = array_filter($currenciesExchangeRate,
            static function ($currencyExchangeRate) use ($currency) {
                return $currencyExchangeRate->getCharcode() === $currency->getIsoCharCode();
            });

        if (count($currencyExchangeRate) === 0) {
            return null;
        }

        return array_shift($currencyExchangeRate);
    }

    /**
     * @param CurrencyExchangeRateDTO $currencyExchangeRate
     * @param CurrencyExchangeRateDTO $currencyBaseExchangeRate
     * @return CurrencyExchangeRateDTO
     */
    private function getCrossRate(
        CurrencyExchangeRateDTO $currencyExchangeRate,
        CurrencyExchangeRateDTO $currencyBaseExchangeRate
    ): CurrencyExchangeRateDTO {
        $newValue = (int)(($currencyExchangeRate->getValue() / $currencyBaseExchangeRate->getValue()) * 10000);

        $currencyExchangeRate->setValue($newValue);

        return $currencyExchangeRate;
    }
}
