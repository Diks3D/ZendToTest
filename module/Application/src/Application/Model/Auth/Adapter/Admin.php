<?php

namespace Application\Model\Auth\Adapter;

use Zend\Authentication\Result;
use Zend\Authentication\Adapter\AdapterInterface;

class Admin implements AdapterInterface
{
    /** @var $_salt */
    protected $_salt = '3E12rt68r';
    
    /** @var \EntityManager */
    protected $_em;

    /**
     * Sets username and password for authentication, provide EntityManager instance
     * 
     * @param string $username
     * @param string $password
     * @param \Doctrine\ORM\EntityManager $em
     * 
     * @return void
     */
    public function __construct($username, $password, \Doctrine\ORM\EntityManager $em)
    {
        $this->login = $username;
        $this->password = $password;
        $this->_em = $em;
    }

    /**
     * Performs an authentication attempt
     *
     * @return \Zend\Authentication\Result
     * @throws \Zend\Authentication\Adapter\Exception\ExceptionInterface
     *               If authentication cannot be performed
     */
    public function authenticate()
    {
        $adminByLogin = $this->_em->getRepository('Application\Entity\Admin')->findOneBy(array('login' => $this->login));
        if(!is_null($adminByLogin)
            && sha1($this->_salt . md5($this->password)) === $adminByLogin->getPassHash()){
            return new Result(Result::SUCCESS, $adminByLogin, array('Authentificate success'));
        } else {
            return new Result(Result::FAILURE, null, array('Pairs login/password are not correct'));
        }
    }
}