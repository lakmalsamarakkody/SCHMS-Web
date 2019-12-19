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



    // PROFILE PICTURE
    public function propic($action = null, $id = null) {

        // JPG
        header('Content-type: image/jpg');

        if ( $action !== null && $id !== null ):

            if ( $action == 'student' ):

                // MODELS
                $this->load->model('student');

                // CHECK USER
                $student = $this->model_student->select('id')->where('id', '=', $id)->first();
                if ( $student !== null ):

                    // CHECK PROFILE PIC EXISTS
                    $image = null;
                    if ( file_exists( ABS_PATH.'/data/uploads/propics/student/'.$id.'.jpg' ) ):
                        $image = imagecreatefromjpeg(ABS_PATH.'/data/uploads/propics/student/'.$id.'.jpg');
                    else:
                        $image = imagecreatefromjpeg(ABS_PATH.'/data/img/default_user.jpg');
                    endif;

                    imagejpeg($image);
                    // $image->destroy();
                endif;

            elseif( $action == 'staff' ):

                // MODELS
                $this->load->model('staff');

                // CHECK USER
                $staff = $this->model_staff->select('id')->where('id', '=', $id)->first();
                if ( $staff !== null ):

                    // CHECK PROFILE PIC EXISTS
                    $image = null;
                    if ( file_exists( ABS_PATH.'/data/uploads/propics/staff/'.$id.'.jpg' ) ):
                        $image = imagecreatefromjpeg(ABS_PATH.'/data/uploads/propics/staff/'.$id.'.jpg');
                    else:
                        $image = imagecreatefromjpeg(ABS_PATH.'/data/img/default_user.jpg');
                    endif;

                    imagejpeg($image);
                    // $image->destroy();
                endif;

            elseif( $action == 'parent' ):

                // MODELS
                $this->load->model('parent');

                // CHECK USER
                $parent = $this->model_parent->select('id')->where('id', '=', $id)->first();
                if ( $parent !== null ):

                    // CHECK PROFILE PIC EXISTS
                    $image = null;
                    if ( file_exists( ABS_PATH.'/data/uploads/propics/parent/'.$id.'.jpg' ) ):
                        $image = imagecreatefromjpeg(ABS_PATH.'/data/uploads/propics/parent/'.$id.'.jpg');
                    else:
                        $image = imagecreatefromjpeg(ABS_PATH.'/data/img/default_user.jpg');
                    endif;

                    imagejpeg($image);
                    // $image->destroy();
                endif;

            elseif( $action == 'coach' ):

                // MODELS
                $this->load->model('coach');

                // CHECK USER
                $coach = $this->model_coach->select('id')->where('id', '=', $id)->first();
                if ( $coach !== null ):

                    // CHECK PROFILE PIC EXISTS
                    $image = null;
                    if ( file_exists( ABS_PATH.'/data/uploads/propics/coach/'.$id.'.jpg' ) ):
                        $image = imagecreatefromjpeg(ABS_PATH.'/data/uploads/propics/coach/'.$id.'.jpg');
                    else:
                        $image = imagecreatefromjpeg(ABS_PATH.'/data/img/default_user.jpg');
                    endif;

                    imagejpeg($image);
                    // $image->destroy();
                endif;

            endif;

        endif;
    }
}

?>