<?php

namespace Egulias\ListenersDebug\Tests\Tag;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class Listener implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return array(
            'test.event' => array(
                array('onTestEvent', -2),
            ),
        );
    }
}
