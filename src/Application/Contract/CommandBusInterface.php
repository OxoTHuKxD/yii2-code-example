<?php

namespace BannerService\Application\Contract;

interface CommandBusInterface
{
    public function execute($command);
}