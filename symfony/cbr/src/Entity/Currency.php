<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CurrencyRepository")
 * Описывает используемые валюты
 **/
final class Currency extends BaseEntity
{
    /**
     * @var string
     * @ORM\Column(type="string", nullable=false)
     * @Assert\NotBlank ()
     */
    private string $name;

    /**
     * @var string
     * @ORM\Column(type="string", nullable=false)
     * @Assert\NotBlank ()
     */
    private string $eng_name;

    /**
     * @var int
     * @ORM\Column(type="integer", nullable=false)
     * @Assert\NotBlank ()
     */
    private int $nominal;

    /**
     * @var int
     * @ORM\Column(type="integer", nullable=false)
     * @Assert\NotBlank ()
     */
    private int $iso_num_code;

    /**
     * @var string
     * @ORM\Column(type="string", nullable=false)
     * @Assert\NotBlank ()
     */
    private string $iso_char_code;

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return Currency
     */
    public function setName(string $name): Currency
    {
        $this->name = $name;
        return $this;
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
     * @return Currency
     */
    public function setEngName(string $eng_name): Currency
    {
        $this->eng_name = $eng_name;
        return $this;
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
     * @return Currency
     */
    public function setNominal(int $nominal): Currency
    {
        $this->nominal = $nominal;
        return $this;
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
     * @return Currency
     */
    public function setIsoNumCode(int $iso_num_code): Currency
    {
        $this->iso_num_code = $iso_num_code;
        return $this;
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
     * @return Currency
     */
    public function setIsoCharCode(string $iso_char_code): Currency
    {
        $this->iso_char_code = $iso_char_code;
        return $this;
    }
}
