<?php

namespace BannerService\Application\Banner\Save;

class BannerSaveCommand
{
    const STATUS_PLAY = 1;
    const STATUS_STOP_SHOW = 2;
    const STATUS_STOP_CONVERSION = 3;
    const STATUS_STOP_WEBMASTER = 4;

    /** @var int */
    public $id;

    /** @var int */
    public $templateId;


    /** @var int */
    public $programId;

    /** @var string */
    public $link;

    /** @var int */
    public $stopShows;

    /** @var float */
    public $stopConversion;

    /** @var int */
    public $bannerStatus;

    /** @var string */
    public $text;

    /**
     * BannerSaveCommand constructor.
     * @param int $id
     * @param int $templateId
     * @param int $programId
     * @param string $link
     * @param int $stopShows
     * @param float $stopConversion
     * @param int $bannerStatus
     * @param string $text
     */
    public function __construct($id, $templateId, $programId, $link, $stopShows, $stopConversion, $bannerStatus, $text)
    {
        $this->id = $id;
        $this->templateId = $templateId;
        $this->programId = $programId;
        $this->link = $link;
        $this->stopShows = $stopShows;
        $this->stopConversion = $stopConversion;
        $this->bannerStatus = $bannerStatus;
        $this->text = $text;
    }
}