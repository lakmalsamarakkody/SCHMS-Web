<?php

use Carbon\Carbon;
use Illuminate\Database\Capsule\Manager as DB;

class Result extends Controller {
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
        $this->load->model('exam/schedule');
        $this->load->model('student/exam');

        // DATE AND TIME
        $date_now = Carbon::now()->isoFormat('YYYY-MM-DD');

        // UPCOMING EXAMS
        foreach ( $this->model_exam_schedule->where('date', '>=', $date_now)->orderBy('date')->get()->take(10) as $key => $element ):
            $exam_data = DB::table('exam_grade_has_schedule')
            ->join('subject', 'exam_grade_has_schedule.subject_id', 'subject.id')
            ->join('exam_has_grade', 'exam_grade_has_schedule.exam_grade_id', 'exam_has_grade.id')
            ->join('exam', 'exam_has_grade.exam_id', 'exam.id')
            ->join('exam_type', 'exam.type_id', 'exam_type.id')
            ->join('grade', 'exam_has_grade.grade_id', 'grade.id')
            ->where('exam_grade_has_schedule.id', '=', $element->id)
            ->select('exam_type.name as exam_name', 'exam.year as exam_year', 'grade.name as grade_name', 'subject.name as subject_name')
            ->first();

            $exam_date = Carbon::parse($element->date, 'GMT');
            $exam_starttime = Carbon::parse($element->start_time, 'GMT');
            $exam_endtime = Carbon::parse($element->end_time, 'GMT');

            $data['exam']['upcoming']['schedules'][$key]['exam']['name'] = $exam_data->exam_name;
            $data['exam']['upcoming']['schedules'][$key]['exam']['year'] = $exam_data->exam_year;
            $data['exam']['upcoming']['schedules'][$key]['exam']['grade'] = $exam_data->grade_name;
            $data['exam']['upcoming']['schedules'][$key]['exam']['subject'] = $exam_data->subject_name;
            $data['exam']['upcoming']['schedules'][$key]['exam']['date'] = $exam_date->isoFormat('MMMM Do dddd');
            $data['exam']['upcoming']['schedules'][$key]['exam']['starttime'] = $exam_starttime->isoFormat('h:mm A');
            $data['exam']['upcoming']['schedules'][$key]['exam']['endtime'] = $exam_endtime->isoFormat('h:mm A');
            $data['exam']['upcoming']['schedules'][$key]['exam']['venue'] = $element->venue;
        endforeach;

        // RECENT EXAMS
        foreach ( $this->model_exam_schedule->where('date', '<', $date_now)->orderBy('date', 'DESC')->get()->take(10) as $key => $element ):
            $exam_data = DB::table('exam_grade_has_schedule')
            ->join('subject', 'exam_grade_has_schedule.subject_id', 'subject.id')
            ->join('exam_has_grade', 'exam_grade_has_schedule.exam_grade_id', 'exam_has_grade.id')
            ->join('exam', 'exam_has_grade.exam_id', 'exam.id')
            ->join('exam_type', 'exam.type_id', 'exam_type.id')
            ->join('grade', 'exam_has_grade.grade_id', 'grade.id')
            ->where('exam_grade_has_schedule.id', '=', $element->id)
            ->select('exam_type.name as exam_name', 'exam.year as exam_year', 'grade.name as grade_name', 'subject.name as subject_name')
            ->first();

            $exam_date = Carbon::parse($element->date, 'GMT');
            $exam_starttime = Carbon::parse($element->start_time, 'GMT');
            $exam_endtime = Carbon::parse($element->end_time, 'GMT');

            $data['exam']['recent']['schedules'][$key]['exam']['name'] = $exam_data->exam_name;
            $data['exam']['recent']['schedules'][$key]['exam']['year'] = $exam_data->exam_year;
            $data['exam']['recent']['schedules'][$key]['exam']['grade'] = $exam_data->grade_name;
            $data['exam']['recent']['schedules'][$key]['exam']['subject'] = $exam_data->subject_name;
            $data['exam']['recent']['schedules'][$key]['exam']['date'] = $exam_date->isoFormat('MMMM Do dddd');
            $data['exam']['recent']['schedules'][$key]['exam']['starttime'] = $exam_starttime->isoFormat('h:mm A');
            $data['exam']['recent']['schedules'][$key]['exam']['endtime'] = $exam_endtime->isoFormat('h:mm A');
        endforeach;

