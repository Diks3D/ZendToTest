<?php

namespace Audio;

use Audio\Model;
use Audio\Model\Template;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
 
class Module
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