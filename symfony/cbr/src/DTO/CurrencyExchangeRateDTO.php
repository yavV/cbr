<?php

declare(strict_types=1);

namespace App\DTO;

final class CurrencyExchangeRateDTO
{
    private string $id;

    private int $numCode;

    private string $charCode;

    private int $nominal;

    private string $name;

    private float $value;

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @param string $id
     */
    public function setId(string $id): void
    {
        $this->id = $id;
    }

    /**
     * @return int
     */
    public function getNumCode(): int
    {
        return $this->numCode;
    }

    /**
     * @param int $numCode
     */
    public function setNumCode(int $numCode): void
    {
        $this->numCode = $numCode;
    }

    /**
     * @return string
     */
    public function getCharCode(): string
    {
        return $this->charCode;
    }

    /**
     * @param string $charCode
     */
    public function setCharCode(string $charCode): void
    {
        $this->charCode = $charCode;
    }

    /**
     * @return int
     */
    public function getNominal(): int
    {
        return $this->nominal;
    }

    /**
     * @param int $nominal
     */
    public function setNominal(int $nominal): void
    {
        $this->nominal = $nominal;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return float
     */
    public function getValue(): float
    {
        return $this->value;
    }

    /**
     * @param float $value
     */
    public function setValue(float $value): void
    {
        $this->value = $value;
    }
}
