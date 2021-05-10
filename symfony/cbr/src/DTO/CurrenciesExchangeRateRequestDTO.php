<?php

declare(strict_types=1);

namespace App\DTO;

use JMS\Serializer\Annotation as Serializer;
use Symfony\Component\Validator\Constraints as Assert;

class CurrenciesExchangeRateRequestDTO
{

    /**
     * @Assert\NotBlank()
     * @var int
     * @Serializer\Type("int")
     * @Serializer\SerializedName("currency")
     */
    public int $currency;

    /**
     * @Assert\NotBlank()
     * @var int
     * @Serializer\Type("int")
     * @Serializer\SerializedName("currencyBase")
     */
    public int $currencyBase;

    /**
     * @Assert\NotBlank()
     * @var \DateTime
     * @Serializer\Type("date")
     * @Serializer\SerializedName("date")
     */
    public \DateTime $date;

    /**
     * @return int
     */
    public function getCurrency(): int
    {
        return $this->currency;
    }

    /**
     * @param int $currency
     * @return CurrenciesExchangeRateRequestDTO
     */
    public function setCurrency(int $currency): CurrenciesExchangeRateRequestDTO
    {
        $this->currency = $currency;
        return $this;
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
     * @return CurrenciesExchangeRateRequestDTO
     */
    public function setCurrencyBase(int $currencyBase): CurrenciesExchangeRateRequestDTO
    {
        $this->currencyBase = $currencyBase;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getDate(): \DateTime
    {
        return $this->date;
    }

    /**
     * @param \DateTime $date
     * @return CurrenciesExchangeRateRequestDTO
     */
    public function setDate(\DateTime $date): CurrenciesExchangeRateRequestDTO
    {
        $this->date = $date;
        return $this;
    }
}
