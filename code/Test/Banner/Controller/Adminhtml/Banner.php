<?php

namespace Test\Banner\Controller\Adminhtml;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Registry;
use Magento\Framework\View\Result\PageFactory;
use Test\Banner\Model\BannerFactory;

class Banner extends Action
{
    protected $_coreRegistry;
    protected $_resultPageFactory;
    protected $_bannerFactory;

    public function __construct(
        Context $context,
        Registry $coreRegistry,
        PageFactory $resultPageFactory,
        BannerFactory $bannerFactory
    )
    {
        parent::__construct($context);
        $this->_coreRegistry = $coreRegistry;
        $this->_resultPageFactory = $resultPageFactory;
        $this->_bannerFactory = $bannerFactory;

    }

    public function execute()
    {

    }

    protected function _isAllowed()
    {
        return true;
    }
}
