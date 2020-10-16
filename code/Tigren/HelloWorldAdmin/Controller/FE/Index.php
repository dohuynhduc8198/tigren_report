<?php
namespace Tigren\HelloWorldAdmin\Controller\FE;

use Magento\Framework\App\Action\Action; //to create actions controllers in frontend
use Magento\Framework\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;

Class Index extends Action
{
    protected $pageFactory;
    public function __construct(Context $context, PageFactory $pageFactory)
    {
        $this->pageFactory = $pageFactory;
        parent::__construct($context);
    }

    public function execute()
    {
        return $this->pageFactory->create();
    }
}
