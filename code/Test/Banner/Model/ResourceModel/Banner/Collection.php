<?php

namespace Test\Banner\Model\ResourceModel\Banner;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    protected $_idFieldName = 'banner_id';
    protected $_eventPrefix = 'test_banner_banner_collection';
    protected $_eventObject = 'block_collection';

    protected function _construct()
    {
        $this->_init('Test\Banner\Model\Banner', 'Test\Banner\Model\ResourceModel\Banner');
    }

    public function getBannerByBlock($blockId)
    {
        $this->getSelect()->join(
            ['banner_block' => 'test_banner_id_block_banner'],
            sprintf('banner_block.banner_id = main_table.banner_id AND banner_block.block_id = %s', $blockId)

        );
        return $this;
    }
}
