<?php

namespace Money\Controller;

use Zend\View\Model\ViewModel;
use Application\Controller\AbstractController;

class IndexController extends AbstractController
{
    public function indexAction()
    {
        $em = $this->getEntityManager();
        //$messages = $em->getRepository('Money\Entity\Message');
        return new ViewModel(array(
        ));
    }
}
