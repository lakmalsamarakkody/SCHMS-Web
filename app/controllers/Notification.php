<?php

use Carbon\Carbon;

class Notification extends Controller {

	public function ajax_delete_notification() {

		// CHECK LOGIN STATUS
		if( !isset($_SESSION['user']) OR $_SESSION['user']['is_login'] != true ):
			header( 'Location:' . $this->config->get('base_url') . '/logout' );
			exit();
		endif;

		$this->load->model('notification');

		// VALIDATION : notification_id
		$is_valid_notification_id = GUMP::is_valid($this->request->post, array('notification_id' => 'required|numeric'));
		if ( $is_valid_notification_id !== true ):
			echo json_encode( array("status" => "failed", "message" => "Please select a valid notification" ), JSON_PRETTY_PRINT );
			exit();
		endif;

		// PROCEED TO DELETE
		if ( $this->model_notification->find($this->request->post['notification_id'])->delete() ):
			echo json_encode( array( "status" => "success" ), JSON_PRETTY_PRINT );
			exit();
		else:
			echo json_encode( array( "status" => "failed", "message" => "Cannot delete this notification. Please contact system administrator" ), JSON_PRETTY_PRINT );
			exit();
		endif;
    }
    
    public function ajax_read_notification() {

		// CHECK LOGIN STATUS
		if( !isset($_SESSION['user']) OR $_SESSION['user']['is_login'] != true ):
			header( 'Location:' . $this->config->get('base_url') . '/logout' );
			exit();
		endif;

        $this->load->model('notification');

		// VALIDATION : notification_id
		$is_valid_notification_id = GUMP::is_valid($this->request->post, array('notification_id' => 'required|numeric'));
		if ( $is_valid_notification_id !== true ):
			echo json_encode( array("status" => "failed", "message" => "Please select a valid notification" ), JSON_PRETTY_PRINT );
			exit();
		endif;

		// PROCEED TO DELETE
		if ( $this->model_notification->where('id', '=', $this->request->post['notification_id'])->update(['status' => '1']) ):
			echo json_encode( array( "status" => "success" ), JSON_PRETTY_PRINT );
			exit();
		else:
			echo json_encode( array( "status" => "failed", "message" => "Cannot mark as read this notification. Please contact system administrator" ), JSON_PRETTY_PRINT );
			exit();
		endif;
	}
}

?>