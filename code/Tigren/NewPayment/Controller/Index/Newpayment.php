<?php
namespace Tigren\NewPayment\Controller\Index;

use Magento\Framework\App\Action\Action;
use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\App\Action\Context;

class Newpayment extends Action
{
    protected $pageFactory;
    public function __construct(Context $context, PageFactory $pagefactory)
    {
        parent::__construct($context);
        $this->pageFactory = $pagefactory;
    }
    public function execute()
    {
        return $this->pageFactory->create();
    }
}
