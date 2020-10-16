<?php
namespace Tigren\HelloWorldAdmin\Model\ResourceModel;

class  Post extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    public function __construct(\Magento\Framework\Model\ResourceModel\Db\Context $context)
    {
        parent::__construct($context);
    }
    protected function _construct()
    {
        $this->_init('tigren_hospital_post', 'post_id');
    }
}
