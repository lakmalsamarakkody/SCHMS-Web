<?php

use Carbon\Carbon;
use Illuminate\Database\Capsule\Manager as DB;

class Portal extends Controller {
    
    public function student($student_id){

        //CHECK LOGIN STATUS
		if( !isset($_SESSION['user']) OR $_SESSION['user']['is_login'] != true ):
			header( 'Location:' . $this->config->get('base_url') . '/logout' );
			exit();
        endif;

        // SITE DETAILS
        $data['app']['url']         = $this->config->get('base_url');
        $data['app']['title']       = $this->config->get('site_title');
        $data['app']['theme']       = $this->config->get('app_theme');

        // HEADER/FOOTER
        $data['template']['header'] = $this->load->controller('common/header', $data);
        $data['template']['topmenu'] = $this->load->controller('common/portal_topmenu', $data);
        $data['template']['footer'] = $this->load->controller('common/footer', $data);

        // MODEL
        $this->load->model('class');
        $this->load->model('class/timetable');
        $this->load->model('coach');
        $this->load->model('coach/sport');
        $this->load->model('district');
        $this->load->model('exam');
        $this->load->model('exam/grade');
        $this->load->model('exam/schedule');
        $this->load->model('exam/type');
        $this->load->model('grade');
        $this->load->model('parent');
        $this->load->model('religion');
        $this->load->model('student');
        $this->load->model('student/exam');
        $this->load->model('student/health');
        $this->load->model('student/parent');
        $this->load->model('student/relation');
        $this->load->model('student/sport');
        $this->load->model('sport');
        $this->load->model('subject');
        $this->load->model('user');
        $this->load->model('user/role');

        // CHECK PERMISSION : student
        if ( $this->model_user->find($_SESSION['user']['id'])->hasPermission('portal-student-view') ):
            $data['permission']['portal']['student']['view'] = true;
        else:
            $data['permission']['portal']['student']['view'] = false;
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

        // RESULT TAB
        // $all_exams_old = $this->model_student_exam->select('exam_schedule_id', 'marks')->where('student_id', '=', $student->id)->orderBy('created_on', 'DESC');
        // foreach ( $all_exams_old->get() as $key => $element ):
        //     // GET ALL EXAM SCHEULES
        //     $exam_schedule = $this->model_exam_schedule->select('exam_grade_id', 'subject_id')->where('id', '=', $element->exam_schedule_id)->first();
        //     $data['exams'][$key]['subject']['name'] = $this->model_subject->select('name')->where('id', '=', $exam_schedule->subject_id)->first()->name;
        //     $data['exams'][$key]['subject']['marks'] = $element->marks;
        //     // GET EXAM AND GRADE
        //     $exam_name_grade = $this->model_exam_grade->select('exam_id', 'grade_id')->where('id', '=', $exam_schedule->exam_grade_id)->first();
        //     $data['exams'][$key]['grade']['name'] = "Grade - ".$this->model_grade->select('name')->where('id', '=', $exam_name_grade->grade_id)->first()->name;
        //     // GET EXAM TYPE
        //     $exam_type_year = $this->model_exam->select('type_id', 'year')->where('id', '=', $exam_name_grade->exam_id)->first();
        //     $data['exams'][$key]['exam']['name'] = $this->model_exam_type->select('name')->where('id', '=', $exam_type_year->type_id)->first()->name." - ".$exam_type_year->year;
        // endforeach;


        $all_exams = DB::table('student_has_exam_schedule')
            ->join('exam_grade_has_schedule', 'student_has_exam_schedule.exam_schedule_id', 'exam_grade_has_schedule.id')
            ->join('exam_has_grade', 'exam_grade_has_schedule.exam_grade_id', 'exam_has_grade.id')
            ->where('student_has_exam_schedule.student_id', '=', $student->id)
            ->groupBy('exam_has_grade.exam_id')
            ->orderBy('student_has_exam_schedule.created_on', 'DESC')
            ->select('exam_has_grade.id as exam_grade_id');

        foreach ( $all_exams->get() as $key => $value ):

            // EXAM ID AND GRADE
            $exam_id_grade = $this->model_exam_grade->select('exam_id', 'grade_id')->where('id', '=', $value->exam_grade_id)->first();
            $data['exams'][$key]['grade'] = $this->model_grade->select('name')->where('id', '=', $exam_id_grade->grade_id)->first()->name;

            // GET EXAM NAME
            $exam_type_year = $this->model_exam->select('type_id', 'year')->where('id', '=', $exam_id_grade->exam_id)->first();
            $data['exams'][$key]['name'] = $this->model_exam_type->select('name')->where('id', '=', $exam_type_year->type_id)->first()->name;
            $data['exams'][$key]['year'] = $exam_type_year->year;

            // GET RESULTS OF SAME EXAM
            $exam_result = DB::table('student_has_exam_schedule')
            ->join('exam_grade_has_schedule', 'student_has_exam_schedule.exam_schedule_id', 'exam_grade_has_schedule.id')
            ->join('exam_has_grade', 'exam_grade_has_schedule.exam_grade_id', 'exam_has_grade.id')
            ->join('exam', 'exam_has_grade.exam_id', 'exam.id')
            ->join('exam_type', 'exam.type_id', 'exam_type.id')
            ->join('grade', 'exam_has_grade.grade_id', 'grade.id')
            ->join('subject', 'exam_grade_has_schedule.subject_id', 'subject.id')
            ->where('student_has_exam_schedule.student_id', '=', $student->id)
            ->where('exam_has_grade.id', '=', $value->exam_grade_id)
            ->select('subject.name as subject_name', 'student_has_exam_schedule.marks');
            foreach ($exam_result->get() as $key2 => $value2  ):
                $data['exams'][$key]['subjects'][$key2]['name'] = $value2->subject_name;
                $data['exams'][$key]['subjects'][$key2]['marks'] = $value2->marks;
            endforeach;
        endforeach;

        // TIMETABLE TAB
        //STUDENT CLASSID
        $class_id = $student->class_id;
        
        // SUBJECTS
        $data['subjects'] = $this->model_subject->select('id', 'name', 'si_name')->orderBy('id')->get();

        // STAFF
        $data['staffs'] = $this->model_staff->select('id', 'initials', 'surname')->orderBy('surname')->get();

        // GET TIMETABLE OF CLASS
        foreach ( $this->model_class_timetable->select('id', 'class_id', 'day', 'period', 'subject_id', 'staff_id')->where('class_id', '=', $class_id)->get() as $key => $element ):
            $data['timetable'][$element->day][$element->period] = array(
                'subject_id' => $element->subject_id,
                'staff_id' => $element->staff_id
            );
        endforeach;

        // HEALTH TAB
        $data['health'] = $this->model_student_health->where('student_id', '=', $student->id)->first();

        // SPORTS TAB
        foreach ( $this->model_student_sport->where('student_id', '=', $student->id)->orderBy('sport_id')->get() as $key => $element ):
            if( $element != NULL ):
                $data['sports'][$key]['id'] = $element->sport_id;
                $data['sports'][$key]['name'] = $this->model_sport->select('name')->where('id', '=', $element->sport_id)->first()->name;
                $coach = $this->model_coach_sport->select('coach_id')->where('sport_id', '=', $element->sport_id)->first();
                if ( $coach != NULL ):
                    $data['sports'][$key]['coach']['name'] = $this->model_coach->select('full_name')->where('id', '=', $coach->coach_id)->first()->full_name;
                endif;
            endif;
        endforeach;

        // ABOUT TAB
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

        // PARENT TAB
        $parents = $this->model_student_parent->select('parent_id','relation_id')->where('student_id', '=', $student_id)->get();
        if ( $parents !== null ):
            foreach( $parents as $key => $el ):
                $data['parents'][$key] = $this->model_parent->find($el->parent_id);
                $data['parents'][$key]['relation'] = $this->model_student_relation->where('id', '=', $el->relation_id)->first();
                unset($el);
            endforeach;
        endif;

        // ACCOUNT TAB
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

    public function ajax_updatestudent() {
        
        // CHECK LOGIN STATUS
		if( !isset($_SESSION['user']) OR $_SESSION['user']['is_login'] != true ):
			header( 'Location:' . $this->config->get('base_url') . '/logout' );
			exit();
        endif;

		// SET JSON HEADER
        header('Content-Type: application/json');

        // MODEL
        $this->load->model('student');
        $this->load->model('user');

        // PERMISSION
        if ( !$this->model_user->find($_SESSION['user']['id'])->hasPermission('portal-student-edit') ):
            echo json_encode( array( "status" => "failed", "message" => "Permission denied" ), JSON_PRETTY_PRINT );
            exit();
        endif;

        if ( isset($this->request->post['student_id']) AND !empty($this->request->post['student_id']) ):
            $is_valid_student_id = $this->model_student->select('id')->where('id', '=', $this->request->post['student_id']);

            if ( $is_valid_student_id->first() !== NULL ):

                // VALIDATION : username
                $is_valid_username = GUMP::is_valid($this->request->post, array('username' => 'required|alpha_numeric|min_len,6|max_len,20'));
                if ( $is_valid_username !== true ):
                    echo json_encode( array("status" => "failed", "message" => "Please select a valid username of minimum 6 characters" ), JSON_PRETTY_PRINT );
                    exit();
                endif;

                // CHECK ANY USER AVAILABLE
                $is_available_user = $this->model_user->select('id')->where('user_type', '=', 'student')->where('ref_id', '=', $this->request->post['student_id']);
                if ( $is_available_user->first() != NULL):
                     // IS CHANGED USERNAME
                    $current_username = $this->model_user->select('username')->where('user_type', '=', 'student')->where('ref_id', '=', $this->request->post['student_id'])->first();
                    if ( $current_username->username != $this->request->post['username']):
                        // USERNAME IS CHANGED : CHECK FOR DUPLICATE
                        if ( $this->model_user->select('id')->where('username', '=', $this->request->post['username'])->first() != NULL ):
                            echo json_encode( array( "status" => "failed", "message" => "This username already exists" ), JSON_PRETTY_PRINT );
                            exit();
                        endif;
                    endif;
                endif;

                // UPDATE PROCESS
                try {
                    // UPDATE SETTINGS IF AVAILABLE USER FOUND
                    $is_available_user = $this->model_user->select('id')->where('user_type', '=', 'student')->where('ref_id', '=', $this->request->post['student_id']);
                    if ( $is_available_user->first() != NULL):

                        // UPDATE STATUS,ROLE,USERNAME
                        $this->model_user->where('user_type', '=', 'student')->where('ref_id', '=', $this->request->post['student_id'])->update([
                            'username' => $this->request->post['username']
                        ]);
                    endif;

                    echo json_encode( array("status" => "success"), JSON_PRETTY_PRINT );
                    exit();

                } catch (\Illuminate\Database\QueryException $e) {
                    // var_dump( $e->errorInfo );
                    echo json_encode( array( "status" => "failed", "message" => "Unable to edit username. Please contact your System Administrator" ), JSON_PRETTY_PRINT );
                    exit();
                }
            else:
                // NO RECORD FOUND TO UPDATE
				echo json_encode( array( "status" => "failed", "message" => "No Student record found to modify" ), JSON_PRETTY_PRINT );
				exit();
			endif;
        else:
            // STUDENT ID IS NOT SET
			echo json_encode( array( "status" => "failed", "message" => "Please select a valid Student record" ), JSON_PRETTY_PRINT );
			exit();
		endif;
    }

    public function ajax_update_student_password(){

        // CHECK LOGIN STATUS
		if( !isset($_SESSION['user']) OR $_SESSION['user']['is_login'] != true ):
			header( 'Location:' . $this->config->get('base_url') . '/logout' );
			exit();
        endif;

		// SET JSON HEADER
        header('Content-Type: application/json');

        // MODEL
        $this->load->model('student');
        $this->load->model('user');

        // PERMISSION
        if ( !$this->model_user->find($_SESSION['user']['id'])->hasPermission('portal-student-edit') ):
            echo json_encode( array( "status" => "failed", "message" => "Permission denied" ), JSON_PRETTY_PRINT );
            exit();
        endif;

        if ( isset($this->request->post['student_id']) AND !empty($this->request->post['student_id']) ):
            $is_valid_student_id = $this->model_student->select('id')->where('id', '=', $this->request->post['student_id']);

            if ( $is_valid_student_id->first() !== NULL ):

                // var_dump($this->request->post['new_password']);
                // exit();

                // VALIDATION : current_password
                $is_valid_current_password = GUMP::is_valid($this->request->post, array('current_password' => 'required|alpha_numeric|min_len,6|max_len,20'));
                if ( $is_valid_current_password !== true ):
                    echo json_encode( array("status" => "failed", "message" => "Please enter your current password of minimum 6 characters without any special characters and spaces except dash(-),underscore(_)" ), JSON_PRETTY_PRINT );
                    exit();
                endif;

                // CHECK ANY USER AVAILABLE
                $is_available_user = $this->model_user->select('id')->where('user_type', '=', 'student')->where('ref_id', '=', $this->request->post['student_id']);
                if ( $is_available_user->first() != NULL):
                    // IS CURRENT PASSWORD IS TRUE
                    $current_password = $this->model_user->select('password')->where('user_type', '=', 'student')->where('ref_id', '=', $this->request->post['student_id'])->first();
                    if ( password_verify ($this->request->post['current_password'], $current_password->password) == FALSE ):
                        echo json_encode( array( "status" => "failed", "message" => "Your current password is invalid" ), JSON_PRETTY_PRINT );
                        exit();
                    endif;
                endif;

                // VALIDATION : new_password
                $is_valid_new_password = GUMP::is_valid($this->request->post, array('new_password' => 'required|alpha_numeric|min_len,6|max_len,20'));
                if ( $is_valid_new_password !== true ):
                    echo json_encode( array("status" => "failed", "message" => "Please enter your new password of minimum 6 characters without any special characters and spaces except dash(-),underscore(_)" ), JSON_PRETTY_PRINT );
                    exit();
                endif;

                // CHECK : NEW PASSWORD != CURRENT PASSWORD
                if ( $this->request->post['new_password'] == $this->request->post['current_password'] ):
                    echo json_encode( array("status" => "failed", "message" => "Your New Password and Current password cannot be same" ), JSON_PRETTY_PRINT );
                    exit();
                endif;

                // VALIDATION : confirm_new_password
                $is_valid_confirm_new_password = GUMP::is_valid($this->request->post, array('confirm_new_password' => 'required|alpha_numeric|min_len,6|max_len,20'));
                if ( $is_valid_confirm_new_password !== true ):
                    echo json_encode( array("status" => "failed", "message" => "Please retype your valid confirmation password as same as the password" ), JSON_PRETTY_PRINT );
                    exit();
                endif;

                // CHECK : PASSWORD = CONFIRM PASSWORD
                if ( $this->request->post['new_password'] != $this->request->post['confirm_new_password'] ):
                    echo json_encode( array("status" => "failed", "message" => "Password and confirm password doesn't match" ), JSON_PRETTY_PRINT );
                    exit();
                endif;

                // UPDATE PROCESS
                try {
                    // UPDATE SETTINGS IF AVAILABLE USER FOUND
                    $is_available_user = $this->model_user->select('id')->where('user_type', '=', 'student')->where('ref_id', '=', $this->request->post['student_id']);
                    if ( $is_available_user->first() != NULL):

                        // UPDATE STATUS,ROLE,USERNAME
                        $this->model_user->where('user_type', '=', 'student')->where('ref_id', '=', $this->request->post['student_id'])->update([
                            'password' => password_hash($this->request->post['new_password'], PASSWORD_DEFAULT)
                        ]);
                    endif;

                    echo json_encode( array("status" => "success"), JSON_PRETTY_PRINT );
                    exit();

                } catch (\Illuminate\Database\QueryException $e) {
                    // var_dump( $e->errorInfo );
                    echo json_encode( array( "status" => "failed", "message" => "Unable to update password. Please contact your System Administrator" ), JSON_PRETTY_PRINT );
                    exit();
                }

            else:
                // NO RECORD FOUND TO UPDATE
				echo json_encode( array( "status" => "failed", "message" => "No student record found to modify" ), JSON_PRETTY_PRINT );
				exit();
			endif;
        else:
            // STUDENT ID IS NOT SET
			echo json_encode( array( "status" => "failed", "message" => "Please select a valid student record" ), JSON_PRETTY_PRINT );
			exit();
		endif;

    }

    public function parent($parent_id){

        //CHECK LOGIN STATUS
		if( !isset($_SESSION['user']) OR $_SESSION['user']['is_login'] != true ):
			header( 'Location:' . $this->config->get('base_url') . '/logout' );
			exit();
        endif;

        // SITE DETAILS
        $data['app']['url']         = $this->config->get('base_url');
        $data['app']['title']       = $this->config->get('site_title');
        $data['app']['theme']       = $this->config->get('app_theme');

        // HEADER/FOOTER
        $data['template']['header'] = $this->load->controller('common/header', $data);
        $data['template']['topmenu'] = $this->load->controller('common/portal_topmenu', $data);
        $data['template']['footer'] = $this->load->controller('common/footer', $data);

        // MODEL
        $this->load->model('class');
        $this->load->model('class/timetable');
        $this->load->model('coach');
        $this->load->model('coach/sport');
        $this->load->model('district');
        $this->load->model('exam');
        $this->load->model('exam/grade');
        $this->load->model('exam/schedule');
        $this->load->model('exam/type');
        $this->load->model('grade');
        $this->load->model('parent');
        $this->load->model('religion');
        $this->load->model('student');
        $this->load->model('student/exam');
        $this->load->model('student/health');
        $this->load->model('student/parent');
        $this->load->model('student/relation');
        $this->load->model('student/sport');
        $this->load->model('sport');
        $this->load->model('subject');
        $this->load->model('user');
        $this->load->model('user/role');

        // CHECK PERMISSION : parent
        if ( $this->model_user->find($_SESSION['user']['id'])->hasPermission('portal-parent-view') ):
            $data['permission']['portal']['parent']['view'] = true;
        else:
            $data['permission']['portal']['parent']['view'] = false;
        endif;

        //QUERY ( CLASS )
        foreach( $this->model_class->select('id', 'grade_id', 'staff_id', 'name')->get() as $key => $element ):
            $data['classes'][$key]['id'] = $element->id;
            $data['classes'][$key]['grade']['id'] = $element->grade_id;
            $data['classes'][$key]['staff']['id'] = $element->staff_id;
            $data['classes'][$key]['name'] = $element->name;

            $data['classes'][$key]['grade']['name'] = $this->model_grade->select('name')->where('id', '=', $element->grade_id)->first()->name;
        endforeach;

        //QUERY ( RELATIONSHIP )
		foreach( $this->model_student_relation->select('id', 'name')->orderBy('id')->get() as $key => $element ):
			$data['student_relations'][$key]['id'] = $element->id;
			$data['student_relations'][$key]['name']= $element->name;
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

        // USER STATUS
        $data['user']['status'][1]['name'] = 'Active';
        $data['user']['status'][2]['name'] = 'Inactive';

        // USER THEMES
        $data['user']['themes'][1]['name'] = 'Default';
        $data['user']['themes'][2]['name'] = 'Dark';

        // CHECK EXISTING PARENT
        $parent = $this->model_parent->where('id', '=', $parent_id)->first();

        // VIEW ERROR IF NO PARENT EXIST
        if ( $parent == null ){
            return http_response_code(404);
        }

        // BIO DATA
        $data['parent'] = $parent;

        // STUDENT DATA
        foreach ( $this->model_student_parent->where('parent_id', '=', $parent_id)->get() as $key => $element ):

            // ABOUT TAB
            $data['students'][$key]['relation_id'] = $element->relation_id;
            $data['students'][$key]['details'] = $this->model_student->where('id', '=', $element->student_id)->first();
            $student = $this->model_student->where('id', '=', $element->student_id)->first();

            // RESULT TAB
            $all_exams = DB::table('student_has_exam_schedule')
            ->join('exam_grade_has_schedule', 'student_has_exam_schedule.exam_schedule_id', 'exam_grade_has_schedule.id')
            ->join('exam_has_grade', 'exam_grade_has_schedule.exam_grade_id', 'exam_has_grade.id')
            ->where('student_has_exam_schedule.student_id', '=', $student->id)
            ->groupBy('exam_has_grade.exam_id')
            ->orderBy('student_has_exam_schedule.created_on', 'DESC')
            ->select('exam_has_grade.id as exam_grade_id');
            foreach ( $all_exams->get() as $key2 => $value2 ):

                // EXAM ID AND GRADE
                $exam_id_grade = $this->model_exam_grade->select('exam_id', 'grade_id')->where('id', '=', $value2->exam_grade_id)->first();
                $data['students'][$key]['exams'][$key2]['grade'] = $this->model_grade->select('name')->where('id', '=', $exam_id_grade->grade_id)->first()->name;

                // GET EXAM NAME
                $exam_type_year = $this->model_exam->select('type_id', 'year')->where('id', '=', $exam_id_grade->exam_id)->first();
                $data['students'][$key]['exams'][$key2]['name'] = $this->model_exam_type->select('name')->where('id', '=', $exam_type_year->type_id)->first()->name;
                $data['students'][$key]['exams'][$key2]['year'] = $exam_type_year->year;

                // GET RESULTS OF SAME EXAM
                $exam_result = DB::table('student_has_exam_schedule')
                ->join('exam_grade_has_schedule', 'student_has_exam_schedule.exam_schedule_id', 'exam_grade_has_schedule.id')
                ->join('exam_has_grade', 'exam_grade_has_schedule.exam_grade_id', 'exam_has_grade.id')
                ->join('exam', 'exam_has_grade.exam_id', 'exam.id')
                ->join('exam_type', 'exam.type_id', 'exam_type.id')
                ->join('grade', 'exam_has_grade.grade_id', 'grade.id')
                ->join('subject', 'exam_grade_has_schedule.subject_id', 'subject.id')
                ->where('student_has_exam_schedule.student_id', '=', $student->id)
                ->where('exam_has_grade.id', '=', $value2->exam_grade_id)
                ->select('subject.name as subject_name', 'student_has_exam_schedule.marks');
                foreach ($exam_result->get() as $key3 => $value3  ):
                    $data['students'][$key]['exams'][$key2]['subjects'][$key3]['name'] = $value3->subject_name;
                    $data['students'][$key]['exams'][$key2]['subjects'][$key3]['marks'] = $value3->marks;
                endforeach;                
            endforeach;

            // TIMETABLE TAB
            //STUDENT CLASSID
            $class_id = $student->class_id;
            // SUBJECTS
            $data['students'][$key]['subjects'] = $this->model_subject->select('id', 'name', 'si_name')->orderBy('id')->get();
            // STAFF
            $data['students'][$key]['staffs'] = $this->model_staff->select('id', 'initials', 'surname')->orderBy('surname')->get();
            // GET TIMETABLE OF CLASS
            foreach ( $this->model_class_timetable->select('id', 'class_id', 'day', 'period', 'subject_id', 'staff_id')->where('class_id', '=', $class_id)->get() as $key2 => $element ):
                $data['students'][$key]['timetable'][$element->day][$element->period] = array(
                    'subject_id' => $element->subject_id,
                    'staff_id' => $element->staff_id
                );
            endforeach;

            // HEALTH TAB
            $data['students'][$key]['health'] = $this->model_student_health->where('student_id', '=', $student->id)->first();

            // SPORTS TAB
            foreach ( $this->model_student_sport->where('student_id', '=', $student->id)->orderBy('sport_id')->get() as $key2 => $element ):
                if( $element != NULL ):
                    $data['students'][$key]['sports'][$key2]['id'] = $element->sport_id;
                    $data['students'][$key]['sports'][$key2]['name'] = $this->model_sport->select('name')->where('id', '=', $element->sport_id)->first()->name;
                    $coach = $this->model_coach_sport->select('coach_id')->where('sport_id', '=', $element->sport_id)->first();
                    if ( $coach != NULL ):
                        $data['students'][$key]['sports'][$key2]['coach']['name'] = $this->model_coach->select('full_name')->where('id', '=', $coach->coach_id)->first()->full_name;
                    endif;
                endif;
            endforeach;

        endforeach;

        // SYSTEM DATA
        $data['student']['count'] = $this->model_student_parent->select('id')->where('parent_id', '=', $parent_id)->get()->count();

        // SETTINGS DATA
        $settings_data = $this->model_user->where('ref_id', '=', $parent_id)->where('user_type', '=', "parent")->first();
        if ( $settings_data !== NULL):
            $data['settings']['user_role']['id'] = $settings_data->role_id;
            $data['settings']['user_role']['name'] = $this->model_user_role->where('id', '=', $settings_data->role_id)->first()->name;
            $data['settings']['username'] = $settings_data->username;
            ( $settings_data->password !== NULL ) ? $data['settings']['password'] = "Password exists" : $data['settings']['password'] = "No password";
            $data['settings']['theme'] = $settings_data->theme;
            $data['settings']['status'] = $settings_data->status;
        endif;

        // RENDER VIEW
        $this->load->view('portal/parent', $data);
    }

    public function ajax_updateparent() {
        
        // CHECK LOGIN STATUS
		if( !isset($_SESSION['user']) OR $_SESSION['user']['is_login'] != true ):
			header( 'Location:' . $this->config->get('base_url') . '/logout' );
			exit();
        endif;

		// SET JSON HEADER
        header('Content-Type: application/json');

        // MODEL
        $this->load->model('parent');
        $this->load->model('user');

        // PERMISSION
        if ( !$this->model_user->find($_SESSION['user']['id'])->hasPermission('portal-parent-edit') ):
            echo json_encode( array( "status" => "failed", "message" => "Permission denied" ), JSON_PRETTY_PRINT );
            exit();
        endif;

        if ( isset($this->request->post['parent_id']) AND !empty($this->request->post['parent_id']) ):
            $is_valid_parent_id = $this->model_parent->select('id')->where('id', '=', $this->request->post['parent_id']);

            if ( $is_valid_parent_id->first() !== NULL ):

                // VALIDATION : username
                $is_valid_username = GUMP::is_valid($this->request->post, array('username' => 'required|alpha_numeric|min_len,6|max_len,20'));
                if ( $is_valid_username !== true ):
                    echo json_encode( array("status" => "failed", "message" => "Please select a valid username of minimum 6 characters" ), JSON_PRETTY_PRINT );
                    exit();
                endif;

                // CHECK ANY USER AVAILABLE
                $is_available_user = $this->model_user->select('id')->where('user_type', '=', 'parent')->where('ref_id', '=', $this->request->post['parent_id']);
                if ( $is_available_user->first() != NULL):
                     // IS CHANGED USERNAME
                    $current_username = $this->model_user->select('username')->where('user_type', '=', 'parent')->where('ref_id', '=', $this->request->post['parent_id'])->first();
                    if ( $current_username->username != $this->request->post['username']):
                        // USERNAME IS CHANGED : CHECK FOR DUPLICATE
                        if ( $this->model_user->select('id')->where('username', '=', $this->request->post['username'])->first() != NULL ):
                            echo json_encode( array( "status" => "failed", "message" => "This username already exists" ), JSON_PRETTY_PRINT );
                            exit();
                        endif;
                    endif;
                endif;

                // UPDATE PROCESS
                try {
                    // UPDATE SETTINGS IF AVAILABLE USER FOUND
                    $is_available_user = $this->model_user->select('id')->where('user_type', '=', 'parent')->where('ref_id', '=', $this->request->post['parent_id']);
                    if ( $is_available_user->first() != NULL):

                        // UPDATE STATUS,ROLE,USERNAME
                        $this->model_user->where('user_type', '=', 'parent')->where('ref_id', '=', $this->request->post['parent_id'])->update([
                            'username' => $this->request->post['username']
                        ]);
                    endif;

                    echo json_encode( array("status" => "success"), JSON_PRETTY_PRINT );
                    exit();

                } catch (\Illuminate\Database\QueryException $e) {
                    // var_dump( $e->errorInfo );
                    echo json_encode( array( "status" => "failed", "message" => "Unable to edit username. Please contact your System Administrator" ), JSON_PRETTY_PRINT );
                    exit();
                }
            else:
                // NO RECORD FOUND TO UPDATE
				echo json_encode( array( "status" => "failed", "message" => "No Parent record found to modify" ), JSON_PRETTY_PRINT );
				exit();
			endif;
        else:
            // PARENT ID IS NOT SET
			echo json_encode( array( "status" => "failed", "message" => "Please select a valid Parent record" ), JSON_PRETTY_PRINT );
			exit();
		endif;
    }

    public function ajax_update_parent_password(){

        // CHECK LOGIN STATUS
		if( !isset($_SESSION['user']) OR $_SESSION['user']['is_login'] != true ):
			header( 'Location:' . $this->config->get('base_url') . '/logout' );
			exit();
        endif;

		// SET JSON HEADER
        header('Content-Type: application/json');

        // MODEL
        $this->load->model('parent');
        $this->load->model('user');

        // PERMISSION
        if ( !$this->model_user->find($_SESSION['user']['id'])->hasPermission('portal-parent-edit') ):
            echo json_encode( array( "status" => "failed", "message" => "Permission denied" ), JSON_PRETTY_PRINT );
            exit();
        endif;

        if ( isset($this->request->post['parent_id']) AND !empty($this->request->post['parent_id']) ):
            $is_valid_parent_id = $this->model_parent->select('id')->where('id', '=', $this->request->post['parent_id']);

            if ( $is_valid_parent_id->first() !== NULL ):

                // var_dump($this->request->post['new_password']);
                // exit();

                // VALIDATION : current_password
                $is_valid_current_password = GUMP::is_valid($this->request->post, array('current_password' => 'required|alpha_numeric|min_len,6|max_len,20'));
                if ( $is_valid_current_password !== true ):
                    echo json_encode( array("status" => "failed", "message" => "Please enter your current password of minimum 6 characters without any special characters and spaces except dash(-),underscore(_)" ), JSON_PRETTY_PRINT );
                    exit();
                endif;

                // CHECK ANY USER AVAILABLE
                $is_available_user = $this->model_user->select('id')->where('user_type', '=', 'parent')->where('ref_id', '=', $this->request->post['parent_id']);
                if ( $is_available_user->first() != NULL):
                    // IS CURRENT PASSWORD IS TRUE
                    $current_password = $this->model_user->select('password')->where('user_type', '=', 'parent')->where('ref_id', '=', $this->request->post['parent_id'])->first();
                    if ( password_verify ($this->request->post['current_password'], $current_password->password) == FALSE ):
                        echo json_encode( array( "status" => "failed", "message" => "Your current password is invalid" ), JSON_PRETTY_PRINT );
                        exit();
                    endif;
                endif;

                // VALIDATION : new_password
                $is_valid_new_password = GUMP::is_valid($this->request->post, array('new_password' => 'required|alpha_numeric|min_len,6|max_len,20'));
                if ( $is_valid_new_password !== true ):
                    echo json_encode( array("status" => "failed", "message" => "Please enter your new password of minimum 6 characters without any special characters and spaces except dash(-),underscore(_)" ), JSON_PRETTY_PRINT );
                    exit();
                endif;

                // CHECK : NEW PASSWORD != CURRENT PASSWORD
                if ( $this->request->post['new_password'] == $this->request->post['current_password'] ):
                    echo json_encode( array("status" => "failed", "message" => "Your New Password and Current password cannot be same" ), JSON_PRETTY_PRINT );
                    exit();
                endif;

                // VALIDATION : confirm_new_password
                $is_valid_confirm_new_password = GUMP::is_valid($this->request->post, array('confirm_new_password' => 'required|alpha_numeric|min_len,6|max_len,20'));
                if ( $is_valid_confirm_new_password !== true ):
                    echo json_encode( array("status" => "failed", "message" => "Please retype your valid confirmation password as same as the password" ), JSON_PRETTY_PRINT );
                    exit();
                endif;

                // CHECK : PASSWORD = CONFIRM PASSWORD
                if ( $this->request->post['new_password'] != $this->request->post['confirm_new_password'] ):
                    echo json_encode( array("status" => "failed", "message" => "Password and confirm password doesn't match" ), JSON_PRETTY_PRINT );
                    exit();
                endif;

                // UPDATE PROCESS
                try {
                    // UPDATE SETTINGS IF AVAILABLE USER FOUND
                    $is_available_user = $this->model_user->select('id')->where('user_type', '=', 'parent')->where('ref_id', '=', $this->request->post['parent_id']);
                    if ( $is_available_user->first() != NULL):

                        // UPDATE STATUS,ROLE,USERNAME
                        $this->model_user->where('user_type', '=', 'parent')->where('ref_id', '=', $this->request->post['parent_id'])->update([
                            'password' => password_hash($this->request->post['new_password'], PASSWORD_DEFAULT)
                        ]);
                    endif;

                    echo json_encode( array("status" => "success"), JSON_PRETTY_PRINT );
                    exit();

                } catch (\Illuminate\Database\QueryException $e) {
                    // var_dump( $e->errorInfo );
                    echo json_encode( array( "status" => "failed", "message" => "Unable to update password. Please contact your System Administrator" ), JSON_PRETTY_PRINT );
                    exit();
                }

            else:
                // NO RECORD FOUND TO UPDATE
				echo json_encode( array( "status" => "failed", "message" => "No Parent record found to modify" ), JSON_PRETTY_PRINT );
				exit();
			endif;
        else:
            // PARENT ID IS NOT SET
			echo json_encode( array( "status" => "failed", "message" => "Please select a valid Parent record" ), JSON_PRETTY_PRINT );
			exit();
		endif;
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

        // BACK
        $user = $this->model_user->where('id', '=', $_SESSION['user']['id'])->where('user_type', '=', $_SESSION['user']['type'])->first();
        $data['user']['ref_id'] = $user->ref_id;
        $data['user']['type'] = $_SESSION['user']['type'];

        $date_now = Carbon::now()->isoFormat('YYYY-MM-DD');
        $time_now = Carbon::now();

        if ( $id !== null ):

            // CHECK PERMISSION : single
            if ( $this->model_user->find($_SESSION['user']['id'])->hasPermission('portal-single-view') ):
                $data['permission']['portal']['single']['view'] = true;
            else:
                $data['permission']['portal']['single']['view'] = false;
            endif;

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

            $this->load->view('portal/single', $data);

        else:

            // CHECK PERMISSION : messages
            if ( $this->model_user->find($_SESSION['user']['id'])->hasPermission('portal-messages-view') ):
                $data['permission']['portal']['messages']['view'] = true;
            else:
                $data['permission']['portal']['messages']['view'] = false;
            endif;
            
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

            $this->load->view('portal/messages', $data);
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

        // PERMISSION
        if ( !$this->model_user->find($_SESSION['user']['id'])->hasPermission('portal-messages-create-new') ):
            echo json_encode( array( "status" => "failed", "message" => "Permission denied" ), JSON_PRETTY_PRINT );
            exit();
        endif;

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

        // PERMISSION
        if ( !$this->model_user->find($_SESSION['user']['id'])->hasPermission('portal-messages-conversation-reply') ):
            echo json_encode( array( "status" => "failed", "message" => "Permission denied" ), JSON_PRETTY_PRINT );
            exit();
        endif;

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