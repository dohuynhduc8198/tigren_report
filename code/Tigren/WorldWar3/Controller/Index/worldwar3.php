<?php
namespace Tigren\WorldWar3\Controller\Index;

use Magento\Framework\App\Action\Action;
use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\App\Action\Context;

class worldwar3 extends Action
{
    protected $pageFactory;
    public function __construct(Context $context, PageFactory $pageFactory)
    {
        parent::__construct($context);
        $this->pageFactory = $pageFactory;
    }

    public function execute()
    {
        // TODO: Implement execute() method.
        return $this->pageFactory->create();
    }
}
