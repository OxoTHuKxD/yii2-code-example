<?php

namespace BannerService\Application\Rotator\Save;

class RotatorSaveCommand
{
    const LAYOUT_HORIZONTAL = 1;
    const LAYOUT_VERTICAL = 2;

    const TEXT_POSITION_BOTTOM = 1;
    const TEXT_POSITION_TOP = 2;

    /** @var int */
    public $id;

    /** @var int */
    public $webmasterId;

    /** @var string */
    public $name;

    /** @var int */
    public $slotCount;

    /** @var int */
    public $layout;

    /** @var bool */
    public $textExist;

    /** @var int */
    public $textPosition;

    /** @var string */
    public $borderColor;

    /**
     * @var float
     */
    public $borderWidth;

    /**
     * @var float
     */
    public $separatorWidth;

    /** @var string */
    public $backgroundColor;

    /**
     * @var float
     */
    public $paddingHorizontal;

    /**
     * @var float
     */
    public $paddingVertical;

    /** @var int[] */
    public $bannerIdList;

    /**
     * RotatorSaveCommand constructor.
     * @param int $id
     * @param int $webmasterId
     * @param string $name
     * @param int $slotCount
     * @param int $layout
     * @param bool $textExist
     * @param int $textPosition
     * @param string $borderColor
     * @param float $borderWidth
     * @param float $separatorWidth
     * @param string $backgroundColor
     * @param float $paddingHorizontal
     * @param float $paddingVertical
     * @param \int[] $bannerIdList
     */
    public function __construct($id, $webmasterId, $name, $slotCount, $layout, $textExist, $textPosition, $borderColor, $borderWidth, $separatorWidth, $backgroundColor, $paddingHorizontal, $paddingVertical, $bannerIdList)
    {
        $this->id = $id;
        $this->webmasterId = $webmasterId;
        $this->name = $name;
        $this->slotCount = $slotCount;
        $this->layout = $layout;
        $this->textExist = $textExist;
        $this->textPosition = $textPosition;
        $this->borderColor = $borderColor;
        $this->borderWidth = $borderWidth;
        $this->separatorWidth = $separatorWidth;
        $this->backgroundColor = $backgroundColor;
        $this->paddingHorizontal = $paddingHorizontal;
        $this->paddingVertical = $paddingVertical;
        $this->bannerIdList = $bannerIdList;
    }
}