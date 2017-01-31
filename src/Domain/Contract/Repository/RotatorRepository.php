<?php

namespace BannerService\Domain\Contract\Repository;

use BannerService\Domain\Entity\Rotator;

interface RotatorRepository
{
    /**
     * @param int $id
     * @return Rotator
     */
    public function findById($id);

    /**
     * @param $id
     * @return bool
     */
    public function hasById($id);

    /**
     * @param Rotator $entity
     */
    public function save(Rotator $entity);

    /**
     * @param Rotator $entity
     */
    public function remove(Rotator $entity);
}