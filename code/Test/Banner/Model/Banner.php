<?php

namespace Test\Banner\Model;

use Magento\Framework\DataObject\IdentityInterface;
use Magento\Framework\Model\AbstractModel;

class Banner extends AbstractModel implements IdentityInterface
{
    const CACHE_TAG = 'test_banner_banner';
    protected $_cacheTag = 'test_banner_banner';
    protected $_eventPrefix = 'test_banner_banner';
    //const for getStatus
    const STATUS_ENABLED = 1;
    const STATUS_DISABLED = 0;

    protected function _construct()
    {
        $this->_init('Test\Banner\Model\ResourceModel\Banner');
    }

    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }

    public function getDefaultValues()
    {
        $values = [];

        return $values;
    }

    public function getBlock(Banner $object)
    {
        $tbl = $this->getResource()->getTable(ResourceModel\Banner::TBL_BANNER_BLOCK_FKEY);
        $select = $this->getResource()->getConnection()->select()->from(
            $tbl,
            ['block_id']
        )
            ->where(
                'banner_id = ?',
                (int)$object->getId()
            );
        return $this->getResource()->getConnection()->fetchCol($select);
    }

    public function getBannerImage()
    {
        return $this->getImage();
    }

    public function getStatus()
    {
        return [self::STATUS_ENABLED => __('Enable'), self::STATUS_DISABLED => __('Disable')];
    }
}
