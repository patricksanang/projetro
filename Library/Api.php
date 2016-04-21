<?php
namespace Library;


class Api{

    const SUCCESS = "success";
    const AUTH_FAILED = "auth_failed";
    const XML_ERROR = "NOT_ENOUGH_CREDITS";
    const NO_RECIPIENTS = "NO_RECIPIENTS";
    const GENERAL_ERROR = "GENERAL_ERROR";

protected static function testNumber($recipients){

    $result = array();

    foreach ($recipients as $key => $value) {
        if(preg_match("/^(00237|237)?(6)?([256789][0-9]{7})$/" , str_replace(" ", "", $value) , $matches)){
            $result[] = "002376" . $matches[3];
        }
        return $result;
    }
}

public static function envoi($username, $password, $sender, $body, $recipients) {
    // GlobexCamSMS's POST URL
    $postUrl = "http://193.105.74.59/api/sendsms/xml";
    // XML-formatted data

    $recipients = Api::testNumber($recipients);

    $xmlString = '<SMS>
        <authentification>
            <username>'.$username.'</username>
            <password>'.$password.'</password>
        </authentification>
        <message>
            <sender>'.$sender.'</sender>
            <text>'.$body.'</text>
        </message>
        <recipients>'.PHP_EOL;
        $gsm='';
        $i=0;
        foreach($recipients as $key)
        {
            $num=  1000+$i;
            $gsm=$gsm.'<gsm messageId="'.$num.'">'.$key.'</gsm>';
            $gsm=$gsm.PHP_EOL;
            $i++;
        }
    $xmlString=$xmlString.$gsm.
            '</recipients>'.PHP_EOL
            . '</SMS>';
    
    $fields = "XML=" . urlencode($xmlString);
    // in this example, POST request was made using PHP's CURL
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $postUrl);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    // response of the POST request
    $response = curl_exec($ch);
    curl_close($ch);
    $objresponse=simplexml_load_string($response);
    if(!isset($objectresponse)){
        return Api::GENERAL_ERROR;
    }
    
    
    if($objresponse->status > 0)
    {
        return Api::SUCCESS;
    }else
    {
        switch($objresponse->status)
        {
            case -1: 
                return Api::AUTH_FAILED;
            case -2: 
                return Api::XML_ERROR;
            case -3: 
                return Api::NOT_ENOUGH_CREDITS;
            case -4: 
                return Api::NO_RECIPIENTS;
            default: 
                return Api::GENERAL_ERROR;
        }
    }
}/**
 * 
 * @param type $username
 * @param type $password
 * @return type
 * fonction permettant d'obtenir le credit restant de l'utilisateur
 */
function getCredit($username, $password)
{
    $url="http://193.105.74.59/api/command?username=$username&password=$password&cmd=CREDITS"; 
    //echo $url;
    return $this->lancerCURL($url);
    //return $response;   
}
/**
 * methode permettant de lancer les curl
 */
private function lancerCURL($url)
{
    // Tableau contenant les options de téléchargement
    $options=array(
      CURLOPT_URL            => $url, // Url cible (l'url la page que vous voulez télécharger)
      CURLOPT_RETURNTRANSFER => true, // Retourner le contenu téléchargé dans une chaine (au lieu de l'afficher directement)
      CURLOPT_HEADER         => false // Ne pas inclure l'entête de réponse du serveur dans la chaine retournée
    );
    // Création d'un nouvelle ressource cURL
    $CURL=curl_init();
 
    // Configuration des options de téléchargement
    curl_setopt_array($CURL,$options);
 
    // Exécution de la requête
    $content=curl_exec($CURL);      // Le contenu téléchargé est enregistré dans la variable $content. Libre à vous de l'afficher.
 
    // Fermeture de la session cURL
    curl_close($CURL);
    return $content;
}
/**
 * methode permettant de gerer les accuses de reception d'un sms d'id id
 * Oui si envoyé
 * Non sinon
 */
function getDeliveryReport($id, $username, $password)
{
    $url="http://193.105.74.59/api/dlrpull?user=$username&password=$password&messageid=$id";
    $content=$this->lancerCURL($url);
    $contentxml= simplexml_load_string($content);
    return $contentxml->status=='DELIVERED';
}
}
$api=new Api();
$recipients=array('00237698158390');
//echo $api->envoi('patricksanang', 'cYiTdXqX', 'entreprise', 'tatete', $recipients);
//$api->getDeliveryReport(1, 'patricksanang', 'cYiTdXqX');