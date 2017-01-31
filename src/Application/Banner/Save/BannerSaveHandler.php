<?php

namespace BannerService\Application\Banner\Save;

use BannerService\Domain\Contract\Factory\BannerFactory;
use BannerService\Domain\Contract\Repository\BannerRepository;
use BannerService\Domain\Exception\Exception;

class BannerSaveHandler
{
    /** @var BannerFactory */
    private $bannerFactory;

    /** @var BannerRepository */
    private $bannerRepository;

    /**
     * BannerSaveHandler constructor.
     * @param BannerFactory $bannerFactory
     * @param BannerRepository $bannerRepository
     */
    public function __construct(BannerFactory $bannerFactory, BannerRepository $bannerRepository)
    {
        $this->bannerFactory = $bannerFactory;
        $this->bannerRepository = $bannerRepository;
    }

    public function handle(BannerSaveCommand $command)
    {
        try{
            $banner = $this->bannerRepository->findById($command->id);
            if(!is_null($command->templateId)){
                $banner->setBannerTemplateId($command->templateId);
            }
            if(!is_null($command->programId)){
                $banner->setProgramId($command->programId);
            }
            if(!is_null($command->link)){
                $banner->setLink($command->link);
            }
            if(!is_null($command->stopShows)){
                $banner->setStopShows($command->stopShows);
            }
            if(!is_null($command->stopConversion)){
                $banner->setStopConversion($command->stopConversion);
            }
            if(!is_null($command->bannerStatus)){
                $banner->setStatus($command->bannerStatus);
            }
            if(!is_null($command->text)){
                $banner->setDescription($command->text);
            }
        }catch (Exception $e){
            $banner = $this->bannerFactory->createFreeBanner(
                $command->id,
                $command->templateId,
                $command->programId,
                $command->link,
                $command->stopShows,
                $command->stopConversion,
                $command->text
            );
        }
        $this->bannerRepository->save($banner);
    }
}