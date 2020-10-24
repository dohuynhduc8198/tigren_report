<?php

namespace Test\Banner\Controller\Adminhtml\Banner;

use Magento\Backend\Model\View\Result\Page;
use Test\Banner\Controller\Adminhtml\Banner;

class Edit extends Banner
{
    /**
     * @return void
     */
    public function execute()
    {
        $bannerId = $this->getRequest()->getParam('banner_id');
        $model = $this->_bannerFactory->create();
        if ($bannerId) {
            $model->load($bannerId);
            if (!$model->getId()) {
                $this->messageManager->addError(__('This banner no longer exists.'));
                $this->_redirect('*/*/banner');
                return;
            }
        }

        // Restore previously entered form data from session
        $data = $this->_session->getNewsData(true);
        if (!empty($data)) {
            $model->setData($data);
        }
        $this->_coreRegistry->register('banner_info', $model);

        /** @var Page $resultPage */
        $resultPage = $this->_resultPageFactory->create();
        $resultPage->setActiveMenu('Test_Banner::banner');
        $resultPage->getConfig()->getTitle()->prepend(__('Banner Info'));

        return $resultPage;
    }
}
