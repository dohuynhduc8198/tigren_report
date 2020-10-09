<?php
namespace Tigren\TestEventModule\Controller\Index;

use Magento\Framework\App\Action\Action;

Class Example extends Action
{
    protected $title;
    public function execute()
    {
        echo $this->setTitle('Welcome');
        echo $this->getTitle();
    }
    public function setTitle($title)
    {
        return $this->title = $title;
    }
    public function  getTitle()
    {
        return $this->title;
    }
}
