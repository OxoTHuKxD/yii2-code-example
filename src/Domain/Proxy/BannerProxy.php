<?php

namespace BannerService\Domain\Proxy;

use BannerService\Domain\Contract\Repository\BannerTemplateRepository;
use BannerService\Domain\Contract\Repository\ProgramRepository;
use BannerService\Domain\Contract\Repository\RotatorRepository;
use BannerService\Domain\Entity\Banner;
use BannerService\Domain\Entity\BannerTemplate;
use BannerService\Domain\Entity\Program;
use BannerService\Domain\Entity\Rotator;

class BannerProxy extends Banner
{
    /**
     * @var Rotator
     */
    private $rotator = null;

    /**
     * @var BannerTemplate
     */
    private $bannerTemplate = null;

    /**
     * @var Program
     */
    private $program = null;

    /**
     * @var RotatorRepository
     */
    private $rotatorRepository;

    /**
     * @var BannerTemplateRepository
     */
    private $bannerTemplateRepository;

    /**
     * @var ProgramRepository
     */
    private $programRepository;

    /**
     * @param int $id
     * @param int $bannerTemplateId
     * @param int $programId
     * @param string $link
     * @param int $stopShows
     * @param float $stopConversion
     * @param string $description
     */
    public function __construct($id, $bannerTemplateId, $programId, $link, $stopShows, $stopConversion, $description, RotatorRepository $rotatorRepository, BannerTemplateRepository $bannerTemplateRepository, ProgramRepository $programRepository)
    {
        parent::__construct($id, $bannerTemplateId, $programId, $link, $stopShows, $stopConversion, $description);
        $this->rotatorRepository = $rotatorRepository;
        $this->bannerTemplateRepository = $bannerTemplateRepository;
        $this->programRepository = $programRepository;
    }

    /**
     * @return Rotator
     */
    public function getRotator()
    {
        if($this->rotator === null && $this->getRotatorId() !== 0){
            $this->rotator = $this->rotatorRepository->findById($this->getRotatorId());
        }
        return $this->rotator;
    }

    /**
     * @return BannerTemplate
     */
    public function getBannerTemplate()
    {
        if($this->bannerTemplate === null){
            $this->bannerTemplate = $this->bannerTemplateRepository->findById($this->getBannerTemplateId());
        }
        return $this->bannerTemplate;
    }

    /**
     * @return Program
     */
    public function getProgram()
    {
        if($this->program === null){
            $this->program = $this->programRepository->findById($this->getProgramId());
        }
        return $this->program;
    }

}