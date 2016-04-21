<?php
/**
 * Description of Test
 *
 * @author hubert
 */

namespace Library;

class Route
{
        protected $action;
        protected $module;
        protected $url;
        protected $varsNames;
        protected $vars = array();

        public function __construct($url , $module , $action , array $varsNames){
                $this->setUrl($url);
                $this->setModule($module);
                $this->setAction($action);
                $this->setVarsNames($varsNames);
        }

        public function hasVars(){
                return !empty($this->varsNames);
        }

        public function match($url){
                //echo "on teste avec le pattern " . '`^'.$this->url.'$`'.'<br/>';
                if(preg_match('`^'.$this->url.'$`', $url , $matches)){
                        //echo "c'est bon <br>";
                        //print_r($matches);
                        return $matches;
                }else{
                        //echo "c'est pas bon<br>";
                        return false;
                }
        }

        public function setAction($action){
                if(is_string($action)){
                        $this->action = $action;
                }
        }

        public function setModule($module){
                if(is_string($module)){
                        $this->module = $module;
                }
        }

        public function setUrl($url){
                if(is_string($url)){
                        $this->url = $url;
                }
        }

        public function setVarsNames(array $varsNames){
                $this->varsNames = $varsNames;
        }

        public function action(){
                return $this->action;
        }

        public function module(){
                return $this->module;
        }

        public function vars(){
                return $this->vars;
        }
        
        public function setVars($vars) {
            $this->vars = $vars;
        }

        
        public function varsNames(){
                return $this->varsNames;
        }
}
