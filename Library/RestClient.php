<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Library;

/**
 * Description of restClient
 *
 * @author patrick
 */
class RestClient {

    private $_url;

    public function setUrl($pUrl) {
        $this->_url = $pUrl;
        return $this;
    }

    public function get($pHeaders, $pParams = array()) {
        return $this->_launch($this->_makeUrl($pParams), $this->_createContext($this->_makeUrl($pParams), 'GET', $pHeaders));
    }

    public function post($pHeaders, $pPostParams = array(), $pGetParams = array()) {
        return $this->_launch($this->_makeUrl($pGetParams), $this->_createContext($this->_makeUrl($pGetParams), 'POST', $pHeaders, $pPostParams));
    }

    public function put($pHeaders, $pContent = null, $pGetParams = array()) {
        return $this->_launch($this->_makeUrl($pGetParams), $this->_createContext('PUT', $pHeaders, $pContent));
    }

    public function delete($pHeaders, $pContent = null, $pGetParams = array()) {
        return $this->_launch($this->_makeUrl($pGetParams), $this->_createContext('DELETE', $pHeaders, $pContent));
    }

    protected function _createContext($pUrl, $pMethod, $pHeaders, $pBody = null) {
        $opts = array(
            'http' => array(
                'method' => $pMethod,
                'header' => $pHeaders,
                'url' => $pUrl,
                'overrideMimeType' => false,
                'content' => $pBody[0],
            )
        );
        //$opts=json_encode($opts);
        var_dump($opts);
        return stream_context_create($opts);
    }

    protected function _makeUrl($pParams) {
        return $this->_url
                . (strpos($this->_url, '?') ? '' : '?')
                . http_build_query($pParams);
    }

    protected function _launch($pUrl, $context) {
        //var_dump($pUrl);
        //var_dump($context);
        if (($stream = fopen($pUrl, 'r', false, $context)) !== false) {
            $content = stream_get_contents($stream);
            $header = stream_get_meta_data($stream);
            // var_dump($content);
            // var_dump($header);
            fclose($stream);
            return array('content' => $content, 'header' => $header);
        } else {
            return false;
        }
    }

    public function envoi($receipers, $corps) {
        $rest = new RestClient();

//on va essayer de recuperer le token

        $body = array('grant_type=client_credentials');
        $pHeaders = array(
            'Authorization: Basic M05lR0lBWlRXY1FURlM2TWJ6TG5zZmFXall5NWk5aHA6aFdTc0dtbk5VZ20xQ1JXMQ==',
            sprintf('Content-Length: %d', strlen($body[0])),
            'Content-Type: application/x-www-form-urlencoded'
        );
        $temp = $rest->setUrl("https://api.orange.com/oauth/v2/token")->post($pHeaders, $body);

//puis on recuperer les infos sur le token
        $token = json_decode($temp['content']);
//var_dump($token);

        $pHeaders = array('Authorization: ' . $token->token_type . ' ' . $token->access_token);

//$rest->setUrl("https://api.orange.com/sms/admin/v1/contracts")->get($pHeaders);
//$rest->setUrl("https://api.orange.com/sms/admin/v1/purchaseorders")->get($pHeaders);
        foreach ($receipers as $r) {
//on essayer l'envoi de sms
            $body = array('{"outboundSMSMessageRequest":
    {
        "address":"tel:' . $r . '",
        "outboundSMSTextMessage":{"message":"' . $corp . '"},
        "senderAddress":"tel:+237698158390",
        "senderName":"' . urlencode('entreprise') . '"
    }
}');

            $pHeaders = array(
                'Authorization: ' . $token->token_type . ' ' . $token->access_token,
                sprintf('Content-Length: %d', strlen($body[0])),
                'Content-Type: application/json'
            );
            $temp = $rest->setUrl("https://api.orange.com/smsmessaging/v1/outbound/tel%3A%2B237698158390/requests")->post($pHeaders, $body);
        }
    }

}
