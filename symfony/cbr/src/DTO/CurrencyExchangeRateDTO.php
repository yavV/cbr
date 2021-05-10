<?php

declare(strict_types=1);

namespace App\DTO;

final class CurrencyExchangeRateDTO
{
    private int $numcode;

    private string $charcode;

    private int $nominal;

    private string $name;

    private int $value;

    /**
     * @return int
     */
    public function getNumcode(): int
    {
        return $this->numcode;
    }

    /**
     * @param int $numcode
     */
    public function setNumcode(int $numcode): void
    {
        $this->numcode = $numcode;
    }

    /**
     * @return string
     */
    public function getCharcode(): string
    {
        return $this->charcode;
    }

    /**
     * @param string $charcode
     */
    public function setCharcode(string $charcode): void
    {
        $this->charcode = $charcode;
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
     * @return int
     */
    public function getValue(): int
    {
        return $this->value;
    }

    /**
     * @param int $value
     */
    public function setValue(int $value): void
    {
        $this->value = $value;
    }
}
