<?php
namespace Admin;

use Zend\ServiceManager\ServiceManager,
    Zend\Db\ResultSet\ResultSet,
    Zend\Db\TableGateway\TableGateway;
use Admin\Model\Admin,
    Admin\Model\AdminTable;

class Module
{

    public function init(\Zend\ModuleManager\ModuleManager $mm)
    {
        $mm->getEventManager()->getSharedManager()->attach(__NAMESPACE__, 'dispatch', function($e) {
                $e->getTarget()->layout('admin/layout');
            });
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

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getServiceConfig()
    {
        return array(
            'factories' => array(
                'AdminTable' => function(ServiceManager $sm) {
                    $tableGw = $sm->get('AdminTableGateway');
                    $adminTable = new AdminTable($tableGw);
                    return $adminTable;
                },
                'AdminTableGateway' => function (ServiceManager $sm) {
                    $dbAdapter = $sm->get('ZendDbAdapterAdapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Admin());
                    return new TableGateway('z2t_admin', $dbAdapter, null, $resultSetPrototype);
                },
                'UserInfoTable' => function(ServiceManager $sm) {
                    try {
                        $appConfig = $sm->get('config');
                            //mongodb://<dbuser>:<dbpassword>@ds041248.mongolab.com:41248/zend_to_test
                            $mongo = new \MongoClient(
                            $appConfig['mongodb']['host'], array(
                            'username' => $appConfig['mongodb']['username'],
                            'password' => $appConfig['mongodb']['password'])
                        );
                        $dbName = $appConfig['mongodb']['database'];
                        $mongoDbTable = $mongo->$dbName;
                        return $mongoDbTable;
                    } catch (\MongoConnectionException $e) {
                        var_dump($e);
                        die('Error connecting to MongoDB server');
                    } catch (\MongoException $e) {
                        die('Error: ' . $e->getMessage());
                    }
                }
            ),
        );
    }

}