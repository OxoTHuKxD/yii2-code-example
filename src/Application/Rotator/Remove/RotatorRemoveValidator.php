<?php

namespace BannerService\Application\Rotator\Remove;

use BannerService\Domain\Contract\Repository\RotatorRepository;

class RotatorRemoveValidator
{
    /** @var RotatorRepository */
    private $rotatorRepository;

    /**
     * RotatorRemoveValidator constructor.
     * @param RotatorRepository $rotatorRepository
     */
    public function __construct(RotatorRepository $rotatorRepository)
    {
        $this->rotatorRepository = $rotatorRepository;
    }

    public function validate(RotatorRemoveCommand $command)
    {
        $errors = [];

        if(!filter_var($command->id, FILTER_VALIDATE_INT) || $command->id<=0){
            $errors['id'][] = 'ID ротатора должен быть положительным целым числом!';
        }else if(!$this->rotatorRepository->hasById($command->id)){
            $errors['id'][] = 'Ротатор не найден!';
        }

        return $errors;
    }
}