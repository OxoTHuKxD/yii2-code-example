<?php

namespace BannerService\Infrastructure\Application;

use BannerService\Application\Contract\CommandBusInterface;
use BannerService\Application\Exception\ValidationException;

class ValidationCommandBus implements CommandBusInterface
{
    private $next;

    public function __construct(CommandBusInterface $next) {
        $this->next = $next;
    }

    public function execute($command) {
        $validator = $this->resolveValidator($command);
        $errors = call_user_func($validator, $command);
        if (count($errors)>0) {
            throw new ValidationException($errors);
        }
        $this->next->execute($command);
    }

    private function resolveValidator($command) {
        return [\Yii::createObject(substr(get_class($command), 0, -7) . 'Validator'), 'validate'];
    }
}