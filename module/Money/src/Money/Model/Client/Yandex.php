<?php

namespace Money\Model\Client;

use Zend\Session\Storage\SessionStorage,
    Zend\Session\Container,
    Zend\Session\SessionManager;
use Money\Model\Client\YandexOAuthClient;

class Yandex
{
    protected $_oAuthSdk = null;
    protected $_accessToken = '41001260517056.42D53FFA341DA55D980E16D95AF3CE0941F415C607925677BB0D2B1444A2EC1457FF8E0E7DA764DB116268C184D438246B6B0AAF435656C93B42011E214192857083DA2B23D2772A264C6F14785A0E04D66533E58F441212130B17C61A80A8FB46808AE1ED87E32756F1484E279126E6F0B4A9B66AC7E5F5F8E2200A69DC1413';


    /**
     * Construct model, init and config sdk, config model variables 
     */
    public function __construct()
    {
        $this->_oAuthSdk = static::_getOAuthSDK();
    }
    
    /**
     * Static method for get configuired Yandex OAuth SDK
     * 
     * @return \YandexOAuthClient
     */
    private static function _getOAuthSDK()
    {
        require_once('YandexOAuthClient.php');

        $appKey = 'B842ABF9D1BEEDCDCEECB8C7819BA1BCC207AF37E184370FF3C7031AB03F12D7';
        $appSecret = 'BE038375BD667F2325F3521F069DE74566ADA226848005DB2E221A1B080E639B2AF5584EA8D87655C8A58828803D73AB77B8F4ABDD5A394EDA598DAE84B60426';
        $callback = 'http://zend2test.loc/money/yandexmoney/callback';

        $oAuthSdk = new YandexOAuthClient($appKey, $appSecret, $callback);
        return $oAuthSdk;
    }

    /**
     * Get redirect url for authorize user and store veryfer code
     * 
     * @return (string) - oAuth url for redirect user
     */
    public static function getAuthUrl()
    {
        $scopes = array('account-info','operation-history','operation-details');
        $sdk = static::_getOAuthSDK();
        $authUrl = $sdk->getAuthRequest($scopes);
        
        return $authUrl;
    }
    
    public static function getInstance(){
        return new self();
    }

    /**
     * Get access token by auth code
     * 
     * @param string $code - O2Auth Yandex authorization code
     * @return (string) $accessToken
     */
    public function getAccessToken($code)
    {
        try {
            $result = $this->_oAuthSdk->getAccessTokenByAuth($code);
            $accessToken = $result->access_token;
            return $accessToken;
        } catch (Exception $e) {
            var_dump($e); exit;
        }
    }

    /**
     * Get Yandex user login for indefity
     * 
     * @param (string) $accessToken - valid Yadex access token string
     * @return (string) $userLogin - Yandex login
     */
    public function getYandexLoginProfile($accessToken = null)
    {
        try {
            if (!is_null($accessToken)) {
                $this->_oAuthSdk->setAccessToken($accessToken);
            }
            $result = $this->_oAuthSdk->getProfile();
            return $result;
        } catch (Exception $e) {
            var_dump($e); exit;
        }
    }
}