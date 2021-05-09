<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMS;
use JMS\Serializer\Annotation\Type;

/**
 * @ORM\MappedSuperclass
 */
abstract class BaseEntity
{
    /**
     * @var int
     * @ORM\Id
     * @ORM\Column(type="bigint")
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @JMS\Expose()
     * @Type("int")
     */
    protected $id;

    public function getId(): ?int
    {
        return $this->id;
    }
}