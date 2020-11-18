<?php

namespace Test\Banner\Block;

use Magento\Framework\Stdlib\DateTime\DateTime;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Test\Banner\Model\BlockFactory;
use Test\Banner\Model\Block as BlockModel;
use Magento\Framework\Stdlib\DateTime\Timezone;
use Test\Banner\Model\ResourceModel\Banner\CollectionFactory;
use Test\Banner\Helper\Databanner;

class Banneritem extends Template
{
    //helper
    protected $_bannerHelper;
    //datetime
    protected $_stdlibDateTime;
    //timezone
    protected $_stdTimezone;
    protected $_block;
    protected $_blockId;
    protected $_blockFactory;
    protected $_bannerCollectionFactory;
    //all_image template
    const DISPLAYTYPE_ALL_IMAGE_TEMPLATE = 'all_image.phtml';
    //slider image tempalte
    const DISPLAYTYPE_SLIDER_TEMPLATE = 'slide/slider.phtml';

    public function __construct(
        Databanner $bannerHelper,
        Context $context,
        BlockModel $block,
        BlockFactory $blockFactory,
        Timezone $_stdTimezone,
        DateTime $stdlibDateTime,
        CollectionFactory $bannerCollectionFactory,
        array $data = []
    )
    {
        $this->_bannerHelper = $bannerHelper;
        $this->_bannerCollectionFactory = $bannerCollectionFactory;
        $this->_block = $block;
        $this->_blockFactory = $blockFactory;
        $this->_stdTimezone = $_stdTimezone;
        $this->_stdlibDateTime = $stdlibDateTime;
        parent::__construct($context, $data);
    }

    public function setBlockId($blockId)
    {
        $this->_blockId = $blockId;
        $block = $this->_blockFactory->create()->load($this->_blockId);

        if ($block->getId()) {
            $this->setBlock($block); // function setBlock()
            switch ($block->getDisplayType()) {

                case '1':
                    $typeTemplate = self::DISPLAYTYPE_ALL_IMAGE_TEMPLATE;
                    break;

                case '2':
                    $typeTemplate = self::DISPLAYTYPE_SLIDER_TEMPLATE;
                    break;

                default:
                    $typeTemplate = self::DISPLAYTYPE_SLIDER_TEMPLATE;
                    break;
            }
            $this->setTemplate($typeTemplate);
        }
        return $this;
    }

    public function setBlock(BlockModel $block)
    {
        $this->_block = $block;
        return $this;

    }

    public function getBannerCollection()
    {
        $dateTimeNow = $this->_stdTimezone->date()->format('Y-m-d H:i:s');

        $bannerCollection = $this->_bannerCollectionFactory->create()
            ->getBannerByBlock($this->_block->getId())
            ->addFieldToFilter('status', 1)
            ->addFieldToFilter('from', [['to' => $dateTimeNow], ['from', 'null' => '']])
            ->addFieldToFilter('to', [['gteq' => $dateTimeNow], ['to', 'null' => '']]);

        return $bannerCollection;
    }

    public function getBlock()
    {
        return $this->_block;
    }

    public function getBannerItemHtmlId()
    {
        return 'test-banner-banner-' . $this->getBlock()->getId() . $this->_stdlibDateTime->gmtTimestamp();
    }

    public function getBannerImageUrl(\Test\Banner\Model\Banner $banner)
    {
        return $this->_bannerHelper->getImageUrl($banner->getBannerImage());
    }

    protected function _toHtml()
    {
        if (!$this->_block->getId() || $this->_block->getStatus() === 1 || !$this->getBannerCollection()->getSize()) {
            return '';
        }
        return parent::_toHtml();
    }
}
