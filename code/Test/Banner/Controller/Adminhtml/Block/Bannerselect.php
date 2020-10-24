<?php

namespace Test\Banner\Controller\Adminhtml\Block;

use Magento\Backend\App\Action;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\View\Result\LayoutFactory;
use Magento\TestFramework\ErrorLog\Logger;

class Bannerselect extends Action
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
        $resultLayout->getLayout()->getBlock('list.edit.tab.bannerselect')
            ->setInBanner($this->getRequest()->getPost('block_banner', null));

        return $resultLayout;
    }
}
