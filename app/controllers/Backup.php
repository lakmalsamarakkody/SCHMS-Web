<?php

use Carbon\Carbon;

class Backup extends Controller {
    public function index() {
    
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

        // VALIDATION : name
        $is_valid_name = GUMP::is_valid($this->request->post, array('name' => 'required|alpha_space|max_len,50'));
        if ( $is_valid_name !== true ):
            echo json_encode( array( "status" => "failed", "error" => "Please enter backup name" ), JSON_PRETTY_PRINT );
            exit();
        endif;

        // VALIDATION : description
        $is_valid_description = GUMP::is_valid($this->request->post, array('description' => 'required|valid_name|max_len,50'));
        if ( $is_valid_description !== true ):
            echo json_encode( array( "status" => "failed", "error" => "Please enter backup description" ), JSON_PRETTY_PRINT );
            exit();
        endif;

        // ASSIGN DATA TO MODEL
        $this->model_backup->name = $this->request->post['name'];
        $this->model_backup->description = $this->request->post['description'];
        $this->model_backup->date_time = Carbon::now();

        // SUBMIT
		if ( $this->model_backup->save() ):
			echo json_encode( array( "status" => "success" ), JSON_PRETTY_PRINT );
		else:
			echo json_encode( array( "status" => "failed", "error" => "Backup creation failed. Please try again." ), JSON_PRETTY_PRINT );
		endif;
    }
}
?>