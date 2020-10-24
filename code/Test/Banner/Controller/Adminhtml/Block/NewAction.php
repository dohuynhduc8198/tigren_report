<?php

namespace Test\Banner\Controller\Adminhtml\Block;

use Test\Banner\Controller\Adminhtml\Block;

class NewAction extends Block
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