        // RESULT RELEASED EXAMS
        foreach ( $this->model_student_exam->where('marks', '!=', NULL)->groupBy('exam_schedule_id')->orderBy('exam_schedule_id')->get() as $key => $element ):
            $exam_data = DB::table('student_has_exam_schedule')
            ->join('exam_grade_has_schedule', 'student_has_exam_schedule.exam_schedule_id', 'exam_grade_has_schedule.id')
            ->join('subject', 'exam_grade_has_schedule.subject_id', 'subject.id')
            ->join('exam_has_grade', 'exam_grade_has_schedule.exam_grade_id', 'exam_has_grade.id')
            ->join('exam', 'exam_has_grade.exam_id', 'exam.id')
            ->join('exam_type', 'exam.type_id', 'exam_type.id')
            ->join('grade', 'exam_has_grade.grade_id', 'grade.id')
            ->where('student_has_exam_schedule.id', '=', $element->id)
            ->select('exam_type.name as exam_name', 'exam.year as exam_year', 'grade.name as grade_name', 'subject.name as subject_name', 'exam_grade_has_schedule.date as exam_date', 'exam_grade_has_schedule.start_time as start_time', 'exam_grade_has_schedule.end_time as end_time')
            ->first();

            $exam_date = Carbon::parse($exam_data->exam_date, 'GMT');
            $exam_starttime = Carbon::parse($exam_data->start_time, 'GMT');
            $exam_endtime = Carbon::parse($exam_data->end_time, 'GMT');

            $data['exam']['released']['schedules'][$key]['exam']['name'] = $exam_data->exam_name;
            $data['exam']['released']['schedules'][$key]['exam']['year'] = $exam_data->exam_year;
            $data['exam']['released']['schedules'][$key]['exam']['grade'] = $exam_data->grade_name;
            $data['exam']['released']['schedules'][$key]['exam']['subject'] = $exam_data->subject_name;
            $data['exam']['released']['schedules'][$key]['exam']['date'] = $exam_date->isoFormat('MMMM Do dddd');
            $data['exam']['released']['schedules'][$key]['exam']['starttime'] = $exam_starttime->isoFormat('h:mm A');
            $data['exam']['released']['schedules'][$key]['exam']['endtime'] = $exam_endtime->isoFormat('h:mm A');
        endforeach;

