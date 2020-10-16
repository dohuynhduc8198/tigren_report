<?php
namespace Tigren\HelloWorldAdmin\Model\ResourceModel\Post;


class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    protected $_idFieldName = 'post_id';
    protected $_eventPrefix = 'tigren_helloworldadmin_post_collection';
    protected $_eventObject = 'post_collection';

    protected function _construct()
    {
        $this->_init('Tigren\HelloWorldAdmin\Model\Post', 'Tigren\HelloWorldAdmin\Model\ResourceModel\Post');
    }
}
