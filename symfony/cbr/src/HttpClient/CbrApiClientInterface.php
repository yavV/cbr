<?php

declare(strict_types=1);

namespace App\HttpClient;

use App\DTO\CurrencyExchangeRateDTO;
use App\Entity\Currency;
use DateTimeInterface;

interface CbrApiClientInterface
{
    /**
     * @return Currency[]|null
     */
    public function getCurrenciesVocabulary(): ?array;

    /**
     * @param DateTimeInterface $dateTime
     * @return CurrencyExchangeRateDTO[]|null
     */
    public function getCurrenciesExchangeRateForDate(DateTimeInterface $dateTime): ?array;
}
