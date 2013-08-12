<?php

namespace Application;

use Zend\Mvc\MvcEvent,
    Zend\Mvc\ModuleRouteListener,
    Zend\ModuleManager\ModuleManager,
    Zend\ServiceManager\ServiceManager,
    Zend\Authentication\AuthenticationService;
use Application\Listener\Authorization as AuthListener,
    Application\Event\Authentication as AuthEvent,
    Application\Model\Entry\Auth as AuthEntry,
    Application\Model\Auth\Acl as AuthAcl;

class Module
{   
    public function onBootstrap(MvcEvent $e)
    {
        $eventManager        = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);
        
        $em = $e->getApplication()->getEventManager();
        $authListener = new AuthListener();
        $authListener->attach($em);
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\ClassMapAutoloader' => array(
                __DIR__ . '/autoload_classmap.php',
            ),
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }
    
    public function getServiceConfig()
    {
        return array(
            'factories' => array(
                'Application\Event\Authentication' => function(ServiceManager $sm) {
                    $acl = $sm->get('Application\Auth\Acl');
                    return new AuthEvent(new AuthenticationService(), $acl);
                },
                'Application\Auth\Acl' => function(ServiceManager $sm) {
                    $appConfig = $sm->get('config');
                    return new AuthAcl($appConfig['acl']);
                },
            ),
        );
    }
}
