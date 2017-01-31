<?php

namespace BannerService\Application\Rotator\Save;

use BannerService\Domain\Contract\Factory\RotatorFactory;
use BannerService\Domain\Contract\Repository\RotatorRepository;
use BannerService\Domain\Exception\Exception;

class RotatorSaveHandler
{
    /** @var RotatorFactory */
    private $rotatorFactory;

    /** @var RotatorRepository */
    private $rotatorRepository;

    /**
     * RotatorSaveHandler constructor.
     * @param RotatorFactory $rotatorFactory
     * @param RotatorRepository $rotatorRepository
     */
    public function __construct(RotatorFactory $rotatorFactory, RotatorRepository $rotatorRepository)
    {
        $this->rotatorFactory = $rotatorFactory;
        $this->rotatorRepository = $rotatorRepository;
    }

    public function handle(RotatorSaveCommand $command)
    {
        try{
            $rotator = $this->rotatorRepository->findById($command->id);
            if(!is_null($command->webmasterId)){
                $rotator->setWebmasterId($command->webmasterId);
            }
            if(!is_null($command->name)){
                $rotator->setName($command->name);
            }
            if(!is_null($command->slotCount)){
                $rotator->setSlotCount($command->slotCount);
            }

            $facade = $rotator->getRotatorFacade();
            if(!is_null($command->layout)){
                $facade->setLayout($command->layout);
            }
            if(!is_null($command->textExist)){
                $facade->setTextExist($command->textExist);
            }
            if(!is_null($command->textPosition)){
                $facade->setTextPosition($command->textPosition);
            }
            if(!is_null($command->borderColor)){
                $facade->setBorderColor($command->borderColor);
            }
            if(!is_null($command->borderWidth)){
                $facade->setBorderWidth($command->borderWidth);
            }
            if(!is_null($command->separatorWidth)){
                $facade->setSeparatorWidth($command->separatorWidth);
            }
            if(!is_null($command->backgroundColor)){
                $facade->setBackgroundColor($command->backgroundColor);
            }
            if(!is_null($command->paddingHorizontal)){
                $facade->setPaddingHorizontal($command->paddingHorizontal);
            }
            if(!is_null($command->paddingVertical)){
                $facade->setPaddingVertical($command->paddingVertical);
            }
            $rotator->setRotatorFacade($facade);

            if(!is_null($command->bannerIdList)){
                $rotator->setBannerIdList($command->bannerIdList);
            }

        }catch (Exception $e){
            $rotator = $this->rotatorFactory->createRotator(
                $command->id,
                $command->webmasterId,
                $command->name,
                $command->slotCount,
                $this->rotatorFactory->createRotatorFacade(
                    $command->layout,
                    $command->textExist,
                    $command->textPosition,
                    $command->borderColor,
                    $command->borderWidth,
                    $command->separatorWidth,
                    $command->backgroundColor,
                    $command->paddingHorizontal,
                    $command->paddingVertical
                ),
                $command->bannerIdList
            );
        }
        $this->rotatorRepository->save($rotator);
    }
}