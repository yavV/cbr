<?php

declare(strict_types=1);

namespace App\Request;

use DateTimeImmutable;
use JMS\Serializer\Annotation as Serializer;
use JMS\Serializer\Annotation\SerializedName;

class CurrencyExchangeRateRequest
{
    /**
     * @Serializer\Type("integer")
     */
    private int $currency;

    /**
     * @Serializer\Type("integer")
     * @SerializedName("currencyBase")
     */
    private int $currencyBase;

    /**
     * @Serializer\Type("DateTimeImmutable<'Y-m-d'>")
     */
    private DateTimeImmutable $date;

    /**
     * @return int
     */
    public function getCurrency(): int
    {
        return $this->currency;
    }

    /**
     * @param int $currency
     */
    public function setCurrency(int $currency): void
    {
        $this->currency = $currency;
    }

    /**
     * @return int
     */
    public function getCurrencyBase(): int
    {
        return $this->currencyBase;
    }

    /**
     * @param int $currencyBase
     */
    public function setCurrencyBase(int $currencyBase): void
    {
        $this->currencyBase = $currencyBase;
    }

    /**
     * @return DateTimeImmutable
     */
    public function getDate(): DateTimeImmutable
    {
        return $this->date;
    }

    /**
     * @param DateTimeImmutable $date
     */
    public function setDate(DateTimeImmutable $date): void
    {
        $this->date = $date;
    }
}
