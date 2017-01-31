<?php

namespace BannerService\Application\Banner\Save;

use BannerService\Domain\Contract\Repository\BannerRepository;
use BannerService\Domain\Contract\Repository\BannerTemplateRepository;
use BannerService\Domain\Contract\Repository\ProgramRepository;

class BannerSaveValidator
{
    /** @var BannerRepository */
    private $bannerRepository;

    /** @var BannerTemplateRepository */
    private $bannerTemplateRepository;

    /** @var ProgramRepository */
    private $programRepository;

    /**
     * BannerSaveValidator constructor.
     * @param BannerRepository $bannerRepository
     * @param BannerTemplateRepository $bannerTemplateRepository
     * @param ProgramRepository $programRepository
     */
    public function __construct(BannerRepository $bannerRepository, BannerTemplateRepository $bannerTemplateRepository, ProgramRepository $programRepository)
    {
        $this->bannerRepository = $bannerRepository;
        $this->bannerTemplateRepository = $bannerTemplateRepository;
        $this->programRepository = $programRepository;
    }

    public function validate(BannerSaveCommand $command)
    {
        $errors = [];

        if(!filter_var($command->id, FILTER_VALIDATE_INT) || $command->id<=0){
            $errors['id'][] = 'ID баннера должен быть положительным целым числом!';
        }

        if(!$this->bannerRepository->hasById($command->id)){
            $this->validateNotExist($command, $errors);
        }

        if(!is_null($command->templateId)) {
            if (!filter_var($command->templateId, FILTER_VALIDATE_INT) || $command->templateId <= 0) {
                $errors['templateId'][] = 'ID шаблона баннера должен быть положительным целым числом!';
            }

            if (!$this->bannerTemplateRepository->hasById($command->templateId)){
                $errors['templateId'][] = 'Шаблона баннера с таким ID не существует!';
            }
        }

        if(!is_null($command->programId)) {
            if (!filter_var($command->programId, FILTER_VALIDATE_INT) || $command->programId <= 0) {
                $errors['programId'][] = 'ID программы должен быть положительным целым числом!';
            }

            if (!$this->programRepository->hasById($command->programId)){
                $errors['programId'][] = 'Программа с таким ID не существует!';
            }
        }

        if(!is_null($command->link)) {
            if (!filter_var($command->link, FILTER_VALIDATE_URL)){
                $errors['link'][] = 'Передан некорректный url в качестве адреса ссылки!';
            }
        }

        if(!is_null($command->stopShows)) {
            if (!(filter_var($command->stopShows, FILTER_VALIDATE_INT) || $command->stopShows === 0)  || $command->stopShows < 0) {
                $errors['stopShows'][] = 'Кол-во показов до остановки должно быть целым положительным числом или 0!';
            }
        }

        if(!is_null($command->stopConversion)) {
            if (!(filter_var($command->stopConversion, FILTER_VALIDATE_FLOAT) || $command->stopConversion === 0) || $command->stopConversion < 0) {
                $errors['stopConversion'][] = 'Уровень конверсии остановки должен быть действительным положительным числом или 0!';
            }
        }

        if(!is_null($command->bannerStatus)) {
            if (!in_array($command->bannerStatus, [$command::STATUS_PLAY, $command::STATUS_STOP_CONVERSION, $command::STATUS_STOP_SHOW, $command::STATUS_STOP_WEBMASTER])){
                $errors['bannerStatus'][] = 'Статус баннера может принимать только значения из списка: (
                '.$command::STATUS_PLAY.' - идут показы,
                '.$command::STATUS_STOP_CONVERSION.' - остановлен по низкой конверсии,
                '.$command::STATUS_STOP_SHOW.' - остановлен по кол-ву показов,
                '.$command::STATUS_STOP_WEBMASTER.' - остановлен вебмастером
                )!';
            }
        }

        return $errors;
    }

    private function validateNotExist(BannerSaveCommand $command, &$errors)
    {
        if(!$command->templateId){
            $errors['templateId'][] = 'Не передан id шаблона баннера для нового баннера!';
        }

        if(!$command->programId){
            $errors['programId'][] = 'Не передан id программы для нового баннера!';
        }

        if(!$command->link){
            $errors['link'][] = 'Не передан адрес ссылки для нового баннера!';
        }

        if(is_null($command->stopShows)){
            $errors['stopShows'][] = 'Не передано кол-во показов до остановки для нового баннера!';
        }

        if(is_null($command->stopConversion)){
            $errors['stopConversion'][] = 'Не передан уровень конверсии остановки для нового баннера!';
        }

        if(!$command->bannerStatus){
            $errors['bannerStatus'][] = 'Не передан статус для нового баннера!';
        }

        if(is_null($command->text)){
            $errors['text'][] = 'Не передан текст для нового баннера!';
        }
    }
}