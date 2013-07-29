<?php

namespace Dashboard\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use DoctrineORMModule\Stdlib\Hydrator\DoctrineEntity;
use Dashboard\Entity\Message;
use Dashboard\Form\MessageForm;

class DashboardController extends AbstractActionController
{
    public function indexAction()
    {
        $em = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
        $messages = $em->getRepository('Dashboard\Entity\Message');
        $list = $messages->findAll();
        return new ViewModel(array(
            'messages' => $list,
        ));
    }
    
    public function addAction()
    {
        $em = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
        $form = new MessageForm();
        $form->setHydrator(new DoctrineEntity($em, 'Dashboard\Entity\Message'))
            ->setObject(new Message())
            //->setInputFilter(new ReferenzwertFilter())
            ->setAttribute('method', 'post');
        
        $errorMessage = '';
        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setData($request->getPost());
            if ($form->isValid()) {
                $message = $form->getData();
                
                $user = $em->find('Dashboard\Entity\User', 1);
                $message->setUser($user);
                $message->setCreated(new \DateTime());
                $message->setUpdated(new \DateTime());
                
                $em->persist($message);
                $em->flush();

                return $this->redirect()->toRoute('dashboard/messages');
            } else {
                $errorMessage = 'Input errors';
            }
        }
        
        return array(
            'form' => $form,
            'errorMessage' => $errorMessage,
        );
    }
    
    public function editAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('dashboard/messages', array(
                'action' => 'index'
            ));
        }
        
        $em = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
        $form = new MessageForm();
        $form->setHydrator(new DoctrineEntity($em, 'Dashboard\Entity\Message'))
            ->setObject(new Message())
            //->setInputFilter(new ReferenzwertFilter())
            ->setAttribute('method', 'post');     
        
        $errorMessage = '';
        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setData($request->getPost());
            if ($form->isValid()) {
                $message = $form->getData();
                $message->setUpdated(new \DateTime());

                $em->persist($message);
                $em->flush();

                return $this->redirect()->toRoute('dashboard/messages');
            } else {
                $errorMessage = 'Input errors';
            }
        }
        
        $form->bind($em->find('Dashboard\Entity\Message', $id));
        $message = $em->find('Dashboard\Entity\Message', $id);
        
        return array(
            'form' => $form,
            'message' => $message,
            'errorMessage' => $errorMessage,
        );
    }
    
    public function deleteAction()
    {        
        $id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('dashboard/messages');
        }
 
        $em = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
        
        $request = $this->getRequest();
        if ($request->isPost()) {
            $del = $request->getPost('delete', 'No');    
            if ($del == 'Yes') {
                $message = $em->find('Dashboard\Entity\Message', $id);
                $em->remove($message);
                $em->flush();
            }
 
            // Redirect to list of messages
            return $this->redirect()->toRoute('dashboard/messages');
        }
 
        return array(
            'id'    => $id,
            'message' => $em->find('Dashboard\Entity\Message', $id),
        );
    }
    
    public function searchAction()
    {
        
    }
}
