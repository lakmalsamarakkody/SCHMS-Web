<?php

use Carbon\Carbon;
use Illuminate\Database\Capsule\Manager as DB;

class Messages extends Controller {
    
    public function index($id = null){

        //CHECK LOGIN STATUS
        if( !isset($_SESSION['user']) OR $_SESSION['user']['is_login'] != true ):
            header( 'Location:' . $this->config->get('base_url') . '/login' );
            exit();
        endif;

        // SITE DETAILS
        $data['app']['url']			= $this->config->get('base_url');
        $data['app']['title']		= $this->config->get('site_title');
        $data['app']['theme']		= $this->config->get('app_theme');

        // HEADER / FOOTER
        $data['template']['header']		= $this->load->controller('common/header', $data);
        $data['template']['footer']		= $this->load->controller('common/footer', $data);
        $data['template']['topmenu']	= $this->load->controller('common/topmenu', $data);
        $data['template']['sidenav']	= $this->load->controller('common/sidenav', $data);
        // MODELS
        $this->load->model('user');
        $this->load->model('message');
        $this->load->model('staff');
        $this->load->model('student');
        $this->load->model('parent');
        $this->load->model('coach');

        $date_now = Carbon::now()->isoFormat('YYYY-MM-DD');
        $time_now = Carbon::now();

        if ( $id !== null ):

            // SINGLE CONVERSATION
            $messages = $this->model_message->select('id', 'sender_id', 'receiver_id', 'body', 'created_on');

            // GET MESSAGES RELEVENT TO THIS CONVERSATION
            $messages->orwhere(function($query) use ($id) {
                $query->where(function ($query) {
                    $query->where('receiver_id', $_SESSION['user']['id']);
                });
                $query->where(function ($query) use ($id) {
                    $query->where('sender_id', $id);
                });
            });
            $messages->orwhere(function($query) use ($id) {
                $query->where(function ($query) use ($id) {
                    $query->where('receiver_id', $id);
                });
                $query->where(function ($query) {
                    $query->where('sender_id', $_SESSION['user']['id']);
                });
            });
            $messages->orderBy('created_on', 'asc')->take(50);

            foreach ( $messages->get() as $key => $el ):
                $data['messages'][$key]['id']           = $el->id;
                $data['messages'][$key]['owner']        = ($el->sender_id === $_SESSION['user']['id']) ? true : false;
                $data['messages'][$key]['sender_id']    = $el->sender_id;
                $data['messages'][$key]['receiver_id']  = $el->receiver_id;
                $data['messages'][$key]['body']         = $el->body;
                $data['messages'][$key]['time']         = $el->created_on;

                // UPDATING UPDATED_ON TIME
                if ( $el->sender_id !== $_SESSION['user']['id'] ):
                    try {
                        $this->model_message->where('id', '=', $el->id)->update([
                            'updated_on' => $time_now
                        ]);
                    } catch (\Illuminate\Database\QueryException $e) {
                    }
                endif;
            endforeach;

            // CHAT PERSON DATA
            $participant_data = $this->model_user->select('ref_id', 'user_type')->where('id', '=',$id)->first();
            $data['participant']['user_id'] = $id;
            $data['participant']['id'] = $participant_data->ref_id;
            $data['participant']['type'] = $this->model_user->select('user_type')->where('id', '=', $id)->first()->user_type;
            $data['participant']['image']['path'] = $participant_data->user_type."/".$participant_data->ref_id;

            $model_name = "model_".$data['participant']['type'];
            $participant_name = $this->$model_name->select('initials', 'surname')->where('id', '=', $participant_data->ref_id)->first();
            $data['participant']['name'] = $participant_name->initials." ".$participant_name->surname;

            // YOUR DATA
            $receiver_data = $this->model_user->select('ref_id', 'user_type')->where('id', '=',$_SESSION['user']['id'])->first();
            $data['your']['id'] = $receiver_data->ref_id;
            $data['your']['type'] = $receiver_data->user_type;
            $data['your']['image']['path'] = $receiver_data->user_type."/".$receiver_data->ref_id;

            $this->load->view('messages/single', $data);
        else:
            
            /**
             * We need to display list of all the conversations specific
             * user have at a given time. Conversations will be sorted
             * using the message table with the help of grouping SQL.
             */
            // $converstations = $this->model_message->select('id', 'sender_id', 'receiver_id')->where('receiver_id', '=', $_SESSION['user']['id'])->orwhere('sender_id', '=', $_SESSION['user']['id'])->groupBy('sender_id', 'receiver_id')->orderBy('created_on', 'DESC')->get();
            
            $id = $_SESSION['user']['id'];
            
            $converstations = DB::select('
            SELECT t1.*
            FROM message AS t1
            INNER JOIN
            (
                SELECT
                    LEAST(sender_id, receiver_id) AS sender_id,
                    GREATEST(sender_id, receiver_id) AS receiver_id,
                    MAX(id) AS max_id
                FROM message
                GROUP BY
                    LEAST(sender_id, receiver_id),
                    GREATEST(sender_id, receiver_id)
            ) AS t2
                ON LEAST(t1.sender_id, t1.receiver_id) = t2.sender_id AND
                   GREATEST(t1.sender_id, t1.receiver_id) = t2.receiver_id AND
                   t1.id = t2.max_id
                WHERE t1.sender_id = ? OR t1.receiver_id = ?
            ', [$id, $id]);

            foreach( $converstations as $key => $element ):

                // SELECTING IS PARTICIPANT SENDER OR RECEIVER
                if ( $element->sender_id == $_SESSION['user']['id'] ):
                    $user = $this->model_user->find($element->receiver_id);

                    // QUERY ( LAST MESSAGE WHEN RECEIVER ID IS THE PARTICIPANT )
                    $messages = $this->model_message->select('id', 'sender_id', 'receiver_id', 'body', 'created_on', 'updated_on');
                    $messages->where(function($query) {
                        $query->orWhere(function ($query) {
                            $query->where('receiver_id', $_SESSION['user']['id']);
                        });
                        $query->orWhere(function ($query) {
                            $query->where('sender_id', $_SESSION['user']['id']);
                        });
                    });
                    $messages->where(function($query) use ($element) {
                        $query->orWhere(function ($query) use ($element) {
                            $query->where('receiver_id', $element->receiver_id);
                        });
                        $query->orWhere(function ($query) use ($element) {
                            $query->where('sender_id', $element->receiver_id);
                        });
                    });
                    $messages->orderBy('created_on', 'desc');
                    $messages = $messages->first();

                else:
                    $user = $this->model_user->find($element->sender_id);

                    // QUERY ( LAST MESSAGE WHEN SENDER ID IS THE PARTICIPANT )
                    $messages = $this->model_message->select('id', 'sender_id', 'receiver_id', 'body', 'created_on', 'updated_on');
                    $messages->where(function($query) {
                        $query->orWhere(function ($query) {
                            $query->where('receiver_id', $_SESSION['user']['id']);
                        });
                        $query->orWhere(function ($query) {
                            $query->where('sender_id', $_SESSION['user']['id']);
                        });
                    });
                    $messages->where(function($query) use ($element) {
                        $query->orWhere(function ($query) use ($element) {
                            $query->where('receiver_id', $element->sender_id);
                        });
                        $query->orWhere(function ($query) use ($element) {
                            $query->where('sender_id', $element->sender_id);
                        });
                    });
                    $messages->orderBy('created_on', 'desc');
                    $messages = $messages->first();
                endif;

                // RESOLVE PARTICIAPNT
                $data['conversations'][$key]['user']['username'] = $user->username;
                $data['conversations'][$key]['user']['id'] = $user->id;
                $data['conversations'][$key]['user']['ref_id'] = $user->ref_id;
                $data['conversations'][$key]['user']['type'] = $user->user_type;
                $data['conversations'][$key]['user']['message'] = $messages;
                ( $messages->receiver_id == $_SESSION['user']['id'] ) ? $data['conversations'][$key]['user']['message']['receiver'] = TRUE : $data['conversations'][$key]['user']['message']['receiver'] = FALSE ;

                // CONVERSATION PERSON DATA
                $data['conversations'][$key]['image']['path'] = $user->user_type."/".$user->ref_id;
                $model_name = "model_".$user->user_type;
                $participant_name = $this->$model_name->select('initials', 'surname')->where('id', '=', $user->ref_id)->first();
                $data['conversations'][$key]['user']['name'] = $participant_name->initials." ".$participant_name->surname;

            endforeach;

            $this->load->view('messages/index', $data);
        endif;
    }

    public function ajax_retrive_receiver_by_type($type) {

        //CHECK LOGIN STATUS
		if( !isset($_SESSION['user']) OR $_SESSION['user']['is_login'] != true ):
			header( 'Location:' . $this->config->get('base_url') . '/logout' );
			exit();
		endif;

        // SET JSON HEADER
        header('Content-Type: application/json');

        // MODEL
        $this->load->model('staff');
        $this->load->model('student');
        $this->load->model('parent');
        $this->load->model('coach');

        $receiver_model = "model_".$type;

        echo json_encode(array( "status" => "success", "data" => $this->$receiver_model->select('id', 'full_name')->get() ));
    }

    public function ajax_compose_new_msg(){

        //CHECK LOGIN STATUS
		if( !isset($_SESSION['user']) OR $_SESSION['user']['is_login'] != true ):
			header( 'Location:' . $this->config->get('base_url') . '/logout' );
			exit();
		endif;

		/**
		  * This method will receive ajax request from
		  * the front end with the payload
		  * 
		  *	- receiver_type, receiver_id, message_body
		  * 
		  * We need to validate the data and then perform
		  * the following tasks.
		  *    - validate
		  *    - CRUD
		  *    - response ( JSON )
		  */
 
        // SET JSON HEADER
        header('Content-Type: application/json');
        
		//  MODEL
        $this->load->model('user');
        $this->load->model('message');

		// VALIDATION : receiver_type
		$is_valid_receiver_type = GUMP::is_valid($this->request->post, array('receiver_type' => 'required|contains_list,staff;student;parent;coach'));
		if ( $is_valid_receiver_type !== true ):
			echo json_encode( array( "status" => "failed", "message" => "Please select a valid receiver type" ), JSON_PRETTY_PRINT );
			exit();
        endif;

        // VALIDATION : receiver_id
		$is_valid_receiver_id = GUMP::is_valid($this->request->post, array('receiver_id' => 'required|numeric|min_len,1|max_len,8'));
		if ( $is_valid_receiver_id !== true ):
			echo json_encode( array( "status" => "failed", "message" => "Please select a valid receiver" ), JSON_PRETTY_PRINT );
			exit();
        endif;

        // IS EXIST : receiver_id
		$user = $this->model_user->select('id')->where('ref_id', '=', $this->request->post['receiver_id'])->where('user_type', '=', $this->request->post['receiver_type'])->where('status', '=', "Active")->first();
		if( $user == NULL ):
			echo json_encode( array( "status" => "failed", "message" => "Person you are trying to send this message is not an active user" ), JSON_PRETTY_PRINT );
			exit();
		endif;
        
        // VALIDATION : message
		$is_valid_message = GUMP::is_valid($this->request->post, array('message_body' => 'required'));
		if ( $is_valid_message !== true ):
			echo json_encode( array( "status" => "failed", "message" => "Please type a message" ), JSON_PRETTY_PRINT );
			exit();
        endif;

        $this->model_message->sender_id = $_SESSION['user']['id'];
        $this->model_message->receiver_id = $user->id;
        $this->model_message->body = $this->request->post['message_body'];
		
		// SUBMIT
		if ( $this->model_message->save() ):
            echo json_encode( array( "status" => "success" ), JSON_PRETTY_PRINT );
            exit();
		else:
            echo json_encode( array( "status" => "failed", "message" => "Message sending failed. Please contact your System Administrator" ), JSON_PRETTY_PRINT );
            exit();
		endif;
    }


    public function ajax_send_msg(){

        //CHECK LOGIN STATUS
		if( !isset($_SESSION['user']) OR $_SESSION['user']['is_login'] != true ):
			header( 'Location:' . $this->config->get('base_url') . '/logout' );
			exit();
		endif;

		/**
		  * This method will receive ajax request from
		  * the front end with the payload
		  * 
		  *	- participant_id, msg
		  * 
		  * We need to validate the data and then perform
		  * the following tasks.
		  *    - validate
		  *    - CRUD
		  *    - response ( JSON )
		  */
 
        // SET JSON HEADER
        header('Content-Type: application/json');
        
		//  MODEL
        $this->load->model('user');
        $this->load->model('message');

		// VALIDATION : participant_id
		$is_valid_participant_id = GUMP::is_valid($this->request->post, array('participant_id' => 'required|numeric|min_len,1|max_len,8'));
		if ( $is_valid_participant_id !== true ):
			echo json_encode( array( "status" => "failed", "message" => "Please select a valid conversation" ), JSON_PRETTY_PRINT );
			exit();
        endif;

        // IS EXIST : participant_id
		$is_exist = $this->model_user->select('id')->where('id', '=', $this->request->post['participant_id'])->first();
		if( $is_exist == NULL ):
			echo json_encode( array( "status" => "failed", "message" => "Message sending failed. user doesn't exists" ), JSON_PRETTY_PRINT );
			exit();
		endif;
        
        // VALIDATION : message
		$is_valid_message = GUMP::is_valid($this->request->post, array('message' => 'required'));
		if ( $is_valid_message !== true ):
			echo json_encode( array( "status" => "failed", "message" => "Please type a message" ), JSON_PRETTY_PRINT );
			exit();
        endif;

        $this->model_message->sender_id = $_SESSION['user']['id'];
        $this->model_message->receiver_id = $this->request->post['participant_id'];
        $this->model_message->body = $this->request->post['message'];
		
		// SUBMIT
		if ( $this->model_message->save() ):
            echo json_encode( array( "status" => "success" ), JSON_PRETTY_PRINT );
            exit();
		else:
            echo json_encode( array( "status" => "failed", "message" => "Message sending failed. Please contact your System Administrator" ), JSON_PRETTY_PRINT );
            exit();
		endif;
    }
}
?>