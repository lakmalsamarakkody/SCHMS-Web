<?php

class Data extends Controller {
    public function report($dir, $file) {

        //CHECK LOGIN STATUS
		if( !isset($_SESSION['user']) OR $_SESSION['user']['is_login'] != true ):
			header( 'Location:' . $this->config->get('base_url') . '/logout' );
			exit();
        endif;
        
        $path = ABS_PATH.'/data/reports/'.$dir.'/'.$file.".pdf";
        header('Content-type:application/pdf');
        header('Content-disposition: inline; filename="'.$file.'"');
        header('content-Transfer-Encoding:binary');
        header('Accept-Ranges:bytes');
        readfile($path);
    }
}

?>