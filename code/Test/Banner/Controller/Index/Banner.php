<?php

namespace Test\Banner\Controller\Index;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;

class  Banner extends Action
{
    protected $pagefactory;

    public function __construct(Context $context, PageFactory $pagefactory)
    {
        $this->pagefactory = $pagefactory;
        parent::__construct($context);
    }

    public function execute()
    {
        return $this->pagefactory->create();
    }
}
