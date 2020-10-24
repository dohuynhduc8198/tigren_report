<?php

namespace Test\Banner\Model;

use Magento\Framework\DataObject\IdentityInterface;
use Magento\Framework\Model\AbstractModel;

class Block extends AbstractModel implements IdentityInterface
{
    const CACHE_TAG = 'test_banner_block';
    protected $_cacheTag = 'test_banner_block';
    protected $_eventPrefix = 'test_banner_block';

    protected function _construct()
    {
        $this->_init('Test\Banner\Model\ResourceModel\Block');
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

    public function getBanner(Block $object)
    {
        $tbl = $this->getResource()->getTable(ResourceModel\Block::TBL_BANNER_BLOCK_FKEY);
        $select = $this->getResource()->getConnection()->select()->from(
            $tbl,
            ['banner_id']
        )
            ->where(
                'block_id = ?',
                (int)$object->getId()
            );
        return $this->getResource()->getConnection()->fetchCol($select);
    }
}
