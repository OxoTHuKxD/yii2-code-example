<?php

namespace BannerService\Application\Banner\Remove;

use BannerService\Domain\Contract\Repository\BannerRepository;

class BannerRemoveValidator
{
    /** @var BannerRepository */
    private $bannerRepository;

    /**
     * BannerRemoveValidator constructor.
     * @param BannerRepository $bannerRepository
     */
    public function __construct(BannerRepository $bannerRepository)
    {
        $this->bannerRepository = $bannerRepository;
    }

    public function validate(BannerRemoveCommand $command)
    {
        $errors = [];

        if(!filter_var($command->id, FILTER_VALIDATE_INT) || $command->id<=0){
            $errors['id'][] = 'ID баннера должен быть положительным целым числом!';
        }else if(!$this->bannerRepository->hasById($command->id)){
            $errors['id'][] = 'Баннер не найден!';
        }

        return $errors;
    }
}