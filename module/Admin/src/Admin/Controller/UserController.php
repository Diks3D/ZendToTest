<?php
namespace Admin\Controller;

use Zend\Mvc\Controller\AbstractActionController,
    Zend\View\Model\ViewModel;
use DoctrineORMModule\Stdlib\Hydrator\DoctrineEntity,
    DoctrineModule\Stdlib\Hydrator\DoctrineObject;
use Application\Entity\User,
    Application\Form\UserForm,
    Application\Form\UserFormFilter;


class UserController extends AbstractActionController
{
    public function indexAction()
    {
        $em = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
        $userRepository = $em->getRepository('Application\Entity\User');
        $list = $userRepository->findAll();
        return array(
            'users' => $list,
        );
    }

    public function addAction()
    {
        $em = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
        
        $user = new User();
        $form = new UserForm();
        $filter = new UserFormFilter();
        $hydrator = new DoctrineObject($em, '\Application\Entity\User');
        $form->setInputFilter($filter->getInputFilter());
        $form->setHydrator($hydrator);
        $form->get('submit')->setValue('Add User');
        $form->bind($user);

        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setData($request->getPost());
            if ($form->isValid()) {
                $em->persist($user);
                try{
                    $em->flush();
                } catch(\Doctrine\DBAL\DBALException $e){
                    $form->setMessages(array(
                        'login' => array('User with this login or email is exists')
                        ));
                    return array('form' => $form);
                }
                return $this->redirect()->toRoute('admin/usermanage');
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
    
    public function testAction()
    {
        $em = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
        $user = $em->find('Application\Entity\User', 1);
//        $mongo = new \MongoClient();
//        $mongoDb = $mongo->selectDB('test');
        $mongoDb = $this->getServiceLocator()->get('UserInfoTable');
        //$mongoDb->createCollection('other_hlam');
        $collection = $mongoDb->other_hlam;
        $dataToTable = array(
            'numbers' => array( 1, '34', 56),
            'objects' => array(
                'xml' => $user->info,
                ),
            'arrays' => array(
                'server' => $_SERVER,
                'request' => $_REQUEST,
            ),
            'datetime' => array(
                'timeObj' => new \DateTime(),
                'timestamp' => time(),
            ),
            'json' => json_encode(array(
                'user' => 'avdmit',
                'role' => 'admin',
                'created' => new \DateTime(),
                'unix_timestamp' => time(),
                )),
        );
        var_dump($dataToTable);
        $cursor = $collection->find();
        foreach($cursor as $obj){
            var_dump($obj);
        }
        exit;
    }

    public function addadminAction()
    {
        $em = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');

        $admin = new Entity\Admin();
        $admin->setLogin('diks3d');
        $admin->setEmail('diks3d@gmail.com');
        $admin->setFullName('Avanesov Dmitriy');
        $admin->setPassHash(md5('Lbvjyyf91294'));

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
