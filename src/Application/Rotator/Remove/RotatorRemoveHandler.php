<?php

namespace BannerService\Application\Rotator\Remove;

use BannerService\Domain\Contract\Repository\RotatorRepository;
use BannerService\Domain\Exception\Exception;

class RotatorRemoveHandler
{
    /** @var RotatorRepository */
    private $rotatorRepository;

    /**
     * RotatorRemoveHandler constructor.
     * @param RotatorRepository $rotatorRepository
     */
    public function __construct(RotatorRepository $rotatorRepository)
    {
        $this->rotatorRepository = $rotatorRepository;
    }

    public function handle(RotatorRemoveCommand $command)
    {
        try{
            $banner = $this->rotatorRepository->findById($command->id);
            $this->rotatorRepository->remove($banner);
        }catch (Exception $e){

        }
    }
}