<?php

namespace App\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

abstract class BaseRepository extends ServiceEntityRepository
{
    /**
     * @param object $entity
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function save(object $entity): void
    {
        $this->_em->persist($entity);
        $this->_em->flush();
    }

    /**
     * @param $entity
     * @param bool $flush
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function remove(object $entity): void
    {
        $this->_em->remove($entity);
        $this->_em->flush();
    }
}
