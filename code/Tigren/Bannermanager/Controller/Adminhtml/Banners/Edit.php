<?php
/**
 * @author    Tigren Solutions <info@tigren.com>
 * @copyright Copyright (c) 2019 Tigren Solutions <https://www.tigren.com>. All rights reserved.
 * @license   Open Software License ("OSL") v. 3.0
 */

namespace Tigren\Bannermanager\Controller\Adminhtml\Banners;

use Magento\Backend\App\Action;
use Magento\Backend\Model\View\Result\Page;
use Magento\Backend\Model\View\Result\Redirect;
use Magento\Framework\Registry;
use Magento\Framework\View\Result\PageFactory;

/**
 * Class Edit
 *
 * @package Tigren\Bannermanager\Controller\Adminhtml\Banners
 */
class Edit extends Action
{
    /**
     * Core registry
     *
     * @var Registry
     */
    protected $_coreRegistry = null;

    /**
     * @var PageFactory
     */
    protected $resultPageFactory;

    /**
     * @param Action\Context $context
     * @param PageFactory    $resultPageFactory
     * @param Registry       $registry
     */
    public function __construct(
        Action\Context $context,
        PageFactory $resultPageFactory,
        Registry $registry
    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->_coreRegistry = $registry;
        parent::__construct($context);
    }

    /**
     * Edit Bannermanager banner
     *
     * @return                                  Page|Redirect
     * @SuppressWarnings(PHPMD.NPathComplexity)
     */
    public function execute()
    {
        $id = $this->getRequest()->getParam('image_id');
        $model = $this->_objectManager->create('Tigren\Bannermanager\Model\Banner');

        if ($id) {
            $model->load($id);
            if (!$model->getId()) {
                $this->messageManager->addError(__('This banner no longer exists.'));
                /**
*
 * \Magento\Backend\Model\View\Result\Redirect $resultRedirect
*/
                $resultRedirect = $this->resultRedirectFactory->create();

                return $resultRedirect->setPath('*/*/');
            }
        }

        $data = $this->_objectManager->get('Magento\Backend\Model\Session')->getFormData(true);
        if (!empty($data)) {
            $model->setData($data);
        }

        $this->_coreRegistry->register('bannermanager_banner', $model);

        /**
*
         *
 * @var Page $resultPage
*/
        $resultPage = $this->_initAction();
        $resultPage->addBreadcrumb(
            $id ? __('Edit Banner') : __('New Banner'),
            $id ? __('Edit Banner') : __('New Banner')
        );
        $resultPage->getConfig()->getTitle()->prepend(__('Banners'));
        $resultPage->getConfig()->getTitle()
            ->prepend($model->getId() ? $model->getBannerTitle() : __('New Banner'));

        return $resultPage;
    }

    /**
     * Init actions
     *
     * @return Page
     */
    protected function _initAction()
    {
        // load layout, set active menu and breadcrumbs
        /**
*
         *
 * @var Page $resultPage
*/
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('Tigren_Bannermanager::banner')
            ->addBreadcrumb(__('Bannermanager'), __('Bannermanager'))
            ->addBreadcrumb(__('Manage Banners'), __('Manage Banners'));
        return $resultPage;
    }

    /**
     * {@inheritdoc}
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Tigren_Bannermanager::banner');
    }
}
