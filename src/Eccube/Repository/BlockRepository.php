<?php
/*
 * This file is part of EC-CUBE
 *
 * Copyright(c) 2000-2015 LOCKON CO.,LTD. All Rights Reserved.
 *
 * http://www.lockon.co.jp/
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.
 */


namespace Eccube\Repository;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\Filesystem\Filesystem;

/**
 * BlocRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class BlockRepository extends EntityRepository
{
    protected $app;

    public function setApplication($app)
    {
        $this->app = $app;
    }

    public function findOrCreate($block_id, $DeviceType)
    {

        if ($block_id == null) {
            return $this->newBlock($DeviceType);
        } else {
            return $this->getBlock($block_id, $DeviceType);
        }

    }

    public function newBlock($DeviceType)
    {
        $Block = new \Eccube\Entity\Block();
        $Block
            ->setDeviceType($DeviceType)
            ->setLogicFlg(0)
            ->setDeletableFlg(1);

        return $Block;
    }

    /**
     * @deprecated since 3.0.0, to be removed in 3.1
     */
    private function getNewBlockId($DeviceType)
    {

        $qb = $this->createQueryBuilder('b')
            ->select('max(b.id) +1 as block_id')
            ->where('b.DeviceType = :DeviceType')
            ->setParameter('DeviceType', $DeviceType);
        $result = $qb->getQuery()->getSingleResult();

        return $result['block_id'];

    }

    /**
     * ブロックの情報を取得.
     *
     * @param  integer $block_id ブロックID
     * @param  \Eccube\Entity\Master\DeviceType $DeviceType
     * @return array
     */
    public function getBlock($block_id, $DeviceType)
    {
        $Block = $this->findOneBy(array(
            'id' => $block_id,
            'DeviceType' => $DeviceType,
        ));

        return $Block;
    }

    /**
     * ブロック一覧の取得.
     *
     * @param  \Eccube\Entity\Master\DeviceType $DeviceType
     * @return array
     */
    public function getList($DeviceType)
    {
        $qb = $this->createQueryBuilder('b')
            ->orderBy('b.id', 'DESC')
            ->where('b.DeviceType = :DeviceType')
            ->setParameter('DeviceType', $DeviceType);

        $Blocks = $qb
            ->getQuery()
            ->getResult();

        return $Blocks;
    }

    /**
     * ページの属性を取得する.
     *
     * この関数は, dtb_pagelayout の情報を検索する.
     * $deviceTypeId は必須. デフォルト値は DEVICE_TYPE_PC.
     *
     * @access public
     * @param  DeviceType $DeviceType 端末種別ID
     * @param  string $where 追加の検索条件
     * @param  string[] $parameters 追加の検索パラメーター
     * @return array                             ページ属性の配列
     * @deprecated since 3.0.0, to be removed in 3.1
     */
    public function getPageList(DeviceType $DeviceType, $where = null, $parameters = array())
    {
        $qb = $this->createQueryBuilder('l')
            ->orderBy('l.id', 'DESC')
            ->where('l.DeviceType = :DeviceType')
            ->setParameter('DeviceType', $DeviceType)
            ->andWhere('l.id <> 0')
            ->orderBy('l.id', 'ASC');
        if (!is_null($where)) {
            $qb->andWhere($where);
            foreach ($parameters as $key => $val) {
                $qb->setParameter($key, $val);
            }
        }

        $PageLayouts = $qb
            ->getQuery()
            ->getResult();

        return $PageLayouts;
    }

    /**
     * 書き込みパスの取得
     * User定義の場合： /html/user_data
     * そうでない場合： /app/template/{template_code}
     *
     * @param  boolean $isUser
     * @return string
     *
     * @deprecated since 3.0.0, to be removed in 3.1
     */
    public function getWriteTemplatePath($isUser = false)
    {
        return $this->app['config']['block_realdir'];
    }

    /**
     * 読み込みファイルの取得
     *
     * 1. block_realdir
     *      app/template/{template_code}/block
     * 2. block_default_readldir
     *      src/Eccube/Resource/template/default/block
     *
     * @param string $fileName
     * @param  boolean $isUser
     *
     * @return array
     */
    public function getReadTemplateFile($fileName, $isUser = false)
    {
        $readPaths = array(
            $this->app['config']['block_realdir'],
            $this->app['config']['block_default_realdir'],
        );
        foreach ($readPaths as $readPath) {
            $filePath = $readPath . '/' . $fileName . '.twig';
            $fs = new Filesystem();
            if ($fs->exists($filePath)) {
                return array(
                    'file_name' => $fileName,
                    'tpl_data' => file_get_contents($filePath),
                );
            }
        }
    }
}
