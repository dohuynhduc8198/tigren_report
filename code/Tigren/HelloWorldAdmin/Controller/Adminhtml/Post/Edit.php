<?php
namespace Tigren\HelloWorldAdmin\Controller\Adminhtml\Post;

use Tigren\HelloWorldAdmin\Controller\Adminhtml\Post;

class Edit extends Post
{
    /**
     * @return void
     */
    public function execute()
    {
        $postId = $this->getRequest()->getParam('id');
        $model = $this->_postFactory->create();

        if ($postId) {
            $model->load($postId);
            if (!$model->getId()) {
                $this->messageManager->addError(__('This hospital no longer exists.'));
                $this->_redirect('*/*/');
                return;
            }
        }

        // Restore previously entered form data from session
        $data = $this->_session->getNewsData(true);
        if (!empty($data)) {
            $model->setData($data);
        }
        $this->_coreRegistry->register('hospital_blog', $model);

        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->_resultPageFactory->create();
        $resultPage->setActiveMenu('Tigren_HelloWorldAdmin::helloworld');
        $resultPage->getConfig()->getTitle()->prepend(__('Edit Hospital Info'));

        return $resultPage;
    }
}
