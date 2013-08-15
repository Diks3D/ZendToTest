<?php
namespace Dashboard;

use Zend\Mvc\MvcEvent,
    Zend\ModuleManager\ModuleManager,
    Zend\ServiceManager\ServiceManager,
    Zend\Authentication\AuthenticationService;
use Dashboard\Listener\AuthListener,
    Dashboard\Event\Authentication as AuthEvent,
    Dashboard\Model\Entry\Auth as AuthEntry,
    Dashboard\Auth\Acl as AuthAcl,
    Dashboard\Model\Auth\Storage as AuthStorage;

class Module
{

//    public function init(ModuleManager $mm)
//    {
//        $mm->getEventManager()->getSharedManager()->attach(__NAMESPACE__, 'dispatch', function($e) {
//                $e->getTarget()->layout('dashboard/layout');
//            });
//    }

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

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getServiceConfig()
    {
        return array(
            'factories' => array(
                'Dashboard\Event\Authentication' => function(ServiceManager $sm) {
                    $acl = $sm->get('Dashboard\Auth\Acl');
                    //$storage = $sm->get('AuthStorageAdapter');
                    return new AuthEvent(new AuthenticationService(), $acl);
                },
                'AuthStorageAdapter' => function(ServiceManager $sm) {
                    $entityManager = $sm->get('Doctrine\ORM\EntityManager');
                    return new AuthStorage($entityManager);
                },
                'Dashboard\Auth\Acl' => function(ServiceManager $sm) {
                    $appConfig = $sm->get('config');
                    return new AuthAcl($appConfig['acl']);
                },
            ),
        );
    }

}