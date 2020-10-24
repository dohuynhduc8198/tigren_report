<?php

namespace Test\Banner\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
use Magento\Framework\Model\ResourceModel\Db\Context;

class Banner extends AbstractDb
{
    const TBL_BANNER_BLOCK_FKEY = 'test_banner_id_block_banner';

    public function __construct(Context $context)
    {
        parent::__construct($context);
    }

    protected function _construct()
    {
        $this->_init('test_banner_banner', 'banner_id');
    }
}
