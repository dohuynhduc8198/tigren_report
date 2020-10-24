<?php
namespace Tigren\NewShipping\Controller\Index;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;

class Newshipping extends Action
{
    protected  $PageFactory;
    public function __construct(Context $context, PageFactory $PageFactory)
    {
        $this->PageFactory = $PageFactory;
        parent::__construct($context);
    }
    public function execute()
    {
        // TODO: Implement execute() method.
        return $this->PageFactory->create();
    }
}
