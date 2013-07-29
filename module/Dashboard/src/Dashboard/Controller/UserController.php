<?php
namespace Dashboard\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Dashboard\Form\UserForm;
use Dashboard\Entity;

class UserController extends AbstractActionController
{

    public function indexAction()
    {
        $objectManager = $this->getServiceLocator()
            ->get('Doctrine\ORM\EntityManager');
        $userRepository = $objectManager->getRepository('Dashboard\Entity\User');
        $list = $userRepository->findAll();
        return array(
            'users' => $list,
        );
    }

    public function addAction()
    {
        $form = new UserForm();
        var_dump($form); exit;
        
        $em = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');

        $user = new Entity\User();
        $user->login = 'dimonna';
        $user->email = 'dimonna@email.ru';
        $user->passHash = md5('Abcd12345');
        $user->fullName = 'Dimonna Tester';

        $objectManager->persist($user);
        $objectManager->flush();

        die(var_dump($user->getId())); // yes, I'm lazy

        $form = new AlbumForm();
        $form->get('submit')->setValue('Add');

        $request = $this->getRequest();
        if ($request->isPost()) {
            $album = new Album();
            $form->setInputFilter($album->getInputFilter());
            $form->setData($request->getPost());

            if ($form->isValid()) {
                $album->exchangeArray($form->getData());
                $this->getAlbumTable()->saveAlbum($album);

                // Redirect to list of albums
                return $this->redirect()->toRoute('album');
            }
        }
        return array('form' => $form);
    }

    public function editAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('album', array(
                    'action' => 'add'
                ));
        }
        $album = $this->getAlbumTable()->getAlbum($id);

        $form = new AlbumForm();
        $form->bind($album);
        $form->get('submit')->setAttribute('value', 'Edit');

        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setInputFilter($album->getInputFilter());
            $form->setData($request->getPost());

            if ($form->isValid()) {
                $this->getAlbumTable()->saveAlbum($form->getData());

                // Redirect to list of albums
                return $this->redirect()->toRoute('album');
            }
        }

        return array(
            'id' => $id,
            'form' => $form,
        );
    }

    public function deleteAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('album');
        }

        $request = $this->getRequest();
        if ($request->isPost()) {
            $del = $request->getPost('del', 'No');

            if ($del == 'Yes') {
                $id = (int) $request->getPost('id');
                $this->getAlbumTable()->deleteAlbum($id);
            }

            // Redirect to list of albums
            return $this->redirect()->toRoute('album');
        }

        return array(
            'id' => $id,
            'album' => $this->getAlbumTable()->getAlbum($id)
        );
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
