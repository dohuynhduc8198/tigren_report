<?php
namespace Tigren\WorldWar3\Block;

use Magento\Framework\View\Element\Template;

class Display Extends Template
{
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context
        , \Tigren\WorldWar3\Model\PostFactory $postFactory)
    {
        $this->_postFactory = $postFactory;
        parent::__construct($context);
    }

    public function test()
    {
        return __('Keep going, you can do it.');
    }

    public function getPostCollection()
    {
        $post = $this->_postFactory->create();
        return $post->getCollection();
    }
}
