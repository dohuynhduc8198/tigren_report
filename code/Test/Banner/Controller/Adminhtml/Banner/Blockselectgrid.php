<?php

namespace Test\Banner\Controller\Adminhtml\Banner;

use Magento\Backend\App\Action;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\View\Result\LayoutFactory;
use Magento\TestFramework\ErrorLog\Logger;

class Blockselectgrid extends Action
{

    /**
     * @var LayoutFactory
     */
    protected $_resultLayoutFactory;

    /**
     * @param LayoutFactory $resultLayoutFactory
     * @param Action\Context $context
     */
    public function __construct(
        Action\Context $context,
        LayoutFactory $resultLayoutFactory
    )
    {
        parent::__construct($context);
        $this->_resultLayoutFactory = $resultLayoutFactory;
    }

    /**
     * {@inheritdoc}
     */
    protected function _isAllowed()
    {
        return true;
    }

    /**
     * Save action
     *
     * @return ResultInterface
     */
    public function execute()
    {
        $resultLayout = $this->_resultLayoutFactory->create();
        $resultLayout->getLayout()->getBlock('list.edit.tab.blockselect')
            ->setInBlock($this->getRequest()->getPost('banner_block', null));

        return $resultLayout;
    }

}
