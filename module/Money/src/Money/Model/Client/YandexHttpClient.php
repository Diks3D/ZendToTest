<?php

namespace Money\Model\Client;

use Zend\Http\Client as ZendHttpClient;

/**
 * HTTP Client for Yandex Services
 */
class YandexHttpClient
{
    protected $_lastResponse = null;

    /**
     * Transpot function
     * 
     * @param string $url
     * @param array $params
     * @param string $method
     * @param array $headers
     * @param string $data
     * 
     * @return object $out - Object of code, message , array of headers, body of response 
     * 
     * @throws YandexHttpClientException
     */
    public function sendRequest($url, $params = null, $method = 'GET', $headers = array(), $data = null)
    {
        $client = new ZendHttpClient();
        $client->setOptions(array(
            'maxredirects' => 0,
            'timeout' => 30,
            'sslverifypeer' => false,
        ));
        
        switch ($method) {
            case 'POST':
                if (!$data) {
                    $client->setParameterPost($params);
                } else {
                    if ($params){
                        $url = $url . '?' . http_build_query($params);
                    }
                    if ($data){
                        $client->setRawData($data);
                    }
                }
                break;
            case 'PUT':
                if ($params){
                    $url = $url . '?' . http_build_query($params);
                }
                $headers[] = ('X-HTTP-Method-Override: PUT');
                $client->setRawData($data);
                break;
            case 'GET':
                if ($params){
                    $client->setParameterGet($params);
                }
                break;
            case 'DELETE':
            case 'MOVE':
            case 'COPY':
            default:
                if ($params){
                    $url = $url . '?' . http_build_query($params, null, '&', 'PHP_QUERY_RFC3986');
                }
                if ($data){
                    $client->setRawData($data);
                }
                break;
        }
        $client->setUri($url);
        $client->setHeaders($headers);
        $client->setMethod($method);

        // Transfer ang get response
        try{
            $client->send();
        } catch (\Exception $ex) {
            throw new YandexHttpClientException($ex->getMessage(), 504);
        }
        $response = $client->getResponse();

        //First parsing
        $code = $response->getStatusCode();
        $message = $response->getReasonPhrase();
        $headers = $response->getHeaders();
        $body = $response->getBody();

        $contentType = $headers->get('Content-type');
        if ($contentType && stripos($contentType->value, 'application/json') !== false){
            $body = json_decode($body);
        }

        // Error section
        if (!$response->isOk()) {
            throw new YandexHttpClientException($message, $code);
        }

        $out = new \stdClass();
        $out->code = $code;
        $out->message = $message;
        $out->headers = $headers->toArray();
        $out->body = $body;

        $this->_lastResponse = $out;
        return $out;
    }

    public function getLastResponse($key = null)
    {
        if ($key) {
            return $this->_lastResponse->$key;
        }
        return $this->_lastResponse;
    }

}

/**
 * Yandex Http Exception class
 */
class YandexHttpClientException extends \Exception
{
    
}