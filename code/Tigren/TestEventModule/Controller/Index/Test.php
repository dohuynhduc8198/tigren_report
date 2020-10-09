<?php
namespace Tigren\TestEventModule\Controller\Index;

use Magento\Framework\App\Action\Action;
Class Test extends Action
{
    public function execute()
    {
        // TODO: Implement execute() method.
        $textDisplay =  new \Magento\Framework\DataObject(array('text'=>'Tigren'));
        $this->_eventManager->dispatch('tigren_testeventmodule_display_text',['mp_text'=> $textDisplay]);
        echo $textDisplay->getText();
        exit;
    }
}
