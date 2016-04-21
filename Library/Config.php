<?php
namespace Library;
/**
 * Description of Config
 *
 * @author hubert
 */
 
class Config extends ApplicationComponent
{
  protected $vars = array();
 
  public function __construct(Application $app) {
      parent::__construct($app);
  }
  public function get($var)
  {
    if (!$this->vars)
    {
      $xml = new \DOMDocument;
      $xml->load(__DIR__.'/../Config/app.xml');
 
      $elements = $xml->getElementsByTagName('define');
 
      foreach ($elements as $element)
      {
        $this->vars[$element->getAttribute('var')] = $element->getAttribute('value');
      }
    }
 
    if (isset($this->vars[$var]))
    {
      return $this->vars[$var];
    }
 
    return null;
  }
  /**
   * methode permettant de modifier une variable
   */
  public function set($var, $value)
  {
      $xml = new \DOMDocument;
      $xml->load(__DIR__.'/../Config/app.xml');
 
      
      //on commence par supprimer 
      $elements = $xml->getElementsByTagName('define');
 
      foreach ($elements as $element)
      {
          if($element->getAttribute('var')==$var)
          {
             $xml->documentElement->removeChild($element);
          }
      }
      $define=$xml->createElement('define');
      $define->setAttribute('var', $var);
      $define->setAttribute('value', $value);
      $xml->documentElement->appendChild($define);
      $xml->save(__DIR__.'/../Config/app.xml');
  }
}
