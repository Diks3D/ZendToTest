<?php

namespace Audio;

use Audio\Model,
    Audio\Model\Template,
    Zend\Db\ResultSet\ResultSet,
    Zend\Db\TableGateway\TableGateway,
    Zend\ModuleManager\Feature\AutoloaderProviderInterface,
    Zend\EventManager\StaticEventManager;
 
class Module implements AutoloaderProviderInterface
{   
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
                'Model\AudioCollection' =>  function($sm) {
                    return new Model\AudioCollection($sm->get('AudioTrackGateway'));
                },
                'AudioTrackGateway' => function ($sm) {
                    $dbAdapter = $sm->get('ZendDbAdapterAdapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Template\AudioTrack());
                    return new TableGateway('audio_collection', $dbAdapter, null, $resultSetPrototype);
                },
                'Model\TemporyStorage' =>  function($sm) {
                    return new Model\TemporyStorage($sm->get('TempStorageGateway'));
                },
                'TempStorageGateway' => function ($sm) {
                    $dbAdapter = $sm->get('ZendDbAdapterAdapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Template\TmpAudioTrack());
                    return new TableGateway('temp_storage', $dbAdapter, null, $resultSetPrototype);
                },
            ),
        );
    }
}