		// RENDER VIEW
        $this->load->view('result/index', $data);
        
    }

    public function search() {

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
        $this->load->model('exam');
        $this->load->model('exam/type');
        $this->load->model('exam/grade');
        $this->load->model('exam/schedule');
        $this->load->model('class');
        $this->load->model('grade');
        $this->load->model('subject');
        $this->load->model('student');
        $this->load->model('student/exam');
        $this->load->model('student/class');

        // TWIG : EXAMS
        foreach( $this->model_exam->select('id', 'type_id', 'year', 'venue', 'instructions')->orderBy('year','DESC')->get() as $key => $element ):
			$data['exams'][$key]['id'] = $element->id;
            $data['exams'][$key]['type_id']= $element->type_id;
            $data['exams'][$key]['year'] = $element->year;
            $data['exams'][$key]['venue'] = $element->venue;
            $data['exams'][$key]['instructions'] = $element->instructions;

            $data['exams'][$key]['type']['name'] = $this->model_exam_type->select('name')->where('id', '=', $element->type_id)->first()->name;
        endforeach;

        // TWIG : CLASS
        foreach( $this->model_class->select('id', 'grade_id', 'staff_id', 'name')->get() as $key => $element ):
            $data['classes'][$key]['id'] = $element->id;
            $data['classes'][$key]['grade']['id'] = $element->grade_id;
            $data['classes'][$key]['staff']['id'] = $element->staff_id;
            $data['classes'][$key]['name'] = $element->name;

            $data['classes'][$key]['grade']['name'] = $this->model_grade->select('name')->where('id', '=', $element->grade_id)->first()->name;
        endforeach;

        // TWIG : SUBJECT
        foreach( $this->model_subject->select('id', 'name', 'si_name')->orderBy('name')->get() as $key => $element ):
            $data['subjects'][$key]['id'] = $element->id;
            $data['subjects'][$key]['name'] = $element->name;
            $data['subjects'][$key]['si_name'] = $element->si_name;
        endforeach;

        //TWIG : STUDENT
        foreach( $this->model_student->select('id', 'full_name', 'initials', 'surname')->get() as $key => $element ):
            $data['students'][$key]['id'] = $element->id;
            $data['students'][$key]['full_name']= $element->full_name;
            $data['students'][$key]['initials']= $element->initials;
            $data['students'][$key]['surname'] = $element->surname;
        endforeach;

        if ( isset( $this->request->post['isSubmited']) ):

            // PRESERVE SUBMITED DATA
            $data['form']['field']['exam_name'] = ( isset($this->request->post['exam_name']) AND !empty($this->request->post['exam_name']) ) ? $this->request->post['exam_name'] : "";
            $data['form']['field']['exam_class'] = ( isset($this->request->post['exam_class']) AND !empty($this->request->post['exam_class']) ) ? $this->request->post['exam_class'] : "";
            $data['form']['field']['exam_subject'] = ( isset($this->request->post['exam_subject']) AND !empty($this->request->post['exam_subject']) ) ? $this->request->post['exam_subject'] : "";
            $data['form']['field']['student_addno'] = ( isset($this->request->post['student_addno']) AND !empty($this->request->post['student_addno']) ) ? $this->request->post['student_addno'] : "";
            $data['form']['field']['student_name'] = ( isset($this->request->post['student_name']) AND !empty($this->request->post['student_name']) ) ? $this->request->post['student_name'] : "";

            $student_exam = $this->model_student_exam->select('id')->where('marks', '!=', NULL);

            // FILTER ( EXAM )
            if ( isset($this->request->post['exam_name']) AND !empty($this->request->post['exam_name']) ):

                /**
                 * This is the data we need to apply filter into
                 * the final query.
                 */
                $student_has_exam_schedule_ids = array();

                $exam_grade = $this->model_exam_grade->select('id')->where('exam_id', '=', $this->request->post['exam_name'])->get();
                if ( $exam_grade !== null ):
                    foreach( $exam_grade as $key => $element ):
                        $exam_schedule_ids = $this->model_exam_schedule->select('id')->where('exam_grade_id', '=', $element->id)->get();
                        if ( $exam_schedule_ids !== NULL ):
                            foreach( $exam_schedule_ids as $el ):
                                $student_has_exam_schedule = $this->model_student_exam->select('id')->where('exam_schedule_id', '=', $el->id)->get();
                                if ( $student_has_exam_schedule !== NULL ):
                                    foreach( $student_has_exam_schedule as $e ):
                                        array_push($student_has_exam_schedule_ids, $e->id);
                                    endforeach;
                                endif;
                            endforeach;
                        endif;
                    endforeach;

                    /**
                     * Now we append filtered IDs into main query builder
                     */
                    $student_exam->where(function($query) use ($student_has_exam_schedule_ids) {
                        $query->whereIn('id', $student_has_exam_schedule_ids);
                    });

                endif;
            endif;

            // FILTER ( CLASS )
            if ( isset($this->request->post['exam_class']) AND !empty($this->request->post['exam_class']) ):

                /**
                 * This is the data we need to apply filter into
                 * the final query.
                 */
                $student_has_class_ids = array();

                $student_class = $this->model_student_class->select('student_id')->where("class_id", '=', $this->request->post['exam_class'])->get();
                if ( $student_class !== null ):
                    foreach ( $student_class as $key => $element ):
                        array_push($student_has_class_ids, $element->student_id);
                    endforeach;

                    /**
                     * Now we append filtered IDs into main query builder
                     */
                    $student_exam->where(function($query) use ($student_has_class_ids) {
                        $query->whereIn('student_id', $student_has_class_ids);
                    });
                endif;
            endif;

            // FILTER (SUBJECT)
            if ( isset($this->request->post['exam_subject']) AND !empty($this->request->post['exam_subject']) ):
                /**
                 * This is the data we need to apply filter into
                 * the final query.
                 */
                $exam_schedule_subject_ids = array();

                $exam_schedule = $this->model_exam_schedule->select('id')->where('subject_id','=', $this->request->post['exam_subject'])->get();
                if ( $exam_schedule !== null ):
                    foreach ( $exam_schedule as $key => $element ):
                        array_push($exam_schedule_subject_ids, $element->id);
                    endforeach;

                    /**
                     * Now we append filtered IDs into main query builder
                     */
                    $student_exam->where(function($query) use ($exam_schedule_subject_ids) {
                        $query->whereIn('exam_schedule_id', $exam_schedule_subject_ids);
                    });

                endif;
            endif;

            // FILTER (STUDENT ADMISSION NO)
            if ( isset($this->request->post['student_addno']) AND !empty($this->request->post['student_addno']) ):

                $student_id = $this->model_student->select('id')->where('admission_no', '=', $this->request->post['student_addno'])->first();
                if ( $student_id !== null ):

                    /**
                     * Now we append filtered IDs into main query builder
                     */
                    $student_exam->where(function($query) use ($student_id){
                        $query->where('student_id','=', $student_id->id);
                    });
                else:

                    /**
                     * Now we append filtered IDs into main query builder
                     */
                    $student_exam->where(function($query){
                        $query->where('student_id','=', null);
                    });

                endif;
            endif;

            // FILTER (STUDENT NAME)
            if ( isset($this->request->post['student_name']) AND !empty($this->request->post['student_name']) ):

                $student_id = $this->request->post['student_name'];

                /**
                 * Now we append filtered IDs into main query builder
                 */
                $student_exam->where(function($query) use ($student_id){
                    $query->where('student_id', '=', $student_id);
                });
            endif;

            // RESULT
            foreach( $student_exam->orderBy('student_id')->get() as $key => $element ):
                
                $student_data = DB::table('student_has_exam_schedule')
                    ->join('student', 'student_has_exam_schedule.student_id', '=', 'student.id')
                    ->join('student_has_class', 'student_has_exam_schedule.student_id', '=', 'student_has_class.student_id')
                    ->join('exam_grade_has_schedule', 'student_has_exam_schedule.exam_schedule_id', '=', 'exam_grade_has_schedule.id')
                    ->select('student_has_exam_schedule.id', 'student_has_exam_schedule.student_id', 'student_has_exam_schedule.exam_schedule_id', 'student_has_exam_schedule.marks', 'student.admission_no','student.initials','student.surname', 'student_has_class.class_id', 'student_has_class.index_no', 'exam_grade_has_schedule.subject_id')
                    ->where('student_has_exam_schedule.id', '=', $element->id)->first();

                // CLASS NAME
                $class = $this->model_class->select('name', 'grade_id')->where('id', '=',$student_data->class_id)->first();
                $grade = $this->model_grade->select('name')->where('id', '=',$class->grade_id)->first();
                $class_name = $grade->name." - ".$class->name;

                // EXAM TYPE AND YEAR
                $exam_grade_id = $this->model_exam_schedule->select('exam_grade_id')->where('id', '=', $student_data->exam_schedule_id)->first()->exam_grade_id;
                $exam_id = $this->model_exam_grade->select('exam_id')->where('id', '=', $exam_grade_id)->first()->exam_id;
                $exam = $this->model_exam->select('id', 'type_id', 'year')->where('id', '=', $exam_id)->first();
                $exam_type_name = $this->model_exam_type->select('name')->where('id', '=', $exam->type_id)->first()->name;

                $data['exam']['schedules'][$key]['id'] = $element->id;
                $data['exam']['schedules'][$key]['student_id'] = $student_data->student_id;
                $data['exam']['schedules'][$key]['exam_schedule_id'] = $student_data->exam_schedule_id;
                $data['exam']['schedules'][$key]['marks'] = ($student_data->marks !== null) ? $student_data->marks : "Pending";

                $data['exam']['schedules'][$key]['admission_no'] = $student_data->admission_no;
                $data['exam']['schedules'][$key]['class'] = $class_name;
                $data['exam']['schedules'][$key]['index'] = $student_data->index_no;
                $data['exam']['schedules'][$key]['name'] = $student_data->initials." ".$student_data->surname;
                $data['exam']['schedules'][$key]['exam_name'] = $exam_type_name." - ".$exam->year;
                $data['exam']['schedules'][$key]['subject'] = $this->model_subject->select('name')->where('id', '=', $student_data->subject_id)->first()->name;
            endforeach;

        endif;
        
		// RENDER VIEW
        $this->load->view('result/search', $data);
        
    }

    public function ajax_editresult() {

		//CHECK LOGIN STATUS
		if( !isset($_SESSION['user']) OR $_SESSION['user']['is_login'] != true ):
			header( 'Location:' . $this->config->get('base_url') . '/logout' );
			exit();
		endif;

		// SET JSON HEADER
		header('Content-Type: application/json');

		// MODEL
		$this->load->model('student/exam');

		// VALIDATE RESULT ID
		$is_exist = $this->model_student_exam->select('id')->where('id', '=', $this->request->post['id'])->first();

		if( $is_exist == NULL ):
			echo json_encode( array( "status" => "failed", "message" => "Editing result doesn't exists" ), JSON_PRETTY_PRINT );
			exit();
        endif;
        
        // VALIDATION : marks
        $is_valid_marks = GUMP::is_valid($this->request->post, array('marks' => 'required|numeric|max_len,3'));
        if ( $is_valid_marks !== true ):
            echo json_encode( array( "status" => "failed", "message" => "Please insert a valid result" ), JSON_PRETTY_PRINT );
            exit();
		endif;

		// UPDATE
		try {
			$this->model_student_exam->where('id', '=', $this->request->post['id'])->update(['marks' => $this->request->post['marks']]);
			echo json_encode( array("status" => "success"), JSON_PRETTY_PRINT );
			exit();

		} catch (\Illuminate\Database\QueryException $e) {
			// var_dump( $e->errorInfo );
			echo json_encode( array( "status" => "failed", "message" => "Unable to edit Result. Please contact System Administrator" ), JSON_PRETTY_PRINT );
			exit();
		}
    }
    
    public function ajax_removeresult() {

		//CHECK LOGIN STATUS
		if( !isset($_SESSION['user']) OR $_SESSION['user']['is_login'] != true ):
			header( 'Location:' . $this->config->get('base_url') . '/logout' );
			exit();
		endif;

		// SET JSON HEADER
		header('Content-Type: application/json');

		// MODEL
        $this->load->model('student/exam');
        
        // VALIDATE RESULT ID
		$is_exist = $this->model_student_exam->select('id')->where('id', '=', $this->request->post['id'])->first();

		if( $is_exist == NULL ):
			echo json_encode( array( "status" => "failed", "message" => "Editing result doesn't exists" ), JSON_PRETTY_PRINT );
			exit();
        endif;
		
		// UPDATE
		try {
			$this->model_student_exam->where('id', '=', $this->request->post['id'])->update(['marks' => NULL]);
			echo json_encode( array("status" => "success"), JSON_PRETTY_PRINT );
			exit();

		} catch (\Illuminate\Database\QueryException $e) {
			// var_dump( $e->errorInfo );
			echo json_encode( array( "status" => "failed", "message" => "Unable to Delete Result. Please contact System Administrator" ), JSON_PRETTY_PRINT );
			exit();
		}
	}
    
    public function add() {

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
        $this->load->model('exam');
        $this->load->model('exam/type');
        $this->load->model('exam/grade');
        $this->load->model('exam/schedule');
        $this->load->model('class');
        $this->load->model('grade');
        $this->load->model('subject');
        $this->load->model('student');
        $this->load->model('student/exam');
        $this->load->model('student/class');

        // TWIG : EXAMS
        foreach( $this->model_exam->select('id', 'type_id', 'year', 'venue', 'instructions')->orderBy('year','DESC')->get() as $key => $element ):
			$data['exams'][$key]['id'] = $element->id;
            $data['exams'][$key]['type_id']= $element->type_id;
            $data['exams'][$key]['year'] = $element->year;
            $data['exams'][$key]['venue'] = $element->venue;
            $data['exams'][$key]['instructions'] = $element->instructions;

            $data['exams'][$key]['type']['name'] = $this->model_exam_type->select('name')->where('id', '=', $element->type_id)->first()->name;
        endforeach;

        // TWIG : CLASS
        foreach( $this->model_class->select('id', 'grade_id', 'staff_id', 'name')->get() as $key => $element ):
            $data['classes'][$key]['id'] = $element->id;
            $data['classes'][$key]['grade']['id'] = $element->grade_id;
            $data['classes'][$key]['staff']['id'] = $element->staff_id;
            $data['classes'][$key]['name'] = $element->name;

            $data['classes'][$key]['grade']['name'] = $this->model_grade->select('name')->where('id', '=', $element->grade_id)->first()->name;
        endforeach;

        // TWIG : SUBJECT
        foreach( $this->model_subject->select('id', 'name', 'si_name')->orderBy('name')->get() as $key => $element ):
            $data['subjects'][$key]['id'] = $element->id;
            $data['subjects'][$key]['name'] = $element->name;
            $data['subjects'][$key]['si_name'] = $element->si_name;
        endforeach;

        //TWIG : STUDENT
        foreach( $this->model_student->select('id', 'full_name', 'initials', 'surname')->get() as $key => $element ):
            $data['students'][$key]['id'] = $element->id;
            $data['students'][$key]['full_name']= $element->full_name;
            $data['students'][$key]['initials']= $element->initials;
            $data['students'][$key]['surname'] = $element->surname;
        endforeach;

        if ( isset( $this->request->post['isSubmited']) ):

            // PRESERVE SUBMITED DATA
            $data['form']['field']['exam_name'] = ( isset($this->request->post['exam_name']) AND !empty($this->request->post['exam_name']) ) ? $this->request->post['exam_name'] : "";
            $data['form']['field']['exam_class'] = ( isset($this->request->post['exam_class']) AND !empty($this->request->post['exam_class']) ) ? $this->request->post['exam_class'] : "";
            $data['form']['field']['exam_subject'] = ( isset($this->request->post['exam_subject']) AND !empty($this->request->post['exam_subject']) ) ? $this->request->post['exam_subject'] : "";
            $data['form']['field']['student_addno'] = ( isset($this->request->post['student_addno']) AND !empty($this->request->post['student_addno']) ) ? $this->request->post['student_addno'] : "";
            $data['form']['field']['student_name'] = ( isset($this->request->post['student_name']) AND !empty($this->request->post['student_name']) ) ? $this->request->post['student_name'] : "";

            $student_exam = $this->model_student_exam->select('id')->where('marks', '=', NULL);

            // FILTER ( EXAM )
            if ( isset($this->request->post['exam_name']) AND !empty($this->request->post['exam_name']) ):

                /**
                 * This is the data we need to apply filter into
                 * the final query.
                 */
                $student_has_exam_schedule_ids = array();

                $exam_grade = $this->model_exam_grade->select('id')->where('exam_id', '=', $this->request->post['exam_name'])->get();
                if ( $exam_grade !== null ):
                    foreach( $exam_grade as $key => $element ):
                        $exam_schedule_ids = $this->model_exam_schedule->select('id')->where('exam_grade_id', '=', $element->id)->get();
                        if ( $exam_schedule_ids !== NULL ):
                            foreach( $exam_schedule_ids as $el ):
                                $student_has_exam_schedule = $this->model_student_exam->select('id')->where('exam_schedule_id', '=', $el->id)->get();
                                if ( $student_has_exam_schedule !== NULL ):
                                    foreach( $student_has_exam_schedule as $e ):
                                        array_push($student_has_exam_schedule_ids, $e->id);
                                    endforeach;
                                endif;
                            endforeach;
                        endif;
                    endforeach;

                    /**
                     * Now we append filtered IDs into main query builder
                     */
                    $student_exam->where(function($query) use ($student_has_exam_schedule_ids) {
                        $query->whereIn('id', $student_has_exam_schedule_ids);
                    });

                endif;
            endif;

            // FILTER ( CLASS )
            if ( isset($this->request->post['exam_class']) AND !empty($this->request->post['exam_class']) ):

                /**
                 * This is the data we need to apply filter into
                 * the final query.
                 */
                $student_has_class_ids = array();

                $student_class = $this->model_student_class->select('student_id')->where("class_id", '=', $this->request->post['exam_class'])->get();
                if ( $student_class !== null ):
                    foreach ( $student_class as $key => $element ):
                        array_push($student_has_class_ids, $element->student_id);
                    endforeach;

                    /**
                     * Now we append filtered IDs into main query builder
                     */
                    $student_exam->where(function($query) use ($student_has_class_ids) {
                        $query->whereIn('student_id', $student_has_class_ids);
                    });
                endif;
            endif;

            // FILTER (SUBJECT)
            if ( isset($this->request->post['exam_subject']) AND !empty($this->request->post['exam_subject']) ):
                /**
                 * This is the data we need to apply filter into
                 * the final query.
                 */
                $exam_schedule_subject_ids = array();

                $exam_schedule = $this->model_exam_schedule->select('id')->where('subject_id','=', $this->request->post['exam_subject'])->get();
                if ( $exam_schedule !== null ):
                    foreach ( $exam_schedule as $key => $element ):
                        array_push($exam_schedule_subject_ids, $element->id);
                    endforeach;

                    /**
                     * Now we append filtered IDs into main query builder
                     */
                    $student_exam->where(function($query) use ($exam_schedule_subject_ids) {
                        $query->whereIn('exam_schedule_id', $exam_schedule_subject_ids);
                    });

                endif;
            endif;

            // FILTER (STUDENT ADMISSION NO)
            if ( isset($this->request->post['student_addno']) AND !empty($this->request->post['student_addno']) ):

                $student_id = $this->model_student->select('id')->where('admission_no', '=', $this->request->post['student_addno'])->first();
                if ( $student_id !== null ):

                    /**
                     * Now we append filtered IDs into main query builder
                     */
                    $student_exam->where(function($query) use ($student_id){
                        $query->where('student_id','=', $student_id->id);
                    });
                else:

                    /**
                     * Now we append filtered IDs into main query builder
                     */
                    $student_exam->where(function($query){
                        $query->where('student_id','=', null);
                    });

                endif;
            endif;

            // FILTER (STUDENT NAME)
            if ( isset($this->request->post['student_name']) AND !empty($this->request->post['student_name']) ):

                $student_id = $this->request->post['student_name'];

                /**
                 * Now we append filtered IDs into main query builder
                 */
                $student_exam->where(function($query) use ($student_id){
                    $query->where('student_id', '=', $student_id);
                });
            endif;

            // RESULT
            foreach( $student_exam->orderBy('student_id')->get() as $key => $element ):
                
                $student_data = DB::table('student_has_exam_schedule')
                    ->join('student', 'student_has_exam_schedule.student_id', '=', 'student.id')
                    ->join('student_has_class', 'student_has_exam_schedule.student_id', '=', 'student_has_class.student_id')
                    ->join('exam_grade_has_schedule', 'student_has_exam_schedule.exam_schedule_id', '=', 'exam_grade_has_schedule.id')
                    ->select('student_has_exam_schedule.id', 'student_has_exam_schedule.student_id', 'student_has_exam_schedule.exam_schedule_id', 'student_has_exam_schedule.marks', 'student.admission_no','student.initials','student.surname', 'student_has_class.class_id', 'student_has_class.index_no', 'exam_grade_has_schedule.subject_id')
                    ->where('student_has_exam_schedule.id', '=', $element->id)->first();

                // CLASS NAME
                $class = $this->model_class->select('name', 'grade_id')->where('id', '=',$student_data->class_id)->first();
                $grade = $this->model_grade->select('name')->where('id', '=',$class->grade_id)->first();
                $class_name = $grade->name." - ".$class->name;

                // EXAM TYPE AND YEAR
                $exam_grade_id = $this->model_exam_schedule->select('exam_grade_id')->where('id', '=', $student_data->exam_schedule_id)->first()->exam_grade_id;
                $exam_id = $this->model_exam_grade->select('exam_id')->where('id', '=', $exam_grade_id)->first()->exam_id;
                $exam = $this->model_exam->select('id', 'type_id', 'year')->where('id', '=', $exam_id)->first();
                $exam_type_name = $this->model_exam_type->select('name')->where('id', '=', $exam->type_id)->first()->name;

                $data['exam']['schedules'][$key]['id'] = $element->id;
                $data['exam']['schedules'][$key]['student_id'] = $student_data->student_id;
                $data['exam']['schedules'][$key]['exam_schedule_id'] = $student_data->exam_schedule_id;
                $data['exam']['schedules'][$key]['marks'] = ($student_data->marks !== null) ? $student_data->marks : "Insert";

                $data['exam']['schedules'][$key]['admission_no'] = $student_data->admission_no;
                $data['exam']['schedules'][$key]['class'] = $class_name;
                $data['exam']['schedules'][$key]['index'] = $student_data->index_no;
                $data['exam']['schedules'][$key]['name'] = $student_data->initials." ".$student_data->surname;
                $data['exam']['schedules'][$key]['exam_name'] = $exam_type_name." - ".$exam->year;
                $data['exam']['schedules'][$key]['subject'] = $this->model_subject->select('name')->where('id', '=', $student_data->subject_id)->first()->name;
            endforeach;

        endif;

		// RENDER VIEW
        $this->load->view('result/add', $data); 
    }

    public function ajax_addresult() {
        //CHECK LOGIN STATUS
		if( !isset($_SESSION['user']) OR $_SESSION['user']['is_login'] != true ):
			header( 'Location:' . $this->config->get('base_url') . '/logout' );
			exit();
		endif;

		// SET JSON HEADER
		header('Content-Type: application/json');

		// MODEL
        $this->load->model('student/exam');

        // VALIDATE RESULT ID
		$is_exist = $this->model_student_exam->select('id')->where('id', '=', $this->request->post['id'])->first();

		if( $is_exist == NULL ):
			echo json_encode( array( "status" => "failed", "message" => "Adding result doesn't exists" ), JSON_PRETTY_PRINT );
			exit();
        endif;
        
        // VALIDATION : marks
        $is_valid_marks = GUMP::is_valid($this->request->post, array('marks' => 'required|numeric|max_len,3'));
        if ( $is_valid_marks !== true ):
            echo json_encode( array( "status" => "failed", "message" => "Please insert a valid result" ), JSON_PRETTY_PRINT );
            exit();
		endif;

		// UPDATE
		try {
			$this->model_student_exam->where('id', '=', $this->request->post['id'])->update(['marks' => $this->request->post['marks']]);
			echo json_encode( array("status" => "success"), JSON_PRETTY_PRINT );
			exit();

		} catch (\Illuminate\Database\QueryException $e) {
			// var_dump( $e->errorInfo );
			echo json_encode( array( "status" => "failed", "message" => "Unable to Save Result. Please contact System Administrator" ), JSON_PRETTY_PRINT );
			exit();
		}
    }
    
}
?>