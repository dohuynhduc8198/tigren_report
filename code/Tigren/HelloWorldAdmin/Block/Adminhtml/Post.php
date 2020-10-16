<?php
namespace Tigren\HelloWorldAdmin\Block\Adminhtml;

class Post extends \Magento\Backend\Block\Widget\Grid\Container
{
    protected function _construct()
    {
        $this->_controller = 'adminhtml_post';
        $this->_blockGroup = 'Tigren_HelloWorldAdmin';
        $this->_headerText = __('Hospital List');
        $this->_addButtonLabel = __('Add new hospital');
        parent::_construct();
    }
}
