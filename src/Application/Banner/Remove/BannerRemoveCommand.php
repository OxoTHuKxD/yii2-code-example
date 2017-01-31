<?php

namespace BannerService\Application\Banner\Remove;

class BannerRemoveCommand
{
    /** @var int */
    public $id;


    public function __construct($id)
    {
        $this->id = $id;
    }
}