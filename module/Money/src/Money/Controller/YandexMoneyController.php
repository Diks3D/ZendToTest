<?php

namespace Money\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Money\Model\Client\Yandex as YandexMoneyClient;

class YandexMoneyController extends AbstractActionController
{
    public function indexAction()
    {
        //$em = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
        //$messages = $em->getRepository('Money\Entity\Message');
        $yandexAuthUrl = YandexMoneyClient::getAuthUrl();
        var_dump($yandexAuthUrl); exit;
        return array(
            'yandexMoneyAuthUrl' => $yandexAuthUrl,
        );
    }
    
    public function callbackAction()
    {
        $code = $this->params()->fromQuery('code', false);
        $error = $this->params()->fromQuery('error', false);
        $errorDescription = $this->params()->fromQuery('error_description', '');

        if ($error) {
            return array(
                'error' => true,
                'message' => $errorDescription
            );
        }

        $yandexMoney = new YandexMoneyClient();
        $yandexMoney->getAccessToken($code);
        var_dump($code);
        exit;
        return $this->redirect('show');
    }

}
