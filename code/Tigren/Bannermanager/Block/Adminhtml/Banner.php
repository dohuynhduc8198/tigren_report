<?php
/**
 * @author    Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2019 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license   Open Software License ("OSL") v. 3.0
 */

namespace Tigren\Bannermanager\Block\Adminhtml;

use Magento\Backend\Block\Widget\Grid\Container;

/**
 * Class Banner
 *
 * @package Tigren\Bannermanager\Block\Adminhtml
 */
class Banner extends Container
{
    protected function _construct()
    {
        $this->_controller = 'adminhtml_banner';
        $this->_blockGroup = 'Tigren_Bannermanager';
        $this->_headerText = __('Manage Banners');

        parent::_construct();

        if ($this->_isAllowedAction('Tigren_Bannermanager::save')) {
            $this->buttonList->update('add', 'label', __('Add New Banner'));
        } else {
            $this->buttonList->remove('add');
        }
    }

    /**
     * @param  $resourceId
     * @return bool
     */
    protected function _isAllowedAction($resourceId)
    {
        return $this->_authorization->isAllowed($resourceId);
    }
}
