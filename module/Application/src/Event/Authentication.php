<?php

/**
 * File for Event Class
 *
 * @category  User
 * @package   User_Event
 * @author    Marco Neumann <webcoder_at_binware_dot_org>
 * @copyright Copyright (c) 2011, Marco Neumann
 * @license   http://binware.org/license/index/type:new-bsd New BSD License
 */
/**
 * @namespace
 */
namespace Dashboard\Event;

/**
 * @uses Zend\Mvc\MvcEvent
 * @uses User\Controller\Plugin\UserAuthentication
 * @uses User\Acl\Acl
 */
use Zend\Mvc\MvcEvent as MvcEvent,
    Zend\Mvc\Router\RouteMatch;
    //Dashboard\Controller\Plugin\Auth as AuthPlugin,
    //Dashboard\Model\Auth\Acl as AclClass;

/**
 * Authentication Event Handler Class
 *
 * This Event Handles Authentication
 *
 * @category  User
 * @package   User_Event
 * @copyright Copyright (c) 2011, Marco Neumann
 * @license   http://binware.org/license/index/type:new-bsd New BSD License
 */
class Authentication
{
    /**
     * @var AuthPlugin
     */
    protected $_userAuth = null;
    /**
     * @var AclClass
     */
    protected $_acl = null;
    /**
     * @var Auth Service
     */
    protected $_authService = null;
    
    public function __construct($authService , $acl)
    {
        $this->_authService = $authService;
        $this->_acl = $acl;
        //var_dump($aclAdapter);
    }

    /**
     * preDispatch Event Handler
     *
     * @param \Zend\Mvc\MvcEvent $event
     * @throws \Exception
     */
    public function preDispatch(MvcEvent $event)
    {
        $routeMatch = $event->getRouteMatch()->getParams();
       
        if (!$this->_authService->hasIdentity()) {
            if($routeMatch['controller'] !== 'Dashboard\Controller\Auth'){
                $event->setRouteMatch(new RouteMatch(array(
                    'controller' => 'Dashboard\Controller\Auth',
                    'action'=> 'auth',
                )));
            }
            return;
        }
        $path = $event->getRequest()->getUri()->getPath();
        
        $user = $this->_authService->getIdentity();
        $role = 'user';
        if (is_a($user, 'Dashboard\Entity\Admin')) {
            $role = 'admin';
        }
        
        if (!$this->_acl->isAllowed($role, $routeMatch['controller'], $routeMatch['action'])) {
            var_dump('Ваших прав недостаточно!');
            exit;
        }
        
        $event->getViewModel()->setVariable('auth', $user);
        $event->getViewModel()->setVariable('role', $role);
    }

    /**
     * Sets Authentication Plugin
     *
     * @param \User\Controller\Plugin\UserAuthentication $userAuthenticationPlugin
     * @return Authentication
     */
    public function setUserAuthenticationPlugin(AuthPlugin $userAuthenticationPlugin)
    {
        $this->_userAuth = $userAuthenticationPlugin;

        return $this;
    }

    /**
     * Gets Authentication Plugin
     *
     * @return \User\Controller\Plugin\UserAuthentication
     */
    public function getUserAuthenticationPlugin()
    {
        if ($this->_userAuth === null) {
            $this->_userAuth = new AuthPlugin();
        }

        return $this->_userAuth;
    }

    /**
     * Sets ACL Class
     *
     * @param \User\Acl\Acl $aclClass
     * @return Authentication
     */
    public function setAclClass(AclClass $aclClass)
    {
        $this->_aclClass = $aclClass;

        return $this;
    }

    /**
     * Gets ACL Class
     *
     * @return \User\Acl\Acl
     */
    public function getAclClass()
    {
        if ($this->_aclClass === null) {
            $this->_aclClass = new AclClass(array());
        }

        return $this->_aclClass;
    }

}