<?php

namespace Test\Banner\Block\Adminhtml\Banner\Edit\Tab;

use Magento\Backend\Block\Template\Context;
use Magento\Backend\Block\Widget\Grid\Extended;
use Magento\Backend\Helper\Data;
use Magento\Framework\Registry;
use Test\Banner\Model\Banner;
use Test\Banner\Model\BannerFactory;
use Test\Banner\Model\BlockFactory;


class Blockselect extends Extended
{
    protected $blockFactory;
    protected $bannerFactory;

    public function __construct(
        Context $context,
        Data $backendHelper,
        BlockFactory $blockFactory,
        BannerFactory $bannerFactory,
        Registry $coreRegistry,
        array $data = []
    )
    {
        $this->bannerFactory = $bannerFactory;
        $this->blockFactory = $blockFactory;
        $this->_coreRegistry = $coreRegistry;
        parent::__construct($context, $backendHelper, $data);
    }

    protected function _construct()
    {
        parent::_construct();
        $this->setId('block_grid');
        $this->setDefaultSort('block_id');
        $this->setUseAjax(true);
    }

    protected function _addColumnFilterToCollection($column)
    {
        if ($column->getId() == 'in_block') {
            $blockIds = $this->_getSelectedBlock();

            if (empty($blockIds)) {
                $blockIds = 0;
            }
            if ($column->getFilter()->getValue()) {
                $this->getCollection()->addFieldToFilter('block_id', array('in' => $blockIds));
            } else {
                if ($blockIds) {
                    $this->getCollection()->addFieldToFilter('block_id', array('nin' => $blockIds));
                }
            }
        } else {
            parent::_addColumnFilterToCollection($column);
        }

        return $this;
    }

    protected function _prepareCollection()
    {
        $collection = $this->blockFactory->create()->getCollection();
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {
        $this->addColumn(
            'in_block',
            [
                'header_css_class' => 'a-center',
                'type' => 'checkbox',
                'name' => 'in_block',
                'align' => 'center',
                'index' => 'block_id',
                'values' => $this->_getSelectedBlock(),
            ]
        );


        $this->addColumn(
            'block_id',
            [
                'header' => __('Block Id'),
                'sortable' => true,
                'index' => 'block_id',
                'header_css_class' => 'col-id',
                'column_css_class' => 'col-id'
            ]
        );
        $this->addColumn(
            'block_name',
            [
                'header' => __('Block Name'),
                'index' => 'block_name'
            ]
        );
        $this->addColumn(
            'position',
            [
                'header' => __('position'),
                'index' => 'position',

            ]
        );

        return parent::_prepareColumns();
    }

    protected function _getSelectedBlock()
    {
        $banner = $this->getBanner();
        return $banner->getBlock($banner);
    }

    public function getSelectedBlock()
    {
        $banner = $this->getBanner();
        $selected = $banner->getBlock($banner);

        if (!is_array($selected)) {
            $selected = [];
        }
        return $selected;
    }

    protected function getBanner()
    {
        $bannerId = $this->getRequest()->getParam('banner_id');
        $banner = $this->bannerFactory->create();
        if ($bannerId) {
            $banner->load($bannerId);
        }
        return $banner;
    }

}
