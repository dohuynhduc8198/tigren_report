<?php

namespace Test\Banner\Model\ResourceModel\Block;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    protected $_idFieldName = 'block_id';
    protected $_eventPrefix = 'test_banner_block_collection';
    protected $_eventObject = 'block_collection';

    protected function _construct()
    {
        $this->_init('Test\Banner\Model\Block', 'Test\Banner\Model\ResourceModel\Block');
    }
}
