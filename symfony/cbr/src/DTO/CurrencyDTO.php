<?php

declare(strict_types=1);

namespace App\DTO;

final class CurrencyDTO
{
    private string $name = '';

    private string $eng_name = '';

    private int $nominal;

    private int $iso_num_code;

    private string $iso_char_code;

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
     * @return int
     */
    public function getIsoNumCode(): int
    {
        return $this->iso_num_code;
    }

    /**
     * @param int $iso_num_code
     */
    public function setIsoNumCode(int $iso_num_code): void
    {
        $this->iso_num_code = $iso_num_code;
    }

    /**
     * @return string
     */
    public function getIsoCharCode(): string
    {
        return $this->iso_char_code;
    }

    /**
     * @param string $iso_char_code
     */
    public function setIsoCharCode(string $iso_char_code): void
    {
        $this->iso_char_code = $iso_char_code;
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
     * @return string
     */
    public function getEngName(): string
    {
        return $this->eng_name;
    }

    /**
     * @param string $eng_name
     */
    public function setEngName(string $eng_name): void
    {
        $this->eng_name = $eng_name;
    }
}
