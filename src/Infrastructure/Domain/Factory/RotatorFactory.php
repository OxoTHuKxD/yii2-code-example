<?php

namespace BannerService\Infrastructure\Domain\Factory;

use BannerService\Domain\Entity\Rotator;
use BannerService\Domain\Proxy\RotatorProxy;
use BannerService\Domain\ValueObject\RotatorFacade;

class RotatorFactory implements \BannerService\Domain\Contract\Factory\RotatorFactory
{
    /**
     * @param int $id
     * @param int $webmasterId
     * @param string $name
     * @param int $slotCount
     * @param RotatorFacade $facade
     * @param int[] $bannerIdList
     * @return Rotator
     */
    public function createRotator($id, $webmasterId, $name, $slotCount, RotatorFacade $facade, $bannerIdList)
    {
        return \Yii::createObject([
            'class' => RotatorProxy::class,
        ],[$id, $webmasterId, $name, $slotCount, $facade, $bannerIdList]);
    }

    /**
     * @param int $layout
     * @param bool $textExist
     * @param int $textPosition
     * @param string $borderColor
     * @param float $borderWidth
     * @param float $separatorWidth
     * @param string $backgroundColor
     * @param float $paddingHorizontal
     * @param float $paddingVertical
     * @return RotatorFacade
     */
    public function createRotatorFacade($layout, $textExist, $textPosition, $borderColor, $borderWidth, $separatorWidth, $backgroundColor, $paddingHorizontal, $paddingVertical)
    {
        return \Yii::createObject([
            'class' => RotatorFacade::class,
        ],[$layout, $textExist, $textPosition, $borderColor, $borderWidth, $separatorWidth, $backgroundColor, $paddingHorizontal, $paddingVertical]);
    }

}