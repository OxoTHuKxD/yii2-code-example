<?php

namespace BannerService\Domain\Proxy;

use BannerService\Domain\Contract\Repository\BannerRepository;
use BannerService\Domain\Contract\Repository\WebmasterRepository;
use BannerService\Domain\Entity\Banner;
use BannerService\Domain\Entity\Rotator;
use BannerService\Domain\Entity\Webmaster;
use BannerService\Domain\ValueObject\RotatorFacade;

class RotatorProxy extends Rotator
{
    /**
     * @var BannerRepository
     */
    private $bannerRepository;

    /**
     * @var WebmasterRepository
     */
    private $webmasterRepository;

    /**
     * @var Banner[]
     */
    private $bannerList = null;

    /**
     * @var Webmaster
     */
    private $webmaster = null;

    /**
     * @param int $id
     * @param int $webmasterId
     * @param string $name
     * @param int $slotCount
     * @param RotatorFacade $rotatorFacade
     * @param int[] $bannerIdList
     * @param BannerRepository $bannerRepository
     * @param WebmasterRepository $webmasterRepository
     */
    public function __construct($id, $webmasterId, $name, $slotCount, RotatorFacade $rotatorFacade, array $bannerIdList, BannerRepository $bannerRepository, WebmasterRepository $webmasterRepository)
    {
        parent::__construct($id, $webmasterId, $name, $slotCount, $rotatorFacade, $bannerIdList);
        $this->bannerRepository = $bannerRepository;
        $this->webmasterRepository = $webmasterRepository;
    }

    /**
     * @return Webmaster
     */
    public function getWebmaster()
    {
        if($this->webmaster === null){
            $this->webmaster = $this->webmasterRepository->findById($this->getWebmasterId());
        }
        return $this->webmaster;
    }

    /**
     * @return Banner[]
     */
    public function getBannerList()
    {
        if($this->bannerList === null) {
            $this->bannerList = $this->bannerRepository->findAllByRotatorId($this->getId());
        }
        return $this->bannerList;
    }

}