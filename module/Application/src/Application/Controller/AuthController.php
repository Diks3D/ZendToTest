<?php

namespace Application\Controller;

use Zend\Authentication\AuthenticationService;

use Application\Controller\AbstractController,
    Application\Form\AuthForm,
    Application\Model\Auth\Adapter\User as UserAuthAdapter,
    Application\Model\Auth\Adapter\Admin as AdminAuthAdapter;

class AuthController extends AbstractController
{
    public function authAction()
    {
        $form = new AuthForm();
        $form->get('submit')->setValue('Login');

        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setData($request->getPost());
            if ($form->isValid()) {
                $formData=$form->getData();
                $login = $formData['login'];
                $password = $formData['password'];
                $auth = new AuthenticationService();
                $em = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
                $result = $auth->authenticate(new UserAuthAdapter($login, $password, $em));
                if($result->isValid()){
                    return $this->redirect()->toRoute('dashboard');
                } else {
                    $form->setMessages(array('login' => $result->getMessages()));
                }
            }
        }
        
        return array(
            'form' => $form,
        );
    }

    public function adminauthAction()
    {
        $form = new AuthForm();
        $form->get('submit')->setValue('Login as Admin');

        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setData($request->getPost());
            if ($form->isValid()) {
                $formData=$form->getData();
                $login = $formData['login'];
                $password = $formData['password'];
                $auth = new AuthenticationService();
                $em = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
                $result = $auth->authenticate(new AdminAuthAdapter($login, $password, $em));
                if($result->isValid()){
                    return $this->redirect()->toRoute('dashboard');
                }
            }
        }
        
        return array(
            'form' => $form,
        );
    }
    
    public function logoutAction()
    {
        $auth = new AuthenticationService();
        if($auth->hasIdentity()){
            $user = $auth->getIdentity();
        } else {
            return $this->redirect()->toRoute('userauth');
        }
        
        $request = $this->getRequest();
        if ($request->isPost()) {
            $confirm = $request->getPost('logout', 'No');    
            if ($confirm == 'Yes') {
                $auth->clearIdentity();
                return $this->redirect()->toRoute('userauth');
            }
 
            // Redirect to list of messages
            return $this->redirect()->toRoute('dashboard/messages');
        }
 
        return array(
            'user' => $user,
        );
    }

}