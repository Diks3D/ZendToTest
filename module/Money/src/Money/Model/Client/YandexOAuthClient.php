<?php

namespace Money\Model\Client;

require_once 'YandexHttpClient.php';

/**
 * HTTP Client for Yandex Disk
 */
class YandexOAuthClient
{
    protected $_appKey;
    protected $_appSecret;
    protected $_callbackUrl;
    protected $_scopes = array('account-info');
    protected $_accessToken;
    protected $_httpClient;

    const AUTHORIZE_URL = 'https://sp-money.yandex.ru/oauth/authorize';
    const OAUTH_URL = 'https://sp-money.yandex.ru/oauth/token';
    const API_LOGIN_URL = 'https://money.yandex.ru/api/account-info';

    /**
     * SDK constructor
     * 
     * @param (string) $appKey - Yandex application Id
     * @param (string) $appSecret - Yandex application password
     * @param (string) $callback - Callback redirect uri application option
     */
    public function __construct($appKey = null, $appSecret = null, $callback = null)
    {
        if ($appKey)
            $this->_appKey = $appKey;
        if ($appSecret)
            $this->_appSecret = $appSecret;
        if ($callback)
            $this->_callbackUrl = $callback;
        $this->_httpClient = new YandexHttpClient();
    }

    /**
     * Config SDK variables (appId, appSecret)
     */
    public function setConfig(array $config)
    {
        foreach ($config as $key => $value) {
            $this->_{$key} = $value;
        }
    }

    /**
     * Get authorisation url
     */
    public function getAuthRequest($scopes = array())
    {
        if($scopes){
            $this->_scopes = $scopes;
        }
        $params = array(
            'client_id' => $this->_appKey,
            'response_type' => 'code',
            'redirect_uri' => $this->_callbackUrl,
            'scope'=> implode(' ', $this->_scopes),
        );
        $oAuthUrl = self::AUTHORIZE_URL . '?' . http_build_query($params);
        
        return $oAuthUrl;
    }

    /**
     * Set Access token  
     */
    public function setAccessToken($accessToken)
    {
        $this->_accessToken = $accessToken;
    }
    
    /**
     * Get current Access token  
     */
    public function getAccessToken()
    {
        return $this->_accessToken;
    }

    /**
     * Create Access Token 
     */
    public function getAccessTokenByAuth($veriferCode)
    {
        $params = array(
            'code' => $veriferCode,
            'client_id' => $this->_appKey,
            'grant_type' => 'authorization_code',
            'redirect_uri' => $this->_callbackUrl,
            'client_secret' => $this->_appSecret,
        );        
        return $this->_httpClient->sendRequest(self::OAUTH_URL, $params, 'POST')->body;
    }
    
    public function getProfile(){
        $params = array(
            'format' => 'json',
            'oauth_token' => $this->_accessToken,
        );
        return $this->_httpClient->sendRequest(self::API_LOGIN_URL, $params)->body;
    }

}