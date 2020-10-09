<?php
namespace Tigren\TestEventModule\Observer;

use Magento\Framework\Event\Observer;

class ChangeDisplayText implements \Magento\Framework\Event\ObserverInterface
{
    public function execute(Observer $observer)
    {
        $displayText = $observer->getData('mp_text');
        echo $displayText->getText() . " - EVENT </br>";
        $displayText->setText('Execute event successfully.');

        return $this;
    }
}
