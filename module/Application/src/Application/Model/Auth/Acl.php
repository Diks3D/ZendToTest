<?php

/**
 * @namespace
 */
namespace Application\Model\Auth;

/**
 * @uses Zend\Acl\Acl
 * @uses Zend\Acl\Role\GenericRole
 * @uses Zend\Acl\Resource\GenericResource
 */
use Zend\Permissions\Acl\Acl  as ZendAcl,
    Zend\Permissions\Acl\Role\GenericRole as Role,
    Zend\Permissions\Acl\Resource\GenericResource as Resource;

/**
 * Class to handle Acl
 *
 * This class is for loading ACL defined in a config
 */
class Acl extends ZendAcl
{
    /**
     * Default Role
     */
    const DEFAULT_ROLE = 'guest';

    /**
     * Constructor
     *
     * @param array $config
     * @return void
     * @throws \Exception
     */
    public function __construct($config)
    {
        if (!isset($config['roles']) || !isset($config['resources'])) {
            throw new \Exception('Invalid ACL Config found');
        }

        $rolesList = $config['roles'];
        if (!isset($rolesList[self::DEFAULT_ROLE])) {
            $rolesList[self::DEFAULT_ROLE] = '';
        }

        $this->_addRoles($rolesList);
        $this->_addResources($config['resources']);
    }

    /**
     * Adds Roles to ACL
     *
     * @param array $roles
     * @return User\Acl
     */
    protected function _addRoles($rolesList)
    {
        foreach ($rolesList as $name => $parent) {
            if (!$this->hasRole($name)) {
                if (empty($parent)) {
                    $parent = array();
                } else {
                    $parent = explode(',', $parent);
                }

                $this->addRole(new Role($name), $parent);
            }
        }

        return $this;
    }

    /**
     * Adds Resources to ACL
     *
     * @param $resources
     * @return User\Acl
     * @throws \Exception
     */
    protected function _addResources($resources)
    {
        foreach ($resources as $permission => $controllers) {
            foreach ($controllers as $controller => $actions) {
                if ($controller == 'all') {
                    $controller = null;
                } else {
                    if (!$this->hasResource($controller)) {
                        $this->addResource(new Resource($controller));
                    }
                }

                foreach ($actions as $action => $role) {
                    if ($action == 'all') {
                        $action = null;
                    }

                    if ($permission == 'allow') {
                        $this->allow($role, $controller, $action);
                    } elseif ($permission == 'deny') {
                        $this->deny($role, $controller, $action);
                    } else {
                        throw new \Exception('No valid permission defined: ' . $permission);
                    }
                }
            }
        }

        return $this;
    }

}