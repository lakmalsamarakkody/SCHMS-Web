<?php

use Carbon\Carbon;
use Ifsnop\Mysqldump as MySQLDump;

class Backup extends Controller {
    public function index() {

        //CHECK LOGIN STATUS
		if( !isset($_SESSION['user']) OR $_SESSION['user']['is_login'] != true ):
			header( 'Location:' . $this->config->get('base_url') . '/logout' );
			exit();
		endif;
    
        // SITE DETAILS
		$data['app']['url']			= $this->config->get('base_url');
		$data['app']['title']		= $this->config->get('site_title');
		$data['app']['theme']		= $this->config->get('app_theme');

		// HEADER / FOOTER
		$data['template']['header']		= $this->load->controller('common/header', $data);
        $data['template']['footer']		= $this->load->controller('common/footer', $data);
        $data['template']['sidenav']	= $this->load->controller('common/sidenav', $data);
        $data['template']['topmenu']	= $this->load->controller('common/topmenu', $data);

        // MODEL
        $this->load->model('backup');
        $this->load->model('user');

        // CHECK PERMISSION : index
        if ( $this->model_user->find($_SESSION['user']['id'])->hasPermission('backup-index-view') ):
            $data['permission']['backup']['index']['view'] = true;
        else:
            $data['permission']['backup']['index']['view'] = false;
        endif;

        foreach ( $this->model_backup->orderBy('date_time', 'DESC')->get() as $key => $element ):
            $data['backups'][$key]['id'] = $element->id;
            $data['backups'][$key]['name'] = $element->name;
            $data['backups'][$key]['description'] = $element->description;
            $data['backups'][$key]['date_time'] = $element->date_time;
            $data['backups'][$key]['file_size'] = $element->file_size;
        endforeach;

		// RENDER VIEW
        $this->load->view('backup/index', $data);
    }



    public function ajax_add() {

        //CHECK LOGIN STATUS
		if( !isset($_SESSION['user']) OR $_SESSION['user']['is_login'] != true ):
			header( 'Location:' . $this->config->get('base_url') . '/logout' );
			exit();
		endif;

        /**
         * This method will receive ajax request from
         * the front end with the payload
         * 
         *	name
         *  description
         * 
         * We need to validate the data and then perform
         * the following tasks.
         *    - validate
         *    - CRUD
         *    - response ( JSON )
         */

        // MODEL
        $this->load->model('backup');

        // SET JSON HEADER
        header('Content-Type: application/json');

        // VALIDATION : description
        $is_valid_description = GUMP::is_valid($this->request->post, array('description' => 'required|valid_name|max_len,50'));
        if ( $is_valid_description !== true ):
            echo json_encode( array( "status" => "failed", "error" => "Please enter backup description" ), JSON_PRETTY_PRINT );
            exit();
        endif;

        // FILENAME
        $file = 'DB_'.Carbon::now()->format('Ymd_His').'.sql';

        try {
            $SQLDump = new MySQLDump\Mysqldump('mysql:host='.$this->config->get('db_host').';dbname='.$this->config->get('db_name'), $this->config->get('db_user'), $this->config->get('db_pass'));
            $SQLDump->start(ABS_PATH.'/data/backups/'.$file);
        } catch(Exception $e) {
            echo json_encode( array( "status" => "failed", "error" => "Backup creation failed. Please try again." ), JSON_PRETTY_PRINT );
            exit();
        }

        // FILE SIZE
        $filesize = filesize(ABS_PATH.'/data/backups/'.$file) / 1024;

        // ASSIGN DATA TO MODEL
        $this->model_backup->name = $file;
        $this->model_backup->description = $this->request->post['description'];
        $this->model_backup->date_time = Carbon::now();
        $this->model_backup->file_size = $filesize;

        // SUBMIT
		if ( $this->model_backup->save() ):
			echo json_encode( array( "status" => "success" ), JSON_PRETTY_PRINT );
		else:
			echo json_encode( array( "status" => "failed", "error" => "Backup creation failed. Please try again." ), JSON_PRETTY_PRINT );
		endif;
    }

    // START : DELETE BACKUPS
    public function delete_backup_ajax() {

        //CHECK LOGIN STATUS
		if( !isset($_SESSION['user']) OR $_SESSION['user']['is_login'] != true ):
			header( 'Location:' . $this->config->get('base_url') . '/logout' );
			exit();
		endif;

        // SET JSON HEADER
        header('Content-Type: application/json');

        // MODELS
        $this->load->model("backup");

        // QUERY BACKUP
        $backup = $this->model_backup->find($this->request->post['backup_id']);

        // REMOVE FILE
        // unlink( ABS_PATH.'/data/backups/'.$backup->name );

        // REMOVE DATABASE RECORD
        if ( $backup->delete() ):
            echo json_encode( array("status" => "success", "msg" => "Backup Deleted Successfully" ), JSON_PRETTY_PRINT );  
            exit();
        endif;
    }
    // END : DELETE BACKUPS

}
?>