<?php

namespace Test\Banner\Block;

use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Test\Banner\Model\ResourceModel\Block\CollectionFactory;
use Test\Banner\Model\ResourceModel\Block\Collection;
use Magento\Framework\Stdlib\DateTime\Timezone;

class Banner extends Template
{
    //template ->getChildHTML
    protected $_template = 'banner.phtml';
    //BlockCOllectionFactory
    protected $_blockcollectionFactory;

    //timezone
    protected $_stdTimezone;

    public function __construct(
        Context $context,
        CollectionFactory $blockcollectionFactory,
        Timezone $_stdTimezone,
        array $data = []
    )
    {
        $this->_stdTimezone = $_stdTimezone;
        $this->_blockcollectionFactory = $blockcollectionFactory;
        parent::__construct($context, $data);
    }

    public function setPosition($position)
    {
        $dateTimeNow = $this->_stdTimezone->date()->format('Y-m-d H:i:s');

        $blockCollection = $this->_blockcollectionFactory->create()
            ->addFieldToFilter('position', $position)
            ->addFieldToFilter('from', [['to' => $dateTimeNow], ['from', 'null' => '']])
            ->addFieldToFilter('to', [['gteq' => $dateTimeNow], ['to', 'null' => '']])
            ->addFieldToFilter('status', 1);

        $this->appendChildBlockBlocks($blockCollection);

        return $this;
    }

    public function appendChildBlockBlocks(
        Collection $blockCollection
    ) {
        foreach ($blockCollection as $block) {
            $this->append(
                $this->getLayout()->createBlock(
                    'Test\Banner\Block\Banneritem'
                )->setBlockId($block->getId())
            );
        }

        return $this;
    }


}
