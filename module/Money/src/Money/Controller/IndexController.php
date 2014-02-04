<?php

namespace Money\Controller;

use Zend\Mvc\Controller\AbstractActionController,
    Zend\View\Model\ViewModel;

class IndexController extends AbstractActionController
{
    public function indexAction()
    {
        //$em = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
        //$messages = $em->getRepository('Money\Entity\Message');
        return new ViewModel(array(
        ));
    }
}
