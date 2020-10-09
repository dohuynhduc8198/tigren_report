<?php
namespace Tigren\TestEventModule\Plugin;

Class ExamplePlugin
{

    public function beforeSetTitle(\Tigren\TestEventModule\Controller\Index\Example $subject, $title)
    {
        $title = $title . " to ";
        echo __METHOD__ . "</br>";

        return [$title];
    }

    public function afterGetTitle(\Tigren\TestEventModule\Controller\Index\Example $subject, $result)
    {
        echo __METHOD__ . "</br>";
        return '<h1>'. $result . 'Tigren' .'</h1>';
    }

    public function aroundGetTitle(\Tigren\TestEventModule\Controller\Index\Example $subject, callable $proceed)
    {
        echo __METHOD__ . " - Before proceed() </br>";
        $result = $proceed();
        echo __METHOD__ . " - After proceed() </br>";

        return $result;
    }
}
