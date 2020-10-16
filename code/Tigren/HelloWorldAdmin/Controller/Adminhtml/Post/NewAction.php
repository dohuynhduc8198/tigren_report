<?php
namespace Tigren\HelloWorldAdmin\Controller\Adminhtml\Post;

use Tigren\HelloWorldAdmin\Controller\Adminhtml\Post;

class NewAction extends Post
{
    /**
     * Create new news action
     *
     * @return void
     */
    public function execute()
    {
        $this->_forward('edit');
    }
}
