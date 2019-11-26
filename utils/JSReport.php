<?php

class JSReport {

    // GET REPORT
    public function get_report($name, $data = array(), $file = null) {

        // POST DATA
        $post = array(
            "template" => array(
                "name" => $name
            ),
            "data" => $data
        );

        // REQUEST
        $ch=curl_init('http://localhost:8080/api/report');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($post));
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        $res = curl_exec($ch);
        curl_close($ch);

        // SAVE
        if ( $file !== null ):
            if ( file_put_contents(ABS_PATH.'/data/reports/'.$file.'.pdf', $res) !== false ):
                return true;
            else:
                return false;
            endif;
        endif;

    }
}

?>