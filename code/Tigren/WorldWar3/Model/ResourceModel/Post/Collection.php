<?php
namespace Tigren\WorldWar3\Model\ResourceModel\Post;


class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    protected $_idFieldName = 'post_id';
    protected $_eventPrefix = 'tigren_worldwar3_post_collection';
    protected $_eventObject = 'post_collection';

    protected function _construct()
    {
        $this->_init('Tigren\WorldWar3\Model\Post', 'Tigren\WorldWar3\Model\ResourceModel\Post');
    }
}
