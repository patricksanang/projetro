<?php
/**
 * Description of HTTPRequest
 *
 * @author hubert
*/
       namespace Library;



class HTTPRequest extends ApplicationComponent
{


        public function cookieData($key){
                if(cookieExists($key)){
                    return $_COOKIE[$key];
                }else{
                    throw new \Exception("the cookie '$key' does not exist");
                }
        }

        public function cookieExists($key){
                return isset($_COOKIE[$key]);
        }

        public function getData($key){
                if($this->getExists($key)){
                    return $_GET[$key];
                }else{
                    throw new \Exception("attribut '$key' does not exist in GET data");
                }
        }
        public function getPost()
        {
            return $_POST;
        }
        public function getExists($key){
                return isset($_GET[$key]);
        }

        public function method(){
                return $_SERVER['REQUEST_METHOD'];
        }

        public function postExists($key){
                return isset($_POST[$key]);
        }

        public function postData($key){
            if($this->postExists($key)){
                return $_POST[$key];
            }else{
                throw new \Exception("attribut '$key' does not exist in POST data");
            }
        }

        

        public function requestURI(){
            $script_dir = dirname($_SERVER['SCRIPT_FILENAME']);
            $context_document_root = $_SERVER['CONTEXT_DOCUMENT_ROOT'];
            $path = str_replace($context_document_root , '' , $script_dir); 

            
            $request = str_replace($path , '' , $_SERVER['REQUEST_URI'] );
            return $request;
        }

        public function fileExists($key){
            return isset($_FILES[$key]);
        }

        public function FileData($key){
            if($this->fileExists($key)){
                return $_FILES[$key];
            }else{
                throw new \Exception("File '$key' does not exist in Request data");
            }
        }

        public function isAjax(){
            return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest';
        }

}

