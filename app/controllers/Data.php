<?php

class Data extends Controller {
    public function report($file) {
        $path = ABS_PATH.'/data/reports/'.$file.".pdf";
        header('Content-type:application/pdf');
        header('Content-disposition: inline; filename="'.$file.'"');
        header('content-Transfer-Encoding:binary');
        header('Accept-Ranges:bytes');
        readfile($path);
    }
}

?>