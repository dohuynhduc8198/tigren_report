<?php

namespace Test\Banner\Controller\Adminhtml\Banner;

use Exception;
use Magento\Backend\Model\View\Result\Redirect;
use Magento\Framework\Controller\ResultInterface;
use Test\Banner\Controller\Adminhtml\Block;

class Delete extends Block
{

    /**
     * Delete action
     *
     * @return ResultInterface
     */
    public function execute()
    {
        /** @var Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
// check if we know what should be deleted
        $id = $this->getRequest()->getParam('banner_id');
        if ($id) {
            try {
// init model and delete
                $model = $this->_objectManager->create(\Test\Banner\Model\Banner::class);
                $model->load($id);
                $model->delete();
// display success message
                $this->messageManager->addSuccessMessage(__('You deleted the Banner.'));
// go to grid
                return $resultRedirect->setPath('*/*/banner');
            } catch (Exception $e) {
// display error message
                $this->messageManager->addErrorMessage($e->getMessage());
// go back to edit form
                return $resultRedirect->setPath('*/*/edit', ['banner_id' => $id]);
            }
        }
// display error message
        $this->messageManager->addErrorMessage(__('We can\'t find a Banner to delete.'));
// go to grid
        return $resultRedirect->setPath('*/*/banner');
    }
}
