<?php

namespace Money\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Application\Controller\AbstractController;
use Money\Model\Client\Yandex as YandexMoneyClient;

class YandexMoneyController extends AbstractController
{
    public function indexAction()
    {
        $em = $this->getEntityManager();
        $user = $em->getRepository('Application\Entity\User')->find(1);
        $moneyAcconts = $user->getMoneyAccounts();
        $yandexAuthUrl = YandexMoneyClient::getAuthUrl();
        return array(
            'yandexMoneyAuthUrl' => $yandexAuthUrl,
            'yandexMoneyAccounts' => $moneyAcconts
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
        
        $em = $this->getEntityManager();
        $user = $em->getRepository('Application\Entity\User')->find(1);

        $yandexMoney = new YandexMoneyClient();
        //$accessToken = $yandexMoney->getAccessToken($code);
        $accessToken = '41001260517056.753F383E1A9B53EE998A42AE4C5C6277BC51B8C5CB55782FAC78664AC3E6B2B0F8683C68D1AD8265332EE63EFE9E6613E8DAF52C607A971924D5A5C53CECEF66848C0099279BD179CBE681881E6DD2639B71EBBD1BD7DE88C636D24A264271B79F85EE9A274C849CE58453DDD762A53CFD2069109DC70D4E595717DEC4AAC24A';
        $yandexProfile = $yandexMoney->getYandexLoginProfile($accessToken);
        exit;
        var_dump($yandexProfile);
        
        $moneyAccount = new \Application\Entity\MoneyAccount\YandexMoney($user);
        var_dump($moneyAccount); exit;
        $moneyAccount->setRemoteIdenty($yandexProfile->account);
        var_dump($moneyAccount);
        exit;
        return $this->redirect('show');
    }

}
