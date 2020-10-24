<?php

namespace Test\Banner\Helper;

use Magento\Backend\Model\UrlInterface;
use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Magento\Store\Model\StoreManagerInterface;

class Datablock extends AbstractHelper
{
    /**
     * @var UrlInterface
     */
    protected $_backendUrl;

    /**
     * @var StoreManagerInterface $storeManager
     */
    protected $storeManager;

    /**
     * @param Context $context
     * @param UrlInterface $backendUrl
     */
    public function __construct(
        Context $context,
        UrlInterface $backendUrl,
        StoreManagerInterface $storeManager
    )
    {
        parent::__construct($context);
        $this->_backendUrl = $backendUrl;
        $this->storeManager = $storeManager;
    }

    /**
     * get banner tab Url in admin
     * @return string
     */
    public function getBannerGridUrl()
    {
        return $this->_backendUrl->getUrl('list/block/bannerselect', ['_current' => true]);
    }

    public function getPositionOptions()
    {
        return [
            [
                'label' => __('------- Please choose position -------'),
                'value' => '',
            ],

            [
                'label' => __('General (will be disaplyed on all pages)'),
                'value' => [
                    ['value' => 'sidebar-main-top', 'label' => __('Sidebar-Main-Top')],
                    ['value' => 'sidebar-main-bottom', 'label' => __('Sidebar-Main-Bottom')],
                    ['value' => 'sidebar-additional-top', 'label' => __('Sidebar-Additional-Top')],
                    ['value' => 'sidebar-additional-bottom', 'label' => __('Sidebar-Additional-Bottom')],
                    ['value' => 'content-top', 'label' => __('Content-Top')],
                    ['value' => 'menu-top', 'label' => __('Menu-Top')],
                    ['value' => 'menu-bottom', 'label' => __('Menu-Bottom')],
                    ['value' => 'page-bottom', 'label' => __('Page-Bottom')],
                ]
            ]
        ];
    }

    public function getDisplayTypeOptions()
    {
        return [
            ['label' => '-- Select Type --', 'value' => ''],
            ['label' => __('All Images'), 'value' => 1],
            ['label' => __('Slider'), 'value' => 2],
        ];
    }

}
