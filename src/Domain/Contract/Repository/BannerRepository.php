<?php

namespace BannerService\Domain\Contract\Repository;

use BannerService\Domain\Entity\Banner;
use BannerService\Domain\Entity\Rotator;

interface BannerRepository
{
    /**
     * @param int $id
     * @return Banner
     */
    public function findById($id);

    /**
     * @param int $rotatorId
     * @return int[]
     */
    public function findIdAllByRotatorId($rotatorId);

    /**
     * @param int $rotatorId
     * @return Banner[]
     */
    public function findAllByRotatorId($rotatorId);

    /**
     * @param $id
     * @return bool
     */
    public function hasById($id);

    /**
     * @param Banner $entity
     */
    public function save(Banner $entity);

    /**
     * @param Rotator $entity
     */
    public function saveBannersRotatorAssign(Rotator $entity);

    /**
     * @param Banner $entity
     */
    public function remove(Banner $entity);
}