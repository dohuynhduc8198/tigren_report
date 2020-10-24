<?php
/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Test\Banner\Controller\Adminhtml\Block;

use Exception;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Backend\Helper\Js;
use Magento\Backend\Model\View\Result\Redirect;
use Magento\Framework\App\ObjectManager;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\TestFramework\ErrorLog\Logger;
use RuntimeException;
use Test\Banner\Model\ResourceModel\Block\CollectionFactory;

class Save extends Action
{
    /**
     * @var Js
     */
    protected $_jsHelper;

    /**
     * @var CollectionFactory
     */
    protected $_blockCollectionFactory;

    /**
     * \Magento\Backend\Helper\Js $jsHelper
     * @param Action\Context $context
     */
    public function __construct(
        Context $context,
        Js $jsHelper,
        CollectionFactory $blockCollectionFactory
    )
    {
        $this->_jsHelper = $jsHelper;
        $this->_blockCollectionFactory = $blockCollectionFactory;
        parent::__construct($context);
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
        $data = $this->getRequest()->getPostValue();

        /** @var Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        if ($data) {

            /** @var \Test\Banner\Model\Block $model */
            $model = $this->_objectManager->create('Test\Banner\Model\Block');

            $id = $this->getRequest()->getParam('block_id');
            if ($id) {
                $model->load($id);
            }

            $model->setData($data);

            try {
                $model->save();
                $this->saveBanner($model, $data);

                $this->messageManager->addSuccess(__('You saved this block.'));
                $this->_objectManager->get('Magento\Backend\Model\Session')->setFormData(false);
                if ($this->getRequest()->getParam('back')) {
                    return $resultRedirect->setPath('*/*/edit', ['block_id' => $model->getId(), '_current' => true]);
                }
                return $resultRedirect->setPath('*/*/block');
            } catch (LocalizedException $e) {
                $this->messageManager->addError($e->getMessage());
            } catch (RuntimeException $e) {
                $this->messageManager->addError($e->getMessage());
            } catch (Exception $e) {
                $this->messageManager->addException($e, __('Something went wrong while saving the block.'));
            }

            $this->_getSession()->setFormData($data);
            return $resultRedirect->setPath('*/*/edit', ['block_id' => $this->getRequest()->getParam('block_id')]);
        }
        return $resultRedirect->setPath('*/*/block');
    }

    public function saveBanner($model, $post)
    {
        // Attach the attachments to contact
        if (isset($post['banner'])) {
            $bannerIds = $this->_jsHelper->decodeGridSerializedInput($post['banner']);
            try {
                $oldBanner = (array)$model->getBanner($model);
                $newBanner = (array)$bannerIds;

                $this->_resources = ObjectManager::getInstance()->get('Magento\Framework\App\ResourceConnection');
                $connection = $this->_resources->getConnection();

                $table = $this->_resources->getTableName(\Test\Banner\Model\ResourceModel\Block::TBL_BANNER_BLOCK_FKEY);
                $insert = array_diff($newBanner, $oldBanner);
                $delete = array_diff($oldBanner, $newBanner);

                if ($delete) {
                    $where = ['block_id = ?' => (int)$model->getId(), 'banner_id IN (?)' => $delete];
                    $connection->delete($table, $where);
                }

                if ($insert) {
                    $data = [];
                    foreach ($insert as $banner_id) {
                        $data[] = ['block_id' => (int)$model->getId(), 'banner_id' => (int)$banner_id];
                    }
                    $connection->insertMultiple($table, $data);
                }
            } catch (Exception $e) {
                $this->messageManager->addException($e, __('Something went wrong while saving the block.'));
            }
        }

    }
}

