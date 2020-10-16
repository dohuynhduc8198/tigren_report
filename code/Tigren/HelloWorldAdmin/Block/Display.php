<?php
namespace Tigren\HelloWorldAdmin\Block;

use Magento\Framework\View\Element\Template; //use when you declare a block in frontend
use Magento\Framework\View\Element\Template\Context; //Constructor modification for Template
use Tigren\HelloWorldAdmin\Model\PostFactory;
use Tigren\HelloWorldAdmin\Helper\Data;

Class Display extends Template
{
    protected $helperData;
    protected $_postFactory;
    protected $_dataHelper;

    public function __construct(Context $context, PostFactory $postFactory,Data $helperData)
    {
        $this->_postFactory = $postFactory;
        $this->helperData = $helperData;
        parent::__construct($context);

    }

    public function getPostCollection()
    {
        $post = $this->_postFactory->create();
        return $post->getCollection();
    }

    public function getEnable()
    {
        return $this->helperData->getGeneralConfig('enable');

    }
}
