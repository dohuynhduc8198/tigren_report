<?php

namespace Test\Banner\Controller\Adminhtml\Banner;

use Test\Banner\Controller\Adminhtml\Banner;

class NewAction extends Banner
{
    /**
     * Create new news action
     *
     * @return void
     */
    public function execute()
    {
        $this->_forward('edit');
    }
}
