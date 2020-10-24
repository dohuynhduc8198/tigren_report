<?php

namespace Test\Banner\Controller\Adminhtml\Block;

use Exception;
use Magento\Backend\Model\View\Result\Redirect;
use Magento\Framework\Controller\ResultInterface;

class Delete extends \Test\Banner\Controller\Adminhtml\Block
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
        $id = $this->getRequest()->getParam('block_id');
        if ($id) {
            try {
// init model and delete
                $model = $this->_objectManager->create(\Test\Banner\Model\Block::class);
                $model->load($id);
                $model->delete();
// display success message
                $this->messageManager->addSuccessMessage(__('You deleted the Block.'));
// go to grid
                return $resultRedirect->setPath('*/*/block');
            } catch (Exception $e) {
// display error message
                $this->messageManager->addErrorMessage($e->getMessage());
// go back to edit form
                return $resultRedirect->setPath('*/*/edit', ['block_id' => $id]);
            }
        }
// display error message
        $this->messageManager->addErrorMessage(__('We can\'t find a Block to delete.'));
// go to grid
        return $resultRedirect->setPath('*/*/block');
    }
}
