<?php

namespace BannerService\Infrastructure\Domain\Repository;

use BannerService\Domain\Contract\Repository\BannerRepository;
use BannerService\Domain\Entity\Banner;
use BannerService\Domain\Entity\Rotator;
use BannerService\Domain\Exception\Exception;
use BannerService\Infrastructure\Domain\Factory\BannerFactory;
use yii\db\Query;

class BannerDAORepository implements BannerRepository
{
    /**
     * @var string
     */
    private $tableName;

    /**
     * BannerDAORepository constructor.
     * @param string $tableName
     */
    public function __construct($tableName)
    {
        $this->tableName = $tableName;
    }

    /**
     * @param int $id
     * @return Banner
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
            throw new Exception('Баннер не найден!');
        }

        $banner = (new BannerFactory())->createFreeBanner(
            intval($res['id']),
            intval($res['template_id']),
            intval($res['program_id']),
            $res['link'],
            intval($res['stop_shows']),
            floatval($res['stop_conversion']),
            $res['description']
        );
        if(!is_null($res['rotator_id']))
            $banner->setRotatorId(intval($res['rotator_id']));
        $banner->setStatus(intval($res['status']));
        return $banner;
    }

    /**
     * @param int $rotatorId
     * @return int[]
     */
    public function findIdAllByRotatorId($rotatorId)
    {
        $query = new Query();
        $res = $query->select('id')
            ->from($this->tableName)
            ->where(['rotator_id' => $rotatorId])
            ->all();

        $bannerIdList = [];

        foreach($res as $val){
            $bannerIdList[] = intval($val['id']);
        }

        return $bannerIdList;
    }

    /**
     * @param int $rotatorId
     * @return Banner[]
     */
    public function findAllByRotatorId($rotatorId)
    {
        $query = new Query();
        $res = $query->select('*')
            ->from($this->tableName)
            ->where(['rotator_id' => $rotatorId])
            ->all();

        $factory = new BannerFactory();
        $bannerList = [];

        foreach($res as $val){
            $bannerList[$val['id']] = $factory->createRotatorBanner(
                intval($val['id']),
                intval($val['rotator_id']),
                intval($val['template_id']),
                intval($val['program_id']),
                $val['link'],
                intval($val['stop_shows']),
                floatval($val['stop_conversion']),
                $val['description']
            );
        }

        return $bannerList;
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
     * @param Banner $entity
     */
    public function save(Banner $entity)
    {
        if($this->hasById($entity->getId()))
            $this->update($entity);
        else
            $this->add($entity);
    }

    /**
     * @param Rotator $entity
     */
    public function saveBannersRotatorAssign(Rotator $entity)
    {
        $db = \Yii::$app->db;
        $db->createCommand()->update($this->tableName, ['rotator_id' => null], ['rotator_id' => $entity->getId()])->execute();
        $db->createCommand()->update($this->tableName, ['rotator_id' => $entity->getId()], ['id' => $entity->getBannerIdList()])->execute();
    }

    /**
     * @param Banner $entity
     */
    public function remove(Banner $entity)
    {
        $db = \Yii::$app->db;
        $db->createCommand()->delete($this->tableName, ['id' => $entity->getId()])->execute();
    }

    private function add(Banner $entity)
    {
        $db = \Yii::$app->db;
        $db->createCommand()->insert($this->tableName, [
            'id' => $entity->getId(),
            'rotator_id' => $entity->getRotatorId()!==0 ? $entity->getRotatorId() : null,
            'template_id' => $entity->getBannerTemplateId(),
            'program_id' => $entity->getProgramId(),
            'link' => $entity->getLink(),
            'status' => $entity->getStatus(),
            'stop_shows' => $entity->getStopShows(),
            'stop_conversion' => $entity->getStopConversion(),
            'description' => $entity->getDescription()
        ])->execute();
    }

    private function update(Banner $entity)
    {
        $db = \Yii::$app->db;
        $db->createCommand()->update($this->tableName, [
            'rotator_id' => $entity->getRotatorId()!==0 ? $entity->getRotatorId() : null,
            'template_id' => $entity->getBannerTemplateId(),
            'program_id' => $entity->getProgramId(),
            'link' => $entity->getLink(),
            'status' => $entity->getStatus(),
            'stop_shows' => $entity->getStopShows(),
            'stop_conversion' => $entity->getStopConversion(),
            'description' => $entity->getDescription()
        ],['id' => $entity->getId()])->execute();
    }
}