<?php
namespace Tigren\TestEventModule\Controller\Index;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;

class TestEventModule extends Action
{
    protected $pageFactory;
    public function __construct(Context $context,PageFactory $pageFactory)
    {
        parent::__construct($context);
        $this->pageFactory = $pageFactory;
    }

    public function execute()
    {
        // TODO: Implement execute() method.
        return $this->pageFactory->create(); // layout initial
    }
}
