<?php

namespace BannerService\Domain\Entity;
use BannerService\Domain\Exception\Exception;

/**
 * Class Banner
 * @package BannerService\Domain\Entity
 */
class Banner
{
    const STATUS_PLAY = 1;
    const STATUS_STOP_SHOW = 2;
    const STATUS_STOP_CONVERSION = 3;
    const STATUS_STOP_WEBMASTER = 4;

    /**
     * @var int
     */
    private $id;

    /**
     * @var int
     */
    private $rotatorId;

    /**
     * @var int
     */
    private $bannerTemplateId;

    /**
     * @var int
     */
    private $programId;

    /**
     * @var string
     */
    private $link;

    /**
     * @var int
     */
    private $status;

    /**
     * @var int
     */
    private $stopShows;

    /**
     * @var float
     */
    private $stopConversion;

    /**
     * @var string
     */
    private $description;

    /**
     * @param int $id
     * @param int $bannerTemplateId
     * @param int $programId
     * @param string $link
     * @param int $stopShows
     * @param float $stopConversion
     * @param string $description
     */
    public function __construct($id, $bannerTemplateId, $programId, $link, $stopShows, $stopConversion, $description)
    {
        $this->id = $id;
        $this->rotatorId = 0;
        $this->bannerTemplateId = $bannerTemplateId;
        $this->programId = $programId;
        $this->link = $link;
        $this->status = self::STATUS_PLAY;
        $this->stopShows = $stopShows;
        $this->stopConversion = $stopConversion;
        $this->description = $description;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getRotatorId()
    {
        return $this->rotatorId;
    }

    /**
     * @return int
     */
    public function getBannerTemplateId()
    {
        return $this->bannerTemplateId;
    }

    /**
     * @return int
     */
    public function getProgramId()
    {
        return $this->programId;
    }

    /**
     * @return string
     */
    public function getLink()
    {
        return $this->link;
    }

    /**
     * @return int
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @return int
     */
    public function getStopShows()
    {
        return $this->stopShows;
    }

    /**
     * @return float
     */
    public function getStopConversion()
    {
        return $this->stopConversion;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @return Rotator
     */
    public function getRotator()
    {
        return null;
    }

    /**
     * @return BannerTemplate
     */
    public function getBannerTemplate()
    {
        return null;
    }

    /**
     * @return Program
     */
    public function getProgram()
    {
        return null;
    }

    /**
     * @param int $rotatorId
     */
    public function assignRotator($rotatorId)
    {
        $this->rotatorId = $rotatorId;
    }

    /**
     *
     */
    public function removeRotator()
    {
        $this->rotatorId = 0;
    }

    /**
     * @return bool
     */
    public function isPlay()
    {
        return $this->status === self::STATUS_PLAY;
    }

    /**
     * @param int $rotatorId
     */
    public function setRotatorId($rotatorId)
    {
        $this->rotatorId = $rotatorId;
    }

    /**
     * @param int $bannerTemplateId
     */
    public function setBannerTemplateId($bannerTemplateId)
    {
        $this->bannerTemplateId = $bannerTemplateId;
    }

    /**
     * @param int $programId
     */
    public function setProgramId($programId)
    {
        $this->programId = $programId;
    }

    /**
     * @param string $link
     */
    public function setLink($link)
    {
        $this->link = $link;
    }

    /**
     * @param int $status
     * @throws Exception
     */
    public function setStatus($status)
    {
        $this->checkStatus($status);
        $this->status = $status;
    }

    /**
     * @param int $stopShows
     */
    public function setStopShows($stopShows)
    {
        $this->stopShows = $stopShows;
    }

    /**
     * @param float $stopConversion
     */
    public function setStopConversion($stopConversion)
    {
        $this->stopConversion = $stopConversion;
    }

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @throws Exception
     */
    public function play()
    {
        $this->checkAlreadyPlay();
        $this->status = self::STATUS_PLAY;
    }

    /**
     * @throws Exception
     */
    public function stopByShow()
    {
        $this->checkAlreadyStop();
        $this->status = self::STATUS_STOP_SHOW;
    }

    /**
     * @throws Exception
     */
    public function stopByConversion()
    {
        $this->checkAlreadyStop();
        $this->status = self::STATUS_STOP_CONVERSION;
    }

    /**
     * @throws Exception
     */
    public function stopByWebmaster()
    {
        $this->checkAlreadyStop();
        $this->status = self::STATUS_STOP_WEBMASTER;
    }

    /**
     * @throws Exception
     */
    private function checkAlreadyPlay()
    {
        if($this->status === self::STATUS_PLAY){
            throw new Exception('Баннер уже запущен!');
        }
    }

    /**
     * @throws Exception
     */
    private function checkAlreadyStop()
    {
        if($this->status !== self::STATUS_PLAY){
            throw new Exception('Баннер уже остановлен!');
        }
    }

    /**
     * @param int $status
     * @throws Exception
     */
    private function checkStatus($status)
    {
        if(!in_array($status, [self::STATUS_STOP_WEBMASTER, self::STATUS_PLAY, self::STATUS_STOP_CONVERSION, self::STATUS_STOP_SHOW])){
            throw new Exception('Некорректный статус баннера!');
        }
    }
}
