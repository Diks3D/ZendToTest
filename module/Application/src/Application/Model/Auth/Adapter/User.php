<?php

namespace Application\Model\Auth\Adapter;

use Zend\Authentication\Result;
use Zend\Authentication\Adapter\AdapterInterface;

class User implements AdapterInterface
{
    /** @var \EntityManager */
    protected $em;

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
        $this->em = $em;
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
        $queryString = "select u from Application\Entity\User u where u.login = '{$this->login}' or u.email = '{$this->login}'";
        $result = $this->em->createQuery($queryString)->setMaxResults(1)->getResult();
        if(count($result) !== 0
            && md5($this->password) === $result[0]->getPassHash()){
            return new Result(Result::SUCCESS, $result[0], array('Authentificate success'));
        } else {
            return new Result(Result::FAILURE, null, array('Pairs login/password are not correct'));
        }
    }
}