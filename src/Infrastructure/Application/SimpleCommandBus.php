<?php

namespace BannerService\Infrastructure\Application;

use BannerService\Application\Contract\CommandBusInterface;

class SimpleCommandBus implements CommandBusInterface
{
    public function execute($command)
    {
        $handler = $this->resolveHandler($command);
        call_user_func($handler, $command);
    }

    private function resolveHandler($command)
    {
        return [\Yii::createObject(substr(get_class($command), 0, -7) . 'Handler'), 'handle'];
    }
}