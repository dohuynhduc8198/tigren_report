<?php

namespace Test\Banner\Controller\Adminhtml\Block;

use Magento\Backend\Model\View\Result\Page;
use Test\Banner\Controller\Adminhtml\Block;

class Edit extends Block
{
    /**
     * @return void
     */
    public function execute()
    {
        $blockId = $this->getRequest()->getParam('block_id');

        $model = $this->_postsFactory->create();

        if ($blockId) {
            $model->load($blockId);
            if (!$model->getId()) {
                $this->messageManager->addError(__('This block no longer exists.'));
                $this->_redirect('*/*/block');
                return;
            }
        }

        // Restore previously entered form data from session
        $data = $this->_session->getNewsData(true);
        if (!empty($data)) {
            $model->setData($data);
        }

        $this->_coreRegistry->register('block_info', $model);

        /** @var Page $resultPage */
        $resultPage = $this->_resultPageFactory->create();
        $resultPage->setActiveMenu('Test_Banner::banner');
        $resultPage->getConfig()->getTitle()->prepend(__('Block Information'));

        return $resultPage;
    }
}
