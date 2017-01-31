<?php

namespace BannerService\Application\Banner\Remove;

use BannerService\Domain\Contract\Repository\BannerRepository;
use BannerService\Domain\Exception\Exception;

class BannerRemoveHandler
{
    /** @var BannerRepository */
    private $bannerRepository;

    /**
     * BannerRemoveHandler constructor.
     * @param BannerRepository $bannerRepository
     */
    public function __construct(BannerRepository $bannerRepository)
    {
        $this->bannerRepository = $bannerRepository;
    }

    public function handle(BannerRemoveCommand $command)
    {
        try{
            $banner = $this->bannerRepository->findById($command->id);
            $this->bannerRepository->remove($banner);
        }catch (Exception $e){

        }
    }
}