<?php

namespace BannerService\Infrastructure\Domain\Factory;

use BannerService\Domain\Entity\Banner;
use BannerService\Domain\Proxy\BannerProxy;

class BannerFactory implements \BannerService\Domain\Contract\Factory\BannerFactory
{
    /**
     * @param int $id
     * @param int $templateId
     * @param int $programId
     * @param string $link
     * @param int $stopShows
     * @param float $stopConversion
     * @param string $description
     * @return Banner
     */
    public function createFreeBanner($id, $templateId, $programId, $link, $stopShows, $stopConversion, $description)
    {
        return \Yii::createObject([
            'class' => BannerProxy::class,
        ],[$id, $templateId, $programId, $link, $stopShows, $stopConversion, $description]);
    }

    /**
     * @param int $id
     * @param int $rotatorId
     * @param int $templateId
     * @param int $programId
     * @param string $link
     * @param int $stopShows
     * @param float $stopConversion
     * @param string $description
     * @return Banner
     */
    public function createRotatorBanner($id, $rotatorId, $templateId, $programId, $link, $stopShows, $stopConversion, $description)
    {
        /** @var Banner $banner */
        $banner =  \Yii::createObject([
            'class' => BannerProxy::class,
        ],[$id, $templateId, $programId, $link, $stopShows, $stopConversion, $description]);
        $banner->assignRotator($rotatorId);
        return $banner;
    }

}