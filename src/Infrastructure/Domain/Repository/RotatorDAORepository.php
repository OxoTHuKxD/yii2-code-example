<?php

namespace BannerService\Infrastructure\Domain\Repository;

use BannerService\Domain\Contract\Repository\BannerRepository;
use BannerService\Domain\Contract\Repository\RotatorRepository;
use BannerService\Domain\Entity\Rotator;
use BannerService\Domain\Exception\Exception;
use BannerService\Infrastructure\Domain\Factory\RotatorFactory;
use yii\db\Query;

class RotatorDAORepository implements RotatorRepository
{
    /**
     * @var string
     */
    private $tableName;

    /**
     * @var BannerRepository
     */
    private $bannerRepository;

    /**
     * RotatorDAORepository constructor.
     * @param string $tableName
     * @param BannerRepository $bannerRepository
     */
    public function __construct($tableName, BannerRepository $bannerRepository)
    {
        $this->tableName = $tableName;
        $this->bannerRepository = $bannerRepository;
    }

    /**
     * @param int $id
     * @return Rotator
     * @throws Exception
     */
    public function findById($id)
    {
        $query = new Query();
        $res = $query->select('*')
            ->from($this->tableName)
            ->where(['id' => $id])
            ->one();
        if(!$res){
            throw new Exception('Ротатор не найден!');
        }
        $factory = new RotatorFactory();
        $rotatorFacade = $factory->createRotatorFacade(
            intval($res['layout']),
            (intval($res['text_exist']) === 1 ? true : false),
            intval($res['text_position']),
            $res['border_color'],
            floatval($res['border_width']),
            floatval($res['separator_width']),
            $res['background_color'],
            floatval($res['padding_horizontal']),
            floatval($res['padding_vertical'])
        );
        return $factory->createRotator(
            intval($res['id']),
            intval($res['webmaster_id']),
            $res['name'],
            intval($res['slot_count']),
            $rotatorFacade,
            $this->bannerRepository->findIdAllByRotatorId($res['id'])
        );
    }

    /**
     * @param $id
     * @return bool
     */
    public function hasById($id)
    {
        $query = new Query();
        return $query->select('id')
            ->from($this->tableName)
            ->where(['id' => $id])
            ->exists();
    }

    /**
     * @param Rotator $entity
     */
    public function save(Rotator $entity)
    {
        if($this->hasById($entity->getId()))
            $this->update($entity);
        else
            $this->add($entity);
    }

    /**
     * @param Rotator $entity
     */
    public function remove(Rotator $entity)
    {
        $db = \Yii::$app->db;
        $db->createCommand()->delete($this->tableName, ['id' => $entity->getId()])->execute();
    }

    private function add(Rotator $entity)
    {
        $db = \Yii::$app->db;
        $db->createCommand()->insert($this->tableName, [
            'id' => $entity->getId(),
            'webmaster_id' => $entity->getWebmasterId(),
            'name' => $entity->getName(),
            'slot_count' => $entity->getSlotCount(),
            'layout' => $entity->getRotatorFacade()->getLayout(),
            'text_exist' => $entity->getRotatorFacade()->isTextExist() ? 1 : 0,
            'text_position' => $entity->getRotatorFacade()->getTextPosition(),
            'border_color' => $entity->getRotatorFacade()->getBorderColor(),
            'border_width' => $entity->getRotatorFacade()->getBorderWidth(),
            'separator_width' => $entity->getRotatorFacade()->getSeparatorWidth(),
            'background_color' => $entity->getRotatorFacade()->getBackgroundColor(),
            'padding_horizontal' => $entity->getRotatorFacade()->getPaddingHorizontal(),
            'padding_vertical' => $entity->getRotatorFacade()->getPaddingVertical()
        ])->execute();
        $this->bannerRepository->saveBannersRotatorAssign($entity);
    }

    private function update(Rotator $entity)
    {
        $db = \Yii::$app->db;
        $db->createCommand()->update($this->tableName, [
            'webmaster_id' => $entity->getWebmasterId(),
            'name' => $entity->getName(),
            'slot_count' => $entity->getSlotCount(),
            'layout' => $entity->getRotatorFacade()->getLayout(),
            'text_exist' => $entity->getRotatorFacade()->isTextExist() ? 1 : 0,
            'text_position' => $entity->getRotatorFacade()->getTextPosition(),
            'border_color' => $entity->getRotatorFacade()->getBorderColor(),
            'border_width' => $entity->getRotatorFacade()->getBorderWidth(),
            'separator_width' => $entity->getRotatorFacade()->getSeparatorWidth(),
            'background_color' => $entity->getRotatorFacade()->getBackgroundColor(),
            'padding_horizontal' => $entity->getRotatorFacade()->getPaddingHorizontal(),
            'padding_vertical' => $entity->getRotatorFacade()->getPaddingVertical()
        ],['id' => $entity->getId()])->execute();
        $this->bannerRepository->saveBannersRotatorAssign($entity);
    }
}