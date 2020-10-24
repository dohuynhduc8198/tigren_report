<?php
/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Test\Banner\Controller\Adminhtml\Banner;

use Exception;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Backend\Helper\Js;
use Magento\Backend\Model\View\Result\Redirect;
use Magento\Framework\App\ObjectManager;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Filesystem;
use Magento\TestFramework\ErrorLog\Logger;
use Magento\MediaStorage\Model\File\Uploader;
use Magento\MediaStorage\Model\File\UploaderFactory;
use Magento\Framework\App\Filesystem\DirectoryList;
use RuntimeException;
use Test\Banner\Model\ResourceModel\Banner\CollectionFactory;


class Save extends Action
{
    /**
     * @var Js
     */
    protected $_jsHelper;

    /**
     * @var \Test\Banner\Model\ResourceModel\Block\CollectionFactory
     */
    protected $_bannerCollectionFactory;

    /**
     * File Uploader factory
     *
     * @var UploaderFactory
     */
    protected $_fileUploaderFactory;

    /**
     * File system
     *
     * @var Filesystem
     */
    protected $_fileSystem;

    /**
     * @var Logger
     */
    protected $_logger;

    /**
     * \Magento\Backend\Helper\Js $jsHelper
     * @param Action\Context $context
     */
    public function __construct(
        Filesystem $fileSystem,
        Context $context,
        Js $jsHelper,
        CollectionFactory $bannerCollectionFactory,
        UploaderFactory $fileUploaderFactory
    )
    {
        $this->_fileSystem = $fileSystem;
        $this->_fileUploaderFactory = $fileUploaderFactory;
        $this->_jsHelper = $jsHelper;
        $this->_bannerCollectionFactory = $bannerCollectionFactory;
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

            /** @var \Test\Banner\Model\Banner $model */
            $model = $this->_objectManager->create('Test\Banner\Model\Banner');

            $id = $this->getRequest()->getParam('banner_id');
            if ($id) {
                $model->load($id);
            }

            // Upload images
            $imageRequest = $this->getRequest()->getFiles('image');

            $path = $this->_fileSystem->getDirectoryRead(
                DirectoryList::MEDIA
            )->getAbsolutePath(
                'test/banner/'
            );

            $bannerImage = !empty($imageRequest['name']);

            try {
                // remove the old file
                if ($bannerImage) {
                    $oldName = !empty($data['old_image']) ? $data['old_image'] : '';
                    if ($oldName) {
                        @unlink($path . $oldName);
                    }

                    //find the first available name
                    $newName = preg_replace('/[^a-zA-Z0-9_\-\.]/', '', $imageRequest['name']);
                    if (substr($newName, 0, 1) == '.') { // all non-english symbols
                        $newName = 'banner_' . $newName;
                    }
                    $i = 0;
                    while (file_exists($path . $newName)) {
                        $newName = ++$i . '_' . $newName;
                    }

                    /**
                     *
                     *
                     * @var $uploader Uploader
                     */
                    $uploader = $this->_fileUploaderFactory->create(['fileId' => 'image']);
                    $uploader->setAllowedExtensions(['jpg', 'jpeg', 'gif', 'png']);
                    $uploader->setAllowRenameFiles(true);
                    $uploader->save($path, $newName);

                    $data['image'] = $newName;
                } else {
                    $oldName = !empty($data['old_image']) ? $data['old_image'] : '';
                    $data['image'] = $oldName;
                }
            } catch (Exception $e) {
                if ($e->getCode() != Uploader::TMP_NAME_EMPTY) {
                    $this->_logger->critical($e);
                }
            }

            $model->setData($data);

            try {
                $model->save();
                $this->saveBlock($model, $data);

                $this->messageManager->addSuccess(__('You saved this banner.'));
                $this->_objectManager->get('Magento\Backend\Model\Session')->setFormData(false);
                if ($this->getRequest()->getParam('back')) {
                    return $resultRedirect->setPath('*/*/edit', ['banner_id' => $model->getId(), '_current' => true]);
                }
                return $resultRedirect->setPath('*/*/banner');
            } catch (LocalizedException $e) {
                $this->messageManager->addError($e->getMessage());
            } catch (RuntimeException $e) {
                $this->messageManager->addError($e->getMessage());
            } catch (Exception $e) {
                $this->messageManager->addException($e, __('Something went wrong while saving the banner.'));
            }

            $this->_getSession()->setFormData($data);
            return $resultRedirect->setPath('*/*/edit', ['banner_id' => $this->getRequest()->getParam('banner_id')]);
        }
        return $resultRedirect->setPath('*/*/banner');
    }

    public function saveBlock($model, $post)
    {
        // Attach the attachments to contact
        if (isset($post['block'])) {
            $blockIds = $this->_jsHelper->decodeGridSerializedInput($post['block']);
            try {
                $oldBlock = (array)$model->getBlock($model);
                $newBlock = (array)$blockIds;

                $this->_resources = ObjectManager::getInstance()->get('Magento\Framework\App\ResourceConnection');
                $connection = $this->_resources->getConnection();

                $table = $this->_resources->getTableName(\Test\Banner\Model\ResourceModel\Banner::TBL_BANNER_BLOCK_FKEY);
                $insert = array_diff($newBlock, $oldBlock);
                $delete = array_diff($oldBlock, $newBlock);

                if ($delete) {
                    $where = ['banner_id = ?' => (int)$model->getId(), 'block_id IN (?)' => $delete];
                    $connection->delete($table, $where);
                }

                if ($insert) {
                    $data = [];
                    foreach ($insert as $block_id) {
                        $data[] = ['banner_id' => (int)$model->getId(), 'block_id' => (int)$block_id];
                    }
                    $connection->insertMultiple($table, $data);
                }
            } catch (Exception $e) {
                $this->messageManager->addException($e, __('Something went wrong while saving the banner.'));
            }
        }

    }
}

