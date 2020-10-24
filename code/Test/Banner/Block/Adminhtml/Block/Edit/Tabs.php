<?php

namespace Test\Banner\Block\Adminhtml\Block\Edit;

use Magento\Backend\Block\Widget\Tabs as WidgetTabs;

class Tabs extends WidgetTabs
{
    /**
     * Class constructor
     *
     * @return void
     */
    protected function _construct()
    {
        parent::_construct();
        $this->setId('block_edit_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(__('Block Information'));
    }

}
