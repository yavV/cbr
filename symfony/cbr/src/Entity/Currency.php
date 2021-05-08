<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CurrencyRepository")
 * Описывает используемые валюты
 **/
final class Currency extends BaseEntity
{
    private int $item_id;

    private int $nominal;

    private string $parent_code;

    private int $iso_num_code;

    private string $iso_char_code;

    /**
     * @return int
     */
    public function getItemId(): int
    {
        return $this->item_id;
    }

    /**
     * @param int $item_id
     */
    public function setItemId(int $item_id): void
    {
        $this->item_id = $item_id;
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
    public function getParentCode(): string
    {
        return $this->parent_code;
    }

    /**
     * @param string $parent_code
     */
    public function setParentCode(string $parent_code): void
    {
        $this->parent_code = $parent_code;
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
}
