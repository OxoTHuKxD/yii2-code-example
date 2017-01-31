<?php

namespace BannerService\Domain\Entity;
use BannerService\Domain\ValueObject\RotatorFacade;

/**
 * Class Rotator
 * @package BannerService\Domain\Entity
 */
class Rotator
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var int
     */
    private $webmasterId;

    /**
     * @var string
     */
    private $name;

    /**
     * @var int
     */
    private $slotCount;

    /**
     * @var RotatorFacade
     */
    private $rotatorFacade;

    /**
     * @var int[]
     */
    private $bannerIdList;

    /**
     * Rotator constructor.
     * @param int $id
     * @param int $webmasterId
     * @param string $name
     * @param int $slotCount
     * @param RotatorFacade $rotatorFacade
     * @param \int[] $bannerIdList
     */
    public function __construct($id, $webmasterId, $name, $slotCount, RotatorFacade $rotatorFacade, array $bannerIdList)
    {
        $this->id = $id;
        $this->webmasterId = $webmasterId;
        $this->name = $name;
        $this->slotCount = $slotCount;
        $this->rotatorFacade = $rotatorFacade;
        $this->bannerIdList = $bannerIdList;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getWebmasterId()
    {
        return $this->webmasterId;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return int
     */
    public function getSlotCount()
    {
        return $this->slotCount;
    }

    /**
     * @return RotatorFacade
     */
    public function getRotatorFacade()
    {
        return $this->rotatorFacade;
    }

    /**
     * @return \int[]
     */
    public function getBannerIdList()
    {
        return $this->bannerIdList;
    }

    /**
     * @return Webmaster
     */
    public function getWebmaster()
    {
        return null;
    }

    /**
     * @return Banner[]
     */
    public function getBannerList()
    {
        return [];
    }

    /**
     * @param int $webmasterId
     */
    public function setWebmasterId($webmasterId)
    {
        $this->webmasterId = $webmasterId;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @param int $slotCount
     */
    public function setSlotCount($slotCount)
    {
        $this->slotCount = $slotCount;
    }

    /**
     * @param RotatorFacade $rotatorFacade
     */
    public function setRotatorFacade($rotatorFacade)
    {
        $this->rotatorFacade = $rotatorFacade;
    }

    /**
     * @param \int[] $bannerIdList
     */
    public function setBannerIdList($bannerIdList)
    {
        $this->bannerIdList = $bannerIdList;
    }
}
