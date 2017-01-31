<?php

namespace app\controllers;

use BannerService\Application\Banner\Remove\BannerRemoveCommand;
use BannerService\Application\Banner\Save\BannerSaveCommand;
use BannerService\Application\BannerTemplate\Remove\BannerTemplateRemoveCommand;
use BannerService\Application\BannerTemplate\Save\BannerTemplateSaveCommand;
use BannerService\Application\Contract\CommandBusInterface;
use BannerService\Application\Exception\ValidationException;
use BannerService\Application\Program\Remove\ProgramRemoveCommand;
use BannerService\Application\Program\Save\ProgramSaveCommand;
use BannerService\Application\Rotator\Remove\RotatorRemoveCommand;
use BannerService\Application\Rotator\Save\RotatorSaveCommand;
use BannerService\Application\Webmaster\Remove\WebmasterRemoveCommand;
use BannerService\Application\Webmaster\Save\WebmasterSaveCommand;
use yii\web\Controller;
use yii\web\Response;

class ApiController extends Controller
{
    /** @var array */
    protected $requestData;

    /** @var CommandBusInterface */
    protected $commandBus;

    /**
     * @param string $id
     * @param \yii\base\Module $module
     * @param CommandBusInterface $commandBus
     * @param array $config
     */
    public function __construct($id, $module, CommandBusInterface $commandBus, $config = [])
    {
        $this->commandBus = $commandBus;
        parent::__construct($id, $module, $config);
    }

    private function checkApiKey()
    {
        return \Yii::$app->params['alebaApiKey'] === \Yii::$app->request->post('apiKey');
    }

    public function beforeAction($action)
    {
        $this->enableCsrfValidation = false;
        \Yii::$app->response->format = Response::FORMAT_JSON;
        if($this->checkApiKey()) {
            $this->requestData = \Yii::$app->request->post('data');
            return parent::beforeAction($action);
        }
        \Yii::$app->response->data = ['result' => false, 'errors' => ['Неверный ApiKey']];
        return false;
    }

    /**
     * @return array
     */
    public function actionWebmasterPlatformSave()
    {
        $errors = [];
        foreach($this->requestData as $key=>$val){
            if($val !== false){
                try {
                    $this->commandBus->execute(new WebmasterSaveCommand($key, $val['platformList']));
                }catch (ValidationException $e){
                    $errors[$key] = $e->getErrors();
                }
            }else{
                try {
                    $this->commandBus->execute(new WebmasterRemoveCommand($key));
                }catch (ValidationException $e){
                    $errors[$key] = $e->getErrors();
                }
            }
        }
        return count($errors) === 0 ? ['result' => true] : ['result' => false, 'errors' => $errors];
    }

    /**
     * @return array
     */
    public function actionProgramSave()
    {
        $errors = [];
        foreach($this->requestData as $key=>$val){
            if($val !== false){
                try {
                    $this->commandBus->execute(new ProgramSaveCommand($key, intval($val['statusEnum'])));
                }catch (ValidationException $e){
                    $errors[$key] = $e->getErrors();
                }
            }else{
                try {
                    $this->commandBus->execute(new ProgramRemoveCommand($key));
                }catch (ValidationException $e){
                    $errors[$key] = $e->getErrors();
                }
            }
        }
        return count($errors) === 0 ? ['result' => true] : ['result' => false, 'errors' => $errors];
    }

    /**
     * @return array
     */
    public function actionTemplateBannerSave()
    {
        $errors = [];
        foreach($this->requestData as $key=>$val){
            if($val !== false){
                try {
                    $this->commandBus->execute(new BannerTemplateSaveCommand($key, $val['image'] ? $val['image'] : null, $val['typeEnum'] ? intval($val['typeEnum']) : null));
                }catch (ValidationException $e){
                    $errors[$key] = $e->getErrors();
                }
            }else{
                try {
                    $this->commandBus->execute(new BannerTemplateRemoveCommand($key));
                }catch (ValidationException $e){
                    $errors[$key] = $e->getErrors();
                }
            }
        }
        return count($errors) === 0 ? ['result' => true] : ['result' => false, 'errors' => $errors];
    }

    /**
     * @return array
     */
    public function actionBannerSave()
    {
        $errors = [];
        foreach($this->requestData as $key=>$val){
            if($val !== false){
                try {
                    $this->commandBus->execute(new BannerSaveCommand(
                        $key,
                        $val['templateId'] ? intval($val['templateId']) : null,
                        $val['programId'] ? intval($val['programId']) : null,
                        $val['link'] ? $val['link'] : null,
                        array_key_exists('stopShows', $val) ? ($val['stopShows'] === false ? 0 : $val['stopShows']) : null,
                        array_key_exists('stopConversion', $val) ? ($val['stopConversion'] === false ? 0 : $val['stopConversion']) : null,
                        $val['bannerStatusEnum'] ? intval($val['bannerStatusEnum']) : null,
                        array_key_exists('text', $val) ? $val['text'] : null
                    ));
                }catch (ValidationException $e){
                    $errors[$key] = $e->getErrors();
                }
            }else{
                try {
                    $this->commandBus->execute(new BannerRemoveCommand($key));
                }catch (ValidationException $e){
                    $errors[$key] = $e->getErrors();
                }
            }
        }
        return count($errors) === 0 ? ['result' => true] : ['result' => false, 'errors' => $errors];
    }

    /**
     * @return array
     */
    public function actionRotatorSave()
    {
        $errors = [];
        foreach($this->requestData as $key=>$val){
            if($val !== false){
                try {
                    $this->commandBus->execute(new RotatorSaveCommand(
                        $key,
                        array_key_exists('webmasterId', $val) ? intval($val['webmasterId']) : null,
                        $val['name'] ? $val['name'] : null,
                        array_key_exists('slotCount', $val) ? intval($val['slotCount']) : null,
                        $val['layoutEnum'] ? intval($val['layoutEnum']) : null,
                        array_key_exists('textExist', $val) ? $val['textExist'] : null,
                        $val['textPositionEnum'] ? intval($val['textPositionEnum']) : null,
                        array_key_exists('borderColor', $val) ? $val['borderColor'] : null,
                        array_key_exists('borderWidth', $val) ? $val['borderWidth'] : null,
                        array_key_exists('separatorWidth', $val) ? $val['separatorWidth'] : null,
                        array_key_exists('backgroundColor', $val) ? $val['backgroundColor'] : null,
                        array_key_exists('paddingHorizontal', $val) ? $val['paddingHorizontal'] : null,
                        array_key_exists('paddingVertical', $val) ? $val['paddingVertical'] : null,
                        array_key_exists('bannerIdList', $val) ? $val['bannerIdList'] : null
                    ));
                }catch (ValidationException $e){
                    $errors[$key] = $e->getErrors();
                }
            }else{
                try {
                    $this->commandBus->execute(new RotatorRemoveCommand($key));
                }catch (ValidationException $e){
                    $errors[$key] = $e->getErrors();
                }
            }
        }
        return count($errors) === 0 ? ['result' => true] : ['result' => false, 'errors' => $errors];
    }
}