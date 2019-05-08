<?php

class Request {


    // PROPERTIES
    public $get     = array();
    public $post    = array();
    public $cookie  = array();
    public $files   = array();
    public $server  = array();



    public function __construct() {
        $this->get      = self::clean($_GET);
        $this->post     = self::clean($_POST);
        $this->cookie   = self::clean($_COOKIE);
        $this->files    = self::clean($_FILES);
        $this->server   = self::clean($_SERVER);
    }



    /**
     *
     * This method will validate request to check
     * if array is passed and then clean all the values
     * in the request made from the client side. 
     *
     * @param Mixed $param
     * @return Mixed
     *
     */
    private function clean($param) {
        if ( is_array($param) ):
            foreach ( $param AS $key => $value ):
                unset($param[$key]);
                $param[self::clean($key)] = self::clean($value);
            endforeach;
        else:
            $param = htmlspecialchars($param, ENT_COMPAT, 'UTF-8');
        endif;

        return $param;
    }
}

?>