<?php

namespace Application\Listener;

use Zend\EventManager\EventManagerInterface,
    Zend\EventManager\ListenerAggregateInterface,
    Zend\Mvc\MvcEvent;

class Authorization implements ListenerAggregateInterface
{
    protected $user;
    protected $role;

    protected $listeners = array();

    public function __construct()
    {
    }

    public function attach(EventManagerInterface $events)
    {
        $this->listeners[] = $events->attach(MvcEvent::EVENT_DISPATCH, array($this, 'mvcPreDispatch'), 100);
    }

    public function detach(EventManagerInterface $events)
    {
        foreach ($this->listeners as $index => $listener) {
            if ($events->detach($listener)) {
                unset($this->listeners[$index]);
            }
        }
    }

    /**
     * MVC preDispatch Event
     *
     * @param \Zend\Mvc\MvcEvent $event
     * @return mixed
     */
    public function mvcPreDispatch(MvcEvent $event)
    {
        $sm = $event->getTarget()->getServiceManager();
        $authEvent = $sm->get('Application\Event\Authentication');
        return $authEvent->preDispatch($event);
    }
}