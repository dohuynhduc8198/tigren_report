<?php

namespace Test\Banner\Block;

use Magento\Framework\Registry;
use Magento\Framework\View\Element\Template;
use Magento\Framework\Stdlib\DateTime\Timezone;
use Magento\Framework\View\Element\Template\Context;
use Test\Banner\Model\BannerFactory;
use Test\Banner\Model\BlockFactory;
use Test\Banner\Model\ResourceModel\Block\Collection;
use Test\Banner\Model\ResourceModel\Block\CollectionFactory;

class  Index extends Template
{
    protected $_stdTimezone;
    protected $_storeManager;
    protected $_coreRegistry;
    protected $_blockCollectionFactory;
    protected $_customerSession;

    public function __construct(
        Context $context
        , BlockFactory $blockFactory
        , BannerFactory $bannerFactory
        , CollectionFactory $blockCollectionFactory
        , Timezone $_stdTimezone
        , Registry $coreRegistry
        , array $data = [])
    {
        $this->_blockFactory = $blockFactory;
        $this->_bannerFactory = $bannerFactory;
        $this->_stdTimezone = $_stdTimezone;
        $this->_coreRegistry = $coreRegistry;
        $this->_blockCollectionFactory = $blockCollectionFactory;
        parent::__construct($context);
    }

    public function getBlockCollection()
    {
        $block_admin = $this->_blockFactory->create();
        return $block_admin->getCollection();
    }

    public function getBannerCollection()
    {
        $banner_admin = $this->_bannerFactory->create();
        return $banner_admin->getCollection();
    }
}
