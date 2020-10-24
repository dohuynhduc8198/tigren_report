<?php

namespace Test\Banner\Block\Adminhtml\Block\Edit\Tab;

use Magento\Backend\Block\Template\Context;
use Magento\Backend\Block\Widget\Grid\Extended;
use Magento\Backend\Helper\Data;
use Magento\Framework\Registry;
use Test\Banner\Model\BannerFactory;
use Test\Banner\Model\BlockFactory;

class Bannerselect extends Extended
{
    protected $bannerFactory;
    protected $blockFactory;

    public function __construct(
        Context $context,
        Data $backendHelper,
        BannerFactory $bannerFactory,
        BlockFactory $blockFactory,
        Registry $coreRegistry,
        array $data = []
    )
    {
        $this->blockFactory = $blockFactory;
        $this->bannerFactory = $bannerFactory;
        $this->_coreRegistry = $coreRegistry;
        parent::__construct($context, $backendHelper, $data);
    }

    protected function _construct()
    {
        parent::_construct();
        $this->setId('banner_grid');
        $this->setDefaultSort('banner_id');
        $this->setUseAjax(true);
    }

    protected function _addColumnFilterToCollection($column)
    {
        if ($column->getId() == 'in_banner') {
            $bannerIds = $this->_getSelectedBanner();

            if (empty($bannerIds)) {
                $bannerIds = 0;
            }
            if ($column->getFilter()->getValue()) {
                $this->getCollection()->addFieldToFilter('banner_id', array('in' => $bannerIds));
            } else {
                if ($bannerIds) {
                    $this->getCollection()->addFieldToFilter('banner_id', array('nin' => $bannerIds));
                }
            }
        } else {
            parent::_addColumnFilterToCollection($column);
        }

        return $this;
    }

    protected function _prepareCollection()
    {
        $collection = $this->bannerFactory->create()->getCollection();
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {
        $this->addColumn(
            'in_banner',
            [
                'header_css_class' => 'a-center',
                'type' => 'checkbox',
                'name' => 'in_banner',
                'align' => 'center',
                'index' => 'banner_id',
                'values' => $this->_getSelectedBanner(),
            ]
        );

        $this->addColumn(
            'banner_id',
            [
                'header' => __('Banner Id'),
                'sortable' => true,
                'index' => 'banner_id',
                'header_css_class' => 'col-id',
                'column_css_class' => 'col-id'
            ]
        );
        $this->addColumn(
            'name',
            [
                'header' => __('Banner Name'),
                'index' => 'name'
            ]
        );
        $this->addColumn(
            'image',
            [
                'header' => __('image'),
                'index' => 'image',
                'renderer' => '\Test\Banner\Block\Adminhtml\Block\Widget\Renderer\Image'
            ]
        );

        return parent::_prepareColumns();
    }

    protected function _getSelectedBanner()
    {
        $block = $this->getBlock();
        return $block->getBanner($block);
    }

    public function getSelectedBanner()
    {
        $block = $this->getBlock();
        $selected = $block->getBanner($block);

        if (!is_array($selected)) {
            $selected = [];
        }
        return $selected;
    }

    protected function getBlock()
    {
        $blockId = $this->getRequest()->getParam('block_id');
        $block = $this->blockFactory->create();
        if ($blockId) {
            $block->load($blockId);
        }
        return $block;
    }

}
