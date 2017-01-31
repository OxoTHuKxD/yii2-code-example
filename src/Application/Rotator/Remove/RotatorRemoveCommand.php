<?php

namespace BannerService\Application\Rotator\Remove;

class RotatorRemoveCommand
{
    /** @var int */
    public $id;


    public function __construct($id)
    {
        $this->id = $id;
    }
}