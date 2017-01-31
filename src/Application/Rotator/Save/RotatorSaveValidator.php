<?php

namespace BannerService\Application\Rotator\Save;

use BannerService\Domain\Contract\Repository\BannerRepository;
use BannerService\Domain\Contract\Repository\RotatorRepository;
use BannerService\Domain\Contract\Repository\WebmasterRepository;

class RotatorSaveValidator
{
    /** @var RotatorRepository */
    private $rotatorRepository;

    /** @var WebmasterRepository */
    private $webmasterRepository;

    /** @var BannerRepository */
    private $bannerRepository;

    /**
     * RotatorSaveValidator constructor.
     * @param RotatorRepository $rotatorRepository
     * @param WebmasterRepository $webmasterRepository
     * @param BannerRepository $bannerRepository
     */
    public function __construct(RotatorRepository $rotatorRepository, WebmasterRepository $webmasterRepository, BannerRepository $bannerRepository)
    {
        $this->rotatorRepository = $rotatorRepository;
        $this->webmasterRepository = $webmasterRepository;
        $this->bannerRepository = $bannerRepository;
    }

    public function validate(RotatorSaveCommand $command)
    {
        $errors = [];

        if(!filter_var($command->id, FILTER_VALIDATE_INT) || $command->id<=0){
            $errors['id'][] = 'ID ротатора должен быть положительным целым числом!';
        }

        if(!$this->rotatorRepository->hasById($command->id)){
            $this->validateNotExist($command, $errors);
        }

        if(!is_null($command->webmasterId)) {
            if (!filter_var($command->webmasterId, FILTER_VALIDATE_INT) || $command->webmasterId <= 0) {
                $errors['webmasterId'][] = 'ID вебмастера должен быть положительным целым числом!';
            }else {
                if (!$this->webmasterRepository->hasById($command->webmasterId)) {
                    $errors['webmasterId'][] = 'Вебмстера с таким ID не существует!';
                }
            }
        }

        if(!is_null($command->name)) {
            if(strlen($command->name) === 0)
                $errors['name'][] = 'Имя ротатора не может быть пустым!';
        }

        if(!is_null($command->slotCount)) {
            if (!filter_var($command->slotCount, FILTER_VALIDATE_INT) || $command->slotCount <= 0) {
                $errors['slotCount'][] = 'Кол-во слотов под баннеры должно быть положительным целым числом!';
            }
        }

        if(!is_null($command->layout)) {
            if (!in_array($command->layout, [$command::LAYOUT_HORIZONTAL, $command::LAYOUT_VERTICAL])){
                $errors['layout'][] = 'Вид отображения может принимать только значения из списка: (
                '.$command::LAYOUT_HORIZONTAL.' - горизонтальный,
                '.$command::LAYOUT_VERTICAL.' - вертикальный
                )!';
            }
        }

        if(!is_null($command->textExist)) {
            if ($command->textExist !== true && $command->textExist !== false) {
                $errors['textExist'][] = 'Параметр отображение текста должен быть булевым(допустимы только true и false)!!';
            }
        }

        if(!is_null($command->textPosition)) {
            if (!in_array($command->textPosition, [$command::TEXT_POSITION_BOTTOM, $command::TEXT_POSITION_TOP])){
                $errors['textPosition'][] = 'Положение текста баннеров может принимать только значения из списка: (
                '.$command::TEXT_POSITION_BOTTOM.' - под баннером,
                '.$command::TEXT_POSITION_TOP.' - над баннером
                )!';
            }
        }

        if(!is_null($command->borderWidth)) {
            if (!(filter_var($command->borderWidth, FILTER_VALIDATE_FLOAT) || $command->borderWidth === 0) || $command->borderWidth < 0) {
                $errors['borderWidth'][] = 'Толщина границ должна быть действительным положительным числом или 0!';
            }
        }

        if(!is_null($command->separatorWidth)) {
            if (!(filter_var($command->separatorWidth, FILTER_VALIDATE_FLOAT) || $command->separatorWidth === 0) || $command->separatorWidth < 0) {
                $errors['separatorWidth'][] = 'Толщина разделителя баннеров должна быть действительным положительным числом или 0!';
            }
        }

        if(!is_null($command->paddingHorizontal)) {
            if (!(filter_var($command->paddingHorizontal, FILTER_VALIDATE_FLOAT) || $command->paddingHorizontal === 0) || $command->paddingHorizontal < 0) {
                $errors['paddingHorizontal'][] = 'Горизонтальный padding должен быть действительным положительным числом или 0!';
            }
        }

        if(!is_null($command->paddingVertical)) {
            if (!(filter_var($command->paddingVertical, FILTER_VALIDATE_FLOAT) || $command->paddingVertical === 0) || $command->paddingVertical < 0) {
                $errors['paddingVertical'][] = 'Вертиальный padding должен быть действительным положительным числом или 0!';
            }
        }

        if(!is_null($command->bannerIdList)) {
            if(!is_array($command->bannerIdList)){
                $errors['bannerIdList'][] = 'Список баннеров должен быть массивом из целых положительных чисел!';
            }else{
                foreach($command->bannerIdList as $val){
                    if(!filter_var($val, FILTER_VALIDATE_INT) || $val<=0){
                        $errors['bannerIdList'][$val][] = 'ID баннера в ротаторе должен быть положительным целым числом!';
                    }else{
                        if(!$this->bannerRepository->hasById($val)){
                            $errors['bannerIdList'][$val][] = 'Баннера с таким ID не существует!';
                        }
                    }
                }
            }
        }

        return $errors;
    }

    private function validateNotExist(RotatorSaveCommand $command, &$errors)
    {
        if(is_null($command->webmasterId)){
            $errors['webmasterId'][] = 'Не передан id вебмастера для нового ротатора!';
        }

        if(is_null($command->name)){
            $errors['name'][] = 'Не передано название для нового ротатора!';
        }

        if(is_null($command->slotCount)){
            $errors['slotCount'][] = 'Не передано количество слотов под баннеры для нового ротатора!';
        }

        if(is_null($command->layout)){
            $errors['layout'][] = 'Не передан вид отображения нового ротатора!';
        }

        if(is_null($command->textExist)){
            $errors['textExist'][] = 'Не передан параметр отображения текста баннеров нового ротатора!';
        }

        if(is_null($command->textPosition)){
            $errors['textPosition'][] = 'Не передана позиция текста баннеров нового ротатора!';
        }

        if(is_null($command->borderColor)){
            $errors['borderColor'][] = 'Не передан цвет границ нового ротатора!';
        }

        if(is_null($command->borderWidth)){
            $errors['borderWidth'][] = 'Не передана толщина границ нового ротатора!';
        }

        if(is_null($command->separatorWidth)){
            $errors['separatorWidth'][] = 'Не передана толщина разделителя баннеров нового ротатора!';
        }

        if(is_null($command->backgroundColor)){
            $errors['backgroundColor'][] = 'Не передан background цвет нового ротатора!';
        }

        if(is_null($command->paddingHorizontal)){
            $errors['paddingHorizontal'][] = 'Не передан горизонтальный padding нового ротатора!';
        }

        if(is_null($command->paddingVertical)){
            $errors['paddingVertical'][] = 'Не передан вертиальный padding нового ротатора!';
        }

        if(is_null($command->bannerIdList)){
            $errors['bannerIdList'][] = 'Не передан список баннеров нового ротатора!';
        }
    }
}