<?php

namespace BannerService\Domain\Contract\Factory;

use BannerService\Domain\Entity\Banner;

interface BannerFactory
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
    public function createFreeBanner($id, $templateId, $programId, $link, $stopShows, $stopConversion, $description);

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
    public function createRotatorBanner($id, $rotatorId, $templateId, $programId, $link, $stopShows, $stopConversion, $description);
}