<?php

namespace Test\Banner\Block;

use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Test\Banner\Model\BlockFactory;
use Test\Banner\Model\Block as BlockModel;

class Banneritem extends Template
{
    const DISPLAYTYPE_ALL_IMAGE_TEMPLATE = 'type/all_image.phtml';
    const DISPLAYTYPE_SLIDER_TEMPLATE = 'type/slide/slider.phtml';

    protected $_blockFactory;

    public function __construct(
        Context $context,
        BlockFactory $blockFactory,
        array $data = []
    )
    {
        $this->_blockFactory = $blockFactory;
        parent::__construct($context, $data);
    }

    public function setBlockId($blockId)
    {
        $this->_blockId = $blockId;

        $block = $this->_blockFactory->create()->load($this->_blockId);
        if ($block->getId()) {
            $this->setBlock($block);

            switch ($block->getDisplayType()) {
                case '1':
                    $typeTemplate = self::DISPLAYTYPE_ALL_IMAGE_TEMPLATE;
                    break;
                case '2':
                    $typeTemplate = self::DISPLAYTYPE_SLIDER_TEMPLATE;
                    break;

                default:
                    $typeTemplate = self::DISPLAYTYPE_ALL_IMAGE_TEMPLATE;
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

}
