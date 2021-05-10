<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMS;
use JMS\Serializer\Annotation\Type;

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
    protected int $id;

    public function getId(): ?int
    {
        return $this->id;
    }
}
