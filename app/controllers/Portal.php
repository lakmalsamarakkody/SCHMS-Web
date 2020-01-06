<?php

use Carbon\Carbon;
use Illuminate\Database\Capsule\Manager as DB;

class Portal extends Controller {
    
    public function student($student_id){

        // SITE DETAILS
        $data['app']['url']         = $this->config->get('base_url');
        $data['app']['title']       = $this->config->get('site_title');
        $data['app']['theme']       = $this->config->get('app_theme');

        // HEADER/FOOTER
        $data['template']['header'] = $this->load->controller('common/header', $data);
        $data['template']['topmenu'] = $this->load->controller('common/portal_topmenu', $data);
        $data['template']['footer'] = $this->load->controller('common/footer', $data);

        // MODEL
        $this->load->model('parent');
        $this->load->model('student');
        $this->load->model('student/parent');
        $this->load->model('student/relation');
        $this->load->model('class');
        $this->load->model('grade');
        $this->load->model('religion');
        $this->load->model('district');
        $this->load->model('user');
        $this->load->model('user/role');

        //CHECK LOGIN STATUS
		if( !isset($_SESSION['user']) OR $_SESSION['user']['is_login'] != true ):
			header( 'Location:' . $this->config->get('base_url') . '/logout' );
			exit();
        endif;

        //QUERY ( CLASS )
        foreach( $this->model_class->select('id', 'grade_id', 'staff_id', 'name')->get() as $key => $element ):
            $data['classes'][$key]['id'] = $element->id;
            $data['classes'][$key]['grade']['id'] = $element->grade_id;
            $data['classes'][$key]['staff']['id'] = $element->staff_id;
            $data['classes'][$key]['name'] = $element->name;

            $data['classes'][$key]['grade']['name'] = $this->model_grade->select('name')->where('id', '=', $element->grade_id)->first()->name;
        endforeach;

        // QUERY ( RELIGION )
        foreach( $this->model_religion->select('id', 'name')->orderBy('name')->get() as $key => $element ):
            $data['religions'][$key]['id'] = $element->id;
            $data['religions'][$key]['name'] = $element->name;
        endforeach;

        // QUERY ( DISTRICT )
        foreach( $this->model_district->select('id', 'name')->orderBy('name')->get() as $key => $element ):
            $data['districts'][$key]['id'] = $element->id;
            $data['districts'][$key]['name'] = $element->name;
        endforeach;

        // QUERY ( USER ROLES )
        foreach( $this->model_user_role->get() as $key => $element ):
            $data['user']['roles'][$key]['id'] = $element->id;
            $data['user']['roles'][$key]['name'] = $element->name;
        endforeach;

        // CHECK EXISTING STUDENT
        $student = $this->model_student->where('id', '=', $student_id)->first();

        // VIEW ERROR IF NO STUDENT EXIST
        if ( $student == null ){
            return http_response_code(404);
        }

        // BIO DATA
        $data['student'] = $student;

            $class_data = DB::table('student')
            ->join('class', 'student.class_id', 'class.id')
            ->join('grade', 'class.grade_id', 'grade.id')
            ->where('student.id', '=', $student->id)
            ->select('class.name as class_name', 'grade.name as grade_name')
            ->first();
            $data['grade']['name'] = $class_data->grade_name;
            $data['class']['letter'] = $class_data->class_name;
            $data['class']['name'] = $class_data->grade_name . " - " . $class_data->class_name;

        // PARENT
        $parents = $this->model_student_parent->select('parent_id','relation_id')->where('student_id', '=', $student_id)->get();
        if ( $parents !== null ):
            foreach( $parents as $key => $el ):
                $data['parents'][$key] = $this->model_parent->find($el->parent_id);
                $data['parents'][$key]['relation'] = $this->model_student_relation->where('id', '=', $el->relation_id)->first();
                unset($el);
            endforeach;
        endif;

        // SETTINGS DATA
        $settings_data = $this->model_user->where('ref_id', '=', $student_id)->where('user_type', '=', "student")->first();
        if ( $settings_data !== NULL):
            $data['settings']['user_role']['id'] = $settings_data->role_id;
            $data['settings']['user_role']['name'] = $this->model_user_role->where('id', '=', $settings_data->role_id)->first()->name;
            $data['settings']['username'] = $settings_data->username;
            ( $settings_data->password !== NULL ) ? $data['settings']['password'] = "Password exists" : $data['settings']['password'] = "No password";
            $data['settings']['theme'] = $settings_data->theme;
            $data['settings']['status'] = $settings_data->status;
        endif;

        // RENDER VIEW
        $this->load->view('portal/student', $data);
    }

    public function messages($id = null){

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
        $data['template']['topmenu']	= $this->load->controller('common/portal_topmenu', $data);
        
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

            $this->load->view('portal/messages', $data);
        else:
            
            /**
             * We need to display list of all the conversations specific
             * user have at a given time. Conversations will be sorted
             * using the message table with the help of grouping SQL.
             */
            $converstations = $this->model_message->select('id', 'sender_id', 'receiver_id')->where('receiver_id', '=', $_SESSION['user']['id'])->orwhere('sender_id', '=', $_SESSION['user']['id'])->groupBy('sender_id', 'receiver_id')->orderBy('created_on', 'DESC')->get();
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

            $this->load->view('portal/single', $data);
        endif;
    }

}
?>