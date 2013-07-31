<?php

namespace Dashboard\Model\Auth;

use Zend\Authentication\Storage\StorageInterface;
 
class Storage implements StorageInterface
{
    /**
     *
     * @var \Doctrine\ORM\EntityManager
     */
    protected $_em;
 
    public function __construct( \Doctrine\ORM\EntityManager $entityManager)
    {
        $this->_em = $entityManager;
    }
    
    /**
     * Returns true if and only if storage is empty
     *
     * @throws \Zend\Authentication\Exception\ExceptionInterface If it is impossible to determine whether storage is empty
     * @return bool
     */
    public function isEmpty(){
        $all = $this->_em->getRepository('Dashboard\Entity\Auth')->findAll();
        $count = count($all);
        return ($count == 0) ? true : false;  
    }

    /**
     * Returns the contents of storage
     *
     * Behavior is undefined when storage is empty.
     *
     * @throws \Zend\Authentication\Exception\ExceptionInterface If reading contents from storage is impossible
     * @return mixed
     */
    public function read(){
        var_dump($this); exit;
    }

    /**
     * Writes $contents to storage
     *
     * @param  mixed $contents
     * @throws \Zend\Authentication\Exception\ExceptionInterface If writing $contents to storage is impossible
     * @return void
     */
    public function write($contents){
        var_dump($contents); exit;
    }

    /**
     * Clears contents from storage
     *
     * @throws \Zend\Authentication\Exception\ExceptionInterface If clearing contents from storage is impossible
     * @return void
     */
    public function clear(){
        $this->_em->getRepository('Dashboard\Entity\Auth')->clear();
        $this->_em->flush();
    }
}
