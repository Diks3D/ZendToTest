<?php

/**
 * @namespace
 */
namespace Application\Event;

/**
 * @uses Zend\Mvc\MvcEvent
 */
use Zend\Mvc\MvcEvent as MvcEvent,
    Zend\Mvc\Router\RouteMatch;

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
     * @var \Zend\Authentication\AuthenticationService Auth Service
     */
    protected $_authService = null;
    
    public function __construct(\Zend\Authentication\AuthenticationService $authService , $aclAdapter = null)
    {
        $this->_authService = $authService;
        $this->_acl = $aclAdapter;
    }

    /**
     * preDispatch Event Handler
     *
     * @param \Zend\Mvc\MvcEvent $event
     * @throws \Exception
     */
    public function preDispatch(MvcEvent $event)
    {
        $routeParams = $event->getRouteMatch()->getParams();
        $controllerNameArray = explode('\\', $routeParams['controller']);
        $routeParams['namespace'] = $controllerNameArray[0];
        $routeParams['url'] = $event->getRequest()->getUri()->getPath();
        $routeParams['https'] = ($event->getRequest()->getUri()->getScheme() === 'https') ? true : false;
        
        var_dump(__NAMESPACE__);
        var_dump($routeParams); exit;
        
        if (!$this->_authService->hasIdentity()) {
            if($routeMatch['controller'] !== 'Application\Controller\Auth'){
                $event->setRouteMatch(new RouteMatch(array(
                    'controller' => 'Application\Controller\Auth',
                    'action'=> 'auth',
                )));
            }
            return;
        }
        
        $user = $this->_authService->getIdentity();
        $role = 'user';
        if (is_a($user, 'Application\Entity\Admin')) {
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