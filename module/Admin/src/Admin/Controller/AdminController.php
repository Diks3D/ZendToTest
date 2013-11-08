<?php
namespace Admin\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Authentication\AuthenticationService;
use DoctrineORMModule\Stdlib\Hydrator\DoctrineEntity;
use Application\Form\UserForm;
//use Application\Form\UserFormFilter;
use Application\Entity\User;

class AdminController extends AbstractActionController
{
    public function indexAction()
    {
        $adminTable = $this->getServiceLocator()->get('AdminTable');
        return array(
            'admins' => $adminTable->fetchAll(),
        );
    }

    public function addAction()
    {
        $form = new UserForm();
        $form->get('submit')->setValue('Add User');

        $request = $this->getRequest();
        if ($request->isPost()) {
            
            //$filter = new UserFormFilter();
            //$form->setInputFilter($filter->getInputFilter());
            $form->setData($request->getPost());
            if ($form->isValid()) {
                $em = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
                $formData = $form->getData();

                $user = new User();
                $user->login = $formData['login'];
                $user->email = $formData['email'];
                $user->passHash = md5($formData['password']);
                $user->fullName = $formData['fullname'];
                $em->persist($user);
                $em->flush();

                // Redirect to list of albums
                return $this->redirect()->toRoute('dashboard/user');
            }
        }
        return array('form' => $form);
    }

    public function editAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('dashboard/user', array('action' => 'add'));
        }

        $em = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
        $user = $em->find('Application\Entity\User', $id);
        
        $form = new UserForm();
        //$filter = new UserFormFilter();
        ///$form->setInputFilter($filter->getInputFilter());
        $form->setValidationGroup('login','email','fullname');
        $form->get('submit')->setAttribute('value', 'Edit');

        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setData($request->getPost());
            if ($form->isValid()) {  
                $formData = $form->getData();
                $user->login = $formData['login'];
                $user->email = $formData['email'];
                $user->fullName = $formData['fullname'];
                $em->persist($user);
                $em->flush();

                // Redirect to list of albums
                return $this->redirect()->toRoute('dashboard/user');
            }
        } else {
            $form->setData(array(
                'login' => $user->login,
                'email' => $user->email,
                'fullname' => $user->fullName,
            ));
        }       

        return array(
            'form' => $form,
            'user' => $user,
        );
    }
    
    public function changepassAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('dashboard/user');
        }

        $em = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
        $user = $em->find('Application\Entity\User', $id);
        
        $form = new UserForm();
        //$filter = new UserFormFilter();
        //$form->setInputFilter($filter->getInputFilter());
        $form->setValidationGroup('password','confirm');
        $form->get('submit')->setAttribute('value', 'Change');

        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setData($request->getPost());
            if ($form->isValid()) {  
                $formData = $form->getData();
                $user->passHash = md5($formData['password']);
                $em->persist($user);
                $em->flush();

                // Redirect to list of albums
                return $this->redirect()->toRoute('dashboard/user');
            }
        }     

        return array(
            'form' => $form,
            'user' => $user,
        );
    }

    public function deleteAction()
    {        
        $id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('dashboard/user');
        }
 
        $em = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
        $user = $em->find('Application\Entity\User', $id);
        
        $request = $this->getRequest();
        if ($request->isPost()) {
            $del = $request->getPost('delete', 'No');    
            if ($del == 'Yes') {
                $em->remove($user);
                $em->flush();
            }
 
            // Redirect to list of messages
            return $this->redirect()->toRoute('dashboard/user');
        }
 
        return array(
            'user' => $user,
        );
    }

    public function addadminAction()
    {
        $em = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');

        $admin = new Entity\Admin();
        $admin->setLogin('diks3d');
        $admin->setEmail('diks3d@gmail.com');
        $admin->setFullName('Avanesov Dmitriy');
        $admin->setPassHash(sha1('3E12rt68r' . md5('Lbvjyyf91294')));

        $adminInfo = simplexml_load_string('<?xml version="1.0" encoding="UTF-8"?><info></info>');
        $adminInfo->addChild('icq', '253090435');
        $adminInfo->addChild('phone', '+79521139413');
        $adminInfo->addChild('email', 'diks3d@mail.ru');
        $adminInfo->addChild('email', 'diks3d@yandex.ru');

        $admin->setInfo($adminInfo->asXML());

        $em->persist($admin);
        $em->flush();

        return $this->redirect()->toRoute('dashboard/messages');
    }

}
