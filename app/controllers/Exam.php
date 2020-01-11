<?php

use Carbon\Carbon;
use Illuminate\Database\Capsule\Manager as DB;

class Exam extends Controller {
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
        $this->load->model('user');

        // CHECK PERMISSION : index
        if ( $this->model_user->find($_SESSION['user']['id'])->hasPermission('exam-index-view') ):
            $data['permission']['exam']['index']['view'] = true;
        else:
            $data['permission']['exam']['index']['view'] = false;
        endif;

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

		// RENDER VIEW
        $this->load->view('exam/index', $data);        
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
        $this->load->model('exam/schedule');
        $this->load->model('exam/grade');
        $this->load->model('grade');
        $this->load->model('subject');

        // CHECK PERMISSION : search
        if ( $this->model_user->find($_SESSION['user']['id'])->hasPermission('exam-search-view') ):
            $data['permission']['exam']['search']['view'] = true;
        else:
            $data['permission']['exam']['search']['view'] = false;
        endif;

        // CHECK PERMISSION : edit_exam
        if ( $this->model_user->find($_SESSION['user']['id'])->hasPermission('exam-search-edit-exam') ):
            $data['permission']['exam']['search']['edit']['exam'] = true;
        else:
            $data['permission']['exam']['search']['edit']['exam'] = false;            
        endif;

        // CHECK PERMISSION : delete_exam
        if ( $this->model_user->find($_SESSION['user']['id'])->hasPermission('exam-search-delete-exam') ):
            $data['permission']['exam']['search']['delete']['exam'] = true;
        else:
            $data['permission']['exam']['search']['delete']['exam'] = false;            
        endif;

        // TWIG : EXAM YEAR
        $exam_year = Carbon::now()->format('Y');
        for ( $i=1; $i<=2; $i++ ):
            $data['years'][$i] = $exam_year;
            $exam_year++;
        endfor;

        // TWIG : EXAM TYPE
        foreach( $this->model_exam_type->select('id', 'name')->orderBy('name')->get() as $key => $element ):
			$data['exam_types'][$key]['id'] = $element->id;
			$data['exam_types'][$key]['name']= $element->name;
        endforeach;

        // TWIG : EXAMS
        foreach( $this->model_exam->select('id', 'type_id', 'year', 'venue', 'instructions')->orderBy('year', 'DESC')->get() as $key => $element ):
			$data['exams'][$key]['id'] = $element->id;
            $data['exams'][$key]['type_id']= $element->type_id;
            $data['exams'][$key]['year'] = $element->year;
            $data['exams'][$key]['venue'] = $element->venue;
            $data['exams'][$key]['instructions'] = $element->instructions;
            $data['exams'][$key]['type']['name'] = $this->model_exam_type->select('name')->where('id', '=', $element->type_id)->first()->name;
        endforeach;

        //GRADE
        foreach( $this->model_grade->select('id', 'name')->orderBy('name')->get() as $key => $element ):
            $data['grades'][$key]['id'] = $element->id;
            $data['grades'][$key]['name'] = $element->name;
        endforeach;

        // TWIG : SUBJECT
		foreach( $this->model_subject->select('id', 'name', 'si_name')->orderBy('name')->get() as $key => $element ):
			$data['subjects'][$key]['id'] = $element->id;
			$data['subjects'][$key]['name']= $element->name;
			$data['subjects'][$key]['si_name']= $element->si_name;
        endforeach;

        if ( isset($this->request->post['isSubmited']) ):

            // PRESERVE SUBMITED DATA
            $data['form']['field']['exam_name'] = ( isset($this->request->post['exam_name']) AND !empty($this->request->post['exam_name']) ) ? $this->request->post['exam_name'] : "";
            $data['form']['field']['exam_grade'] = ( isset($this->request->post['exam_grade']) AND !empty($this->request->post['exam_grade']) ) ? $this->request->post['exam_grade'] : "";
            $data['form']['field']['exam_subject'] = ( isset($this->request->post['exam_subject']) AND !empty($this->request->post['exam_subject']) ) ? $this->request->post['exam_subject'] : "";
            $data['form']['field']['exam_date'] = ( isset($this->request->post['exam_date']) AND !empty($this->request->post['exam_date']) ) ? $this->request->post['exam_date'] : "";
            
            $exam_schedule = $this->model_exam_schedule->select('id', 'exam_grade_id', 'subject_id', 'date', 'start_time', 'end_time', 'venue', 'instructions');

            // FILTER ( EXAM )
            if ( isset($this->request->post['exam_name']) AND !empty($this->request->post['exam_name']) ):
                $exam_grades = $this->model_exam_grade->select('id')->where('exam_id', '=', $this->request->post['exam_name'])->get();
                if ( $exam_grades != NULL ):
                    $exam_schedule_ids = array();
                    foreach ( $exam_grades as $key => $element):
                        $exam_schedule_id = $this->model_exam_schedule->select('id')->where('exam_grade_id', '=', $element->id)->get();
                        if ( $exam_schedule_id != NULL ):
                            foreach ( $exam_schedule_id as $key2 => $element2 ):
                                array_push($exam_schedule_ids, $element2->id);
                            endforeach;
                        endif;
                    endforeach;
                    $exam_schedule->where(function($query) use ($exam_schedule_ids) {
                        $query->whereIn('id', $exam_schedule_ids);
                    });
                endif;
            endif;

            // FILTER ( GRADE )
            if ( isset($this->request->post['exam_grade']) AND !empty($this->request->post['exam_grade']) ):
                $exam_grades = $this->model_exam_grade->select('id')->where('grade_id', '=', $this->request->post['exam_grade'])->get();
                if ( $exam_grades != NULL ):
                    $exam_schedule_ids = array();
                    foreach ( $exam_grades as $key => $element ):
                        $exam_grade_schedule = $this->model_exam_schedule->select('id')->where('exam_grade_id', '=', $element->id)->get();
                        if ( $exam_grade_schedule != NULL ):
                            foreach ( $exam_grade_schedule as $key2 => $element2 ):
                                array_push($exam_schedule_ids, $element2->id);
                            endforeach;
                        endif;
                    endforeach;
                    $exam_schedule->where(function($query) use ($exam_schedule_ids) {
                        $query->whereIn('id', $exam_schedule_ids);
                    });
                endif;
            endif;

            // FILTER ( SUBJECT )
            if ( isset($this->request->post['exam_subject']) AND !empty($this->request->post['exam_subject']) ):
                $exam_schedule->where('subject_id', '=', $this->request->post['exam_subject']);
            endif;

            // FILTER ( DATE )
            if ( isset($this->request->post['exam_date']) AND !empty($this->request->post['exam_date']) ):
                $exam_schedule->where('date', '=', $this->request->post['exam_date']);
            endif;

            foreach( $exam_schedule->get() as $key => $element ):

                $data['exam']['schedules'][$key]['id'] = $element->id;

                    // EXAM GRADE 
                    $exam_grade_id = $this->model_exam_schedule->select('id', 'exam_grade_id')->where('id', '=', $element->id)->first()->exam_grade_id;
                    $exam_grade = $this->model_exam_grade->select('exam_id', 'grade_id')->where('id', '=', $exam_grade_id)->first();
                    $grade_id = $exam_grade->grade_id;
                    $exam_id = $exam_grade->exam_id;
                    $grade_name = $this->model_grade->select('name')->where('id', '=', $grade_id)->first()->name;

                    // EXAM TYPE AND YEAR
                    $exam = $this->model_exam->select('id', 'type_id', 'year')->where('id', '=', $exam_id)->first();
                    $exam_type_name = $this->model_exam_type->select('name')->where('id', '=', $exam->type_id)->first()->name;

                    // SUBJECT NAME
                    $subject_name = $this->model_subject->select('name')->where('id', '=', $element->subject_id)->first()->name;

                    // START AND END TIME
                    $start_time = Carbon::createFromFormat("H:i:s", $element->start_time);
                    $end_time = Carbon::createFromFormat("H:i:s", $element->end_time);

                $data['exam']['schedules'][$key]['exam_type_name'] = $exam_type_name;
                $data['exam']['schedules'][$key]['exam_year'] = $exam->year;
                $data['exam']['schedules'][$key]['grade'] = $grade_name;
                $data['exam']['schedules'][$key]['subject'] = $subject_name;
                $data['exam']['schedules'][$key]['date'] = $element->date;
                $data['exam']['schedules'][$key]['starts'] = $start_time->isoFormat('h:mm A');
                $data['exam']['schedules'][$key]['ends'] = $end_time->isoFormat('h:mm A');
                $data['exam']['schedules'][$key]['venue'] = $element->venue;
                $data['exam']['schedules'][$key]['instructions'] = $element->instructions;

            endforeach;

        endif;

		// RENDER VIEW
        $this->load->view('exam/search', $data);
    }

    public function search_existing_schedule() {

        // MODEL
        $this->load->model('exam');
        $this->load->model('exam/type');
        $this->load->model('exam/schedule');
        $this->load->model('exam/grade');
        $this->load->model('grade');
        $this->load->model('subject');

        $exam_schedule = $this->model_exam_schedule->select('id', 'exam_grade_id', 'subject_id', 'date', 'start_time', 'end_time', 'venue', 'instructions');

            // FILTER ( EXAM )
            if ( isset($this->request->post['exam_name']) AND !empty($this->request->post['exam_name']) ):
                $exam_grades = $this->model_exam_grade->select('id')->where('exam_id', '=', $this->request->post['exam_name'])->get();
                if ( $exam_grades != NULL ):
                    $exam_schedule_ids = array();
                    foreach ( $exam_grades as $key => $element):
                        $exam_schedule_id = $this->model_exam_schedule->select('id')->where('exam_grade_id', '=', $element->id)->get();
                        if ( $exam_schedule_id != NULL ):
                            foreach ( $exam_schedule_id as $key2 => $element2 ):
                                array_push($exam_schedule_ids, $element2->id);
                            endforeach;
                        endif;
                    endforeach;
                    $exam_schedule->where(function($query) use ($exam_schedule_ids) {
                        $query->whereIn('id', $exam_schedule_ids);
                    });
                endif;
            endif;

            // FILTER ( GRADE )
            if ( isset($this->request->post['exam_grade']) AND !empty($this->request->post['exam_grade']) ):
                $exam_grades = $this->model_exam_grade->select('id')->where('grade_id', '=', $this->request->post['exam_grade'])->get();
                if ( $exam_grades != NULL ):
                    $exam_schedule_ids = array();
                    foreach ( $exam_grades as $key => $element ):
                        $exam_grade_schedule = $this->model_exam_schedule->select('id')->where('exam_grade_id', '=', $element->id)->get();
                        if ( $exam_grade_schedule != NULL ):
                            foreach ( $exam_grade_schedule as $key2 => $element2 ):
                                array_push($exam_schedule_ids, $element2->id);
                            endforeach;
                        endif;
                    endforeach;
                    $exam_schedule->where(function($query) use ($exam_schedule_ids) {
                        $query->whereIn('id', $exam_schedule_ids);
                    });
                endif;
            endif;

            foreach( $exam_schedule->get() as $key => $element ):

                $data['exam']['schedules'][$key]['id'] = $element->id;

                    // EXAM GRADE 
                    $exam_grade_id = $this->model_exam_schedule->select('id', 'exam_grade_id')->where('id', '=', $element->id)->first()->exam_grade_id;
                    $exam_grade = $this->model_exam_grade->select('exam_id', 'grade_id')->where('id', '=', $exam_grade_id)->first();
                    $grade_id = $exam_grade->grade_id;
                    $exam_id = $exam_grade->exam_id;
                    $grade_name = $this->model_grade->select('name')->where('id', '=', $grade_id)->first()->name;

                    // EXAM TYPE AND YEAR
                    $exam = $this->model_exam->select('id', 'type_id', 'year')->where('id', '=', $exam_id)->first();
                    $exam_type_name = $this->model_exam_type->select('name')->where('id', '=', $exam->type_id)->first()->name;

                    // SUBJECT NAME
                    $subject_name = $this->model_subject->select('name')->where('id', '=', $element->subject_id)->first()->name;

                    // START AND END TIME
                    $start_time = Carbon::createFromFormat("H:i:s", $element->start_time);
                    $end_time = Carbon::createFromFormat("H:i:s", $element->end_time);

                $data['exam']['schedules'][$key]['exam_type_name'] = $exam_type_name;
                $data['exam']['schedules'][$key]['exam_year'] = $exam->year;
                $data['exam']['schedules'][$key]['grade'] = $grade_name;
                $data['exam']['schedules'][$key]['subject'] = $subject_name;
                $data['exam']['schedules'][$key]['date'] = $element->date;
                $data['exam']['schedules'][$key]['starts'] = $start_time->isoFormat('h:mm A');
                $data['exam']['schedules'][$key]['ends'] = $end_time->isoFormat('h:mm A');
                $data['exam']['schedules'][$key]['venue'] = $element->venue;
                $data['exam']['schedules'][$key]['instructions'] = $element->instructions;

            endforeach;

            var_dump( $data['exam']['schedules'] );
    }

    public function ajax_remove_exam() {

        //CHECK LOGIN STATUS
		if( !isset($_SESSION['user']) OR $_SESSION['user']['is_login'] != true ):
			header( 'Location:' . $this->config->get('base_url') . '/logout' );
			exit();
		endif;

        /** This ajax request will
         * remove selected exam 
         * by exam_id 
         */    

        // MODEL
        $this->load->model('exam');
        $this->load->model('user');

        // SET JSON HEADER
        header('Content-Type: application/json');

        // PERMISSION
        if ( !$this->model_user->find($_SESSION['user']['id'])->hasPermission('exam-search-delete-exam') ):
            echo json_encode( array( "status" => "failed", "message" => "Permission denied" ), JSON_PRETTY_PRINT );
            exit();
        endif;

        $is_present_exam_id = $this->model_exam->select('id')->where('id', '=', $this->request->post['exam_id'])->first();
        if ($is_present_exam_id != NULL ):

            $non_removable_exam_id = DB::table('exam')
            ->join('exam_has_grade', 'exam.id', 'exam_has_grade.exam_id')
            ->join('exam_grade_has_schedule', 'exam_has_grade.id', 'exam_grade_has_schedule.exam_grade_id')
            ->where('exam.id', '=', $this->request->post['exam_id'])
            ->select('exam.id')
            ->first();

            if ( $non_removable_exam_id == NULL ):
                $this->model_exam->destroy($is_present_exam_id->id);
                echo json_encode( array( "status" => "success" ), JSON_PRETTY_PRINT );
                exit();
            else: 
                echo json_encode( array( "status" => "failed", "message" => "Cannot delete the exam type. This exam type has exam schedules" ), JSON_PRETTY_PRINT );
                exit();
            endif;


        else:
            echo json_encode( array( "status" => "failed", "message" => "Cannot delete the exam type. Please contact your system administrator" ), JSON_PRETTY_PRINT );
        endif;

    }

    public function create() {

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
        $this->load->model('grade');
        $this->load->model('subject');

        // CHECK PERMISSION : create
        if ( $this->model_user->find($_SESSION['user']['id'])->hasPermission('exam-create-view') ):
            $data['permission']['exam']['create']['view'] = true;
        else:
            $data['permission']['exam']['create']['view'] = false;
        endif;

        // CHECK PERMISSION : edit exam_type
        if ( $this->model_user->find($_SESSION['user']['id'])->hasPermission('exam-create-edit-exam_type') ):
            $data['permission']['exam']['create']['edit']['exam_type'] = true;
        else:
            $data['permission']['exam']['create']['edit']['exam_type'] = false;
        endif;

        // CHECK PERMISSION : add exam_type
        if ( $this->model_user->find($_SESSION['user']['id'])->hasPermission('exam-create-add-exam_type') ):
            $data['permission']['exam']['create']['add']['exam_type'] = true;
        else:
            $data['permission']['exam']['create']['add']['exam_type'] = false;
        endif;

        // CHECK PERMISSION : edit exam
        if ( $this->model_user->find($_SESSION['user']['id'])->hasPermission('exam-search-edit-exam') ):
            $data['permission']['exam']['search']['edit']['exam'] = true;
        else:
            $data['permission']['exam']['search']['edit']['exam'] = false;
        endif;

        // TWIG : EXAM TYPE
        foreach( $this->model_exam_type->select('id', 'name')->orderBy('name')->get() as $key => $element ):
			$data['exam_types'][$key]['id'] = $element->id;
			$data['exam_types'][$key]['name']= $element->name;
        endforeach;
        
        // TWIG : EXAM YEAR
        $current_year = Carbon::now()->format('Y');
        $exam_year = Carbon::now()->format('Y');
        for ( $i=1; $i<=2; $i++ ):
            $data['years'][$i] = $exam_year;
            $exam_year++;
        endfor;

        // TWIG : EXAMS
        foreach( $this->model_exam->select('id', 'type_id', 'year', 'venue', 'instructions')->where('year', '>=', $current_year)->orderBy('year', 'DESC')->get() as $key => $element ):
			$data['exams'][$key]['id'] = $element->id;
            $data['exams'][$key]['type_id']= $element->type_id;
            $data['exams'][$key]['year'] = $element->year;
            $data['exams'][$key]['venue'] = $element->venue;
            $data['exams'][$key]['instructions'] = $element->instructions;

            $data['exams'][$key]['type']['name'] = $this->model_exam_type->select('name')->where('id', '=', $element->type_id)->first()->name;
        endforeach;

        // TWIG : GRADE
		foreach( $this->model_grade->select('id', 'name')->orderBy('name')->get() as $key => $element ):
			$data['grades'][$key]['id'] = $element->id;
			$data['grades'][$key]['name']= $element->name;
		endforeach;

		// TWIG : SUBJECT
		foreach( $this->model_subject->select('id', 'name', 'si_name')->orderBy('name')->get() as $key => $element ):
			$data['subjects'][$key]['id'] = $element->id;
			$data['subjects'][$key]['name']= $element->name;
			$data['subjects'][$key]['si_name']= $element->si_name;
        endforeach;
        
        //  TWIG : SELECT EXAM DATE
        $data['exam_min_date'] = Carbon::now()->format('Y-m-d');
        $data['exam_max_date'] = Carbon::now()->addYears(1)->format('Y-m-d');

        if ( isset($this->request->post['search_schedules']) ):

            // MODEL
            $this->load->model('exam');
            $this->load->model('exam/type');
            $this->load->model('exam/schedule');
            $this->load->model('exam/grade');
            $this->load->model('grade');
            $this->load->model('subject');

            $exam_schedule = $this->model_exam_schedule->select('id', 'exam_grade_id', 'subject_id', 'date', 'start_time', 'end_time', 'venue', 'instructions');

            // FILTER ( EXAM )
            if ( isset($this->request->post['exam_name']) AND !empty($this->request->post['exam_name']) ):
                $exam_grades = $this->model_exam_grade->select('id')->where('exam_id', '=', $this->request->post['exam_name'])->get();
                if ( $exam_grades != NULL ):
                    $exam_schedule_ids = array();
                    foreach ( $exam_grades as $key => $element):
                        $exam_schedule_id = $this->model_exam_schedule->select('id')->where('exam_grade_id', '=', $element->id)->get();
                        if ( $exam_schedule_id != NULL ):
                            foreach ( $exam_schedule_id as $key2 => $element2 ):
                                array_push($exam_schedule_ids, $element2->id);
                            endforeach;
                        endif;
                    endforeach;
                    $exam_schedule->where(function($query) use ($exam_schedule_ids) {
                        $query->whereIn('id', $exam_schedule_ids);
                    });
                endif;
            endif;

            // FILTER ( GRADE )
            if ( isset($this->request->post['exam_grade']) AND !empty($this->request->post['exam_grade']) ):
                $exam_grades = $this->model_exam_grade->select('id')->where('grade_id', '=', $this->request->post['exam_grade'])->get();
                if ( $exam_grades != NULL ):
                    $exam_schedule_ids = array();
                    foreach ( $exam_grades as $key => $element ):
                        $exam_grade_schedule = $this->model_exam_schedule->select('id')->where('exam_grade_id', '=', $element->id)->get();
                        if ( $exam_grade_schedule != NULL ):
                            foreach ( $exam_grade_schedule as $key2 => $element2 ):
                                array_push($exam_schedule_ids, $element2->id);
                            endforeach;
                        endif;
                    endforeach;
                    $exam_schedule->where(function($query) use ($exam_schedule_ids) {
                        $query->whereIn('id', $exam_schedule_ids);
                    });
                endif;
            endif;

            foreach( $exam_schedule->get() as $key => $element ):

                $data['exam']['schedules'][$key]['id'] = $element->id;

                    // EXAM GRADE 
                    $exam_grade_id = $this->model_exam_schedule->select('id', 'exam_grade_id')->where('id', '=', $element->id)->first()->exam_grade_id;
                    $exam_grade = $this->model_exam_grade->select('exam_id', 'grade_id')->where('id', '=', $exam_grade_id)->first();
                    $grade_id = $exam_grade->grade_id;
                    $exam_id = $exam_grade->exam_id;
                    $grade_name = $this->model_grade->select('name')->where('id', '=', $grade_id)->first()->name;

                    // EXAM TYPE AND YEAR
                    $exam = $this->model_exam->select('id', 'type_id', 'year')->where('id', '=', $exam_id)->first();
                    $exam_type_name = $this->model_exam_type->select('name')->where('id', '=', $exam->type_id)->first()->name;

                    // SUBJECT NAME
                    $subject_name = $this->model_subject->select('name')->where('id', '=', $element->subject_id)->first()->name;

                    // START AND END TIME
                    $start_time = Carbon::createFromFormat("H:i:s", $element->start_time);
                    $end_time = Carbon::createFromFormat("H:i:s", $element->end_time);

                $data['exam']['schedules'][$key]['exam_type_name'] = $exam_type_name;
                $data['exam']['schedules'][$key]['exam_year'] = $exam->year;
                $data['exam']['schedules'][$key]['grade'] = $grade_name;
                $data['exam']['schedules'][$key]['subject'] = $subject_name;
                $data['exam']['schedules'][$key]['date'] = $element->date;
                $data['exam']['schedules'][$key]['starts'] = $start_time->isoFormat('h:mm A');
                $data['exam']['schedules'][$key]['ends'] = $end_time->isoFormat('h:mm A');
                $data['exam']['schedules'][$key]['venue'] = $element->venue;
                $data['exam']['schedules'][$key]['instructions'] = $element->instructions;

            endforeach;

            $data['exam_triggered']['status'] = true;

        endif;

		// RENDER VIEW
        $this->load->view('exam/create', $data);
    }

     // METHOD TO EDIT EXAM TYPES
    public function ajax_edit_exam_type() {

        //CHECK LOGIN STATUS
		if( !isset($_SESSION['user']) OR $_SESSION['user']['is_login'] != true ):
			header( 'Location:' . $this->config->get('base_url') . '/logout' );
			exit();
		endif;

        // SET JSON HEADER
        header('Content-Type: application/json'); 

        // MODEL
        $this->load->model('exam/type');
        $this->model('user');

        // PERMISSION
        if ( !$this->model_user->find($_SESSION['user']['id'])->hasPermission('exam-create-edit-exam_type') ):
            echo json_encode( array( "status" => "failed", "message" => "Permission denied" ), JSON_PRETTY_PRINT );
            exit();
        endif;

        // UPDATE
        if ( $this->model_exam_type->where('id', '=', $this->request->post['id'])->update(['name' => $this->request->post['name']]) ):
            echo json_encode( array( "status" => "success"), JSON_PRETTY_PRINT );
            exit();
        else:
            echo json_encode( array( "status" => "failed", "message" => "Unable to edit exam type" ), JSON_PRETTY_PRINT );
            exit();
        endif;

    }

    // METHOD TO REMOVE EXAM TYPES
    public function ajax_remove_exam_type() {

        //CHECK LOGIN STATUS
		if( !isset($_SESSION['user']) OR $_SESSION['user']['is_login'] != true ):
			header( 'Location:' . $this->config->get('base_url') . '/logout' );
			exit();
		endif;

        // SET JSON HEADER
        header('Content-Type: application/json'); 

        // MODEL
        $this->load->model('exam');
        $this->load->model('exam/type');
        $this->load->model('user');

        // PERMISSION
        if ( !$this->model_user->find($_SESSION['user']['id'])->hasPermission('exam-create-delete-exam_type') ):
            echo json_encode( array( "status" => "failed", "message" => "Permission denied" ), JSON_PRETTY_PRINT );
            exit();
        endif;

        /**
         * check if the exam type ID is correct and
         * this exam_type has no exams associated with it.
         */

        if ( isset($this->request->post['type_id']) AND !empty($this->request->post['type_id'])):
            if ( $this->model_exam->select('id')->where('type_id', '=', $this->request->post['type_id'])->first() == NULL ):
                if ( $this->model_exam_type->find($this->request->post['type_id'])->delete() ):
                    echo json_encode( array( "status" => "success"), JSON_PRETTY_PRINT );
                    exit();
                else:
                    echo json_encode( array( "status" => "failed", "message" => "Cannot delete this exam type. Please contact your system administrator" ), JSON_PRETTY_PRINT );
                    exit();
                endif;
            else:
                echo json_encode( array( "status" => "failed", "message" => "This exam type already has exams" ), JSON_PRETTY_PRINT );
                exit();
            endif;
        else:
            echo json_encode( array( "status" => "failed", "message" => "Cannot delete the exam type. Please contact your system administrator" ), JSON_PRETTY_PRINT );
            exit();
        endif;
    }

    public function ajax_create_exam() {

        //CHECK LOGIN STATUS
		if( !isset($_SESSION['user']) OR $_SESSION['user']['is_login'] != true ):
			header( 'Location:' . $this->config->get('base_url') . '/logout' );
			exit();
		endif;

        /**
         * This method will receive ajax request from
         * the front end with the payload
         * 
         *	exam_year
         *  exam_type_id
         *  exam_venue
         *  exam_instructions
         * 
         * We need to validate the data and then perform
         * the following tasks.
         *    - validate
         *    - CRUD
         *    - response ( JSON )
         */

        // MODEL
        $this->load->model('exam');
        $this->load->model('user');

        // SET JSON HEADER
        header('Content-Type: application/json');

        // PERMISSION
        if ( !$this->model_user->find($_SESSION['user']['id'])->hasPermission('exam-create-view') ):
            echo json_encode( array( "status" => "failed", "error" => "Permission denied" ), JSON_PRETTY_PRINT );
            exit();
        endif;

        // VALIDATION : exam_year
        $is_valid_exam_year = GUMP::is_valid($this->request->post, array('exam_year' => 'required|numeric|exact_len,4'));
        if ( $is_valid_exam_year !== true ):
            echo json_encode( array( "status" => "failed", "error" => "Please select a exam year" ), JSON_PRETTY_PRINT );
            exit();
        endif;

        // VALIDATION : exam_type
        $is_valid_exam_type = GUMP::is_valid($this->request->post, array('exam_type' => 'required|numeric|max_len,2'));
        if ( $is_valid_exam_type !== true ):
            echo json_encode( array( "status" => "failed", "error" => "Please select a exam type" ), JSON_PRETTY_PRINT );
            exit();
        endif;

            // VALIDATE EXAM_TYPE AND YEAR
            $is_exist = $this->model_exam->select('id')->where('type_id', '=', $this->request->post['exam_type'])->where('year', '=', $this->request->post['exam_year'])->first() != NULL;

            if( $is_exist != false ):
                echo json_encode( array( "status" => "failed", "error" => "This Exam is already exist" ), JSON_PRETTY_PRINT );
                exit();
            endif;

        // VALIDATION : exam_venue
        $is_valid_exam_venue = GUMP::is_valid($this->request->post, array('exam_venue' => 'alpha_space|max_len,50'));
        if ( $is_valid_exam_venue !== true ):
            echo json_encode( array( "status" => "failed", "error" => $is_valid_exam_venue[0] ), JSON_PRETTY_PRINT );
            exit();
        endif;

        // VALIDATION : exam_instructions
        $is_valid_exam_instructions = GUMP::is_valid($this->request->post, array('exam_instructions' => 'alpha_space|max_len,200'));
        if ( $is_valid_exam_instructions !== true ):
            echo json_encode( array( "status" => "failed", "error" => $is_valid_exam_instructions[0] ), JSON_PRETTY_PRINT );
            exit();
        endif;

        $this->model_exam->type_id = $this->request->post['exam_type'];
        $this->model_exam->year = $this->request->post['exam_year'];
        $this->model_exam->venue = ( $this->request->post['exam_venue'] == "" )  ? null : $this->request->post['exam_venue'];
        $this->model_exam->instructions = ( $this->request->post['exam_instructions'] == "" )  ? null : $this->request->post['exam_instructions'];

        // SUBMIT
		if ( $this->model_exam->save() ):
			echo json_encode( array( "status" => "success" ), JSON_PRETTY_PRINT );
		else:
			echo json_encode( array( "status" => "failed", "error" => "Exam creation failed. Please try again." ), JSON_PRETTY_PRINT );
		endif;
    }

    public function ajax_edit_exam() {

        //CHECK LOGIN STATUS
		if( !isset($_SESSION['user']) OR $_SESSION['user']['is_login'] != true ):
			header( 'Location:' . $this->config->get('base_url') . '/logout' );
			exit();
		endif;

        /**
         * This method will receive ajax request from
         * the front end with the payload
         * 
         *	exam_year
         *  exam_type_id
         *  exam_venue
         *  exam_instructions
         * 
         * We need to validate the data and then perform
         * the following tasks.
         *    - validate
         *    - CRUD
         *    - response ( JSON )
         */

        // MODEL
        $this->load->model('exam');
        $this->load->model('user');

        // SET JSON HEADER
        header('Content-Type: application/json');

        // PERMISSION
        if ( !$this->model_user->find($_SESSION['user']['id'])->hasPermission('exam-search-edit-exam') ):
            echo json_encode( array( "status" => "failed", "error" => "Permission denied" ), JSON_PRETTY_PRINT );
            exit();
        endif;

        // VALIDATION : year
        $is_valid_year = GUMP::is_valid($this->request->post, array('year' => 'required|numeric|exact_len,4'));
        if ( $is_valid_year !== true ):
            echo json_encode( array( "status" => "failed", "error" => "Please select a exam year" ), JSON_PRETTY_PRINT );
            exit();
        endif;

        // VALIDATION : type
        $is_valid_type = GUMP::is_valid($this->request->post, array('type_id' => 'required|numeric|max_len,2'));
        if ( $is_valid_type !== true ):
            echo json_encode( array( "status" => "failed", "error" => "Please select a exam type" ), JSON_PRETTY_PRINT );
            exit();
        endif;

        // IS CHANGED
        $is_changed = $this->model_exam->where('id', '=', $this->request->post['id'])->first();
        if ( $is_changed->type_id != $this->request->post['type_id'] OR $is_changed->year != $this->request->post['year'] ):
            // VALIDATE TYPE AND YEAR
            $is_exist = $this->model_exam->where('type_id', '=', $this->request->post['type_id'])->where('year', '=', $this->request->post['year'])->first();

            if( $is_exist != NULL ):
                echo json_encode( array( "status" => "failed", "error" => "This Exam is already exist" ), JSON_PRETTY_PRINT );
                exit();
            endif;
        endif;

        // VALIDATION : venue
        $is_valid_venue = GUMP::is_valid($this->request->post, array('venue' => 'alpha_space|max_len,50'));
        if ( $is_valid_venue !== true ):
            echo json_encode( array( "status" => "failed", "error" => $is_valid_venue[0] ), JSON_PRETTY_PRINT );
            exit();
        endif;

        // VALIDATION : instructions
        $is_valid_instructions = GUMP::is_valid($this->request->post, array('instructions' => 'alpha_space|max_len,200'));
        if ( $is_valid_instructions !== true ):
            echo json_encode( array( "status" => "failed", "error" => $is_valid_instructions[0] ), JSON_PRETTY_PRINT );
            exit();
        endif;

        try {
			$this->model_exam->where('id', '=', $this->request->post['id'])->update([
				'year' => $this->request->post['year'],
                'type_id' => $this->request->post['type_id'],
                'venue' => $this->request->post['venue'],
                'instructions' => $this->request->post['instructions']
			]);
			echo json_encode( array("status" => "success"), JSON_PRETTY_PRINT );
			exit();

		} catch (\Illuminate\Database\QueryException $e) {
			// var_dump( $e->errorInfo );
			echo json_encode( array( "status" => "failed", "message" => "Unable to edit exam details. Please verify that details are not duplicating" ), JSON_PRETTY_PRINT );
			exit();
		}
    }

    public function ajax_add_schedule() {

        //CHECK LOGIN STATUS
		if( !isset($_SESSION['user']) OR $_SESSION['user']['is_login'] != true ):
			header( 'Location:' . $this->config->get('base_url') . '/logout' );
			exit();
		endif;

        /**
         * This method will receive ajax request from
         * the front end with the payload
         * 
         *	exam
         *  exam_grade
         *  exam_subject_name
         *  exam_date
         *  exam_starttime
         *  exam_endtime
         *  exam_instructions
         * 
         * We need to validate the data and then perform
         * the following tasks.
         *    - validate
         *    - CRUD
         *    - response ( JSON )
         */

        // MODEL
        $this->load->model('class');
        $this->load->model('exam/schedule');
        $this->load->model('exam/grade');
        $this->load->model('student/exam');
        $this->load->model('student/class');
        $this->load->model('notification');
        $this->load->model('user');


        // SET JSON HEADER
        header('Content-Type: application/json');

        // PERMISSION
        if ( !$this->model_user->find($_SESSION['user']['id'])->hasPermission('exam-create-add-schedule') ):
            echo json_encode( array(  "error" => "Permission denied" ), JSON_PRETTY_PRINT );
            exit();
        endif;

        // VALIDATION : select_exam
        $is_valid_select_exam = GUMP::is_valid($this->request->post, array('select_exam_name' => 'required|numeric|max_len,4'));
        if ( $is_valid_select_exam !== true ):
            echo json_encode( array( "error" => "Please select a exam" ), JSON_PRETTY_PRINT );
            exit();
        endif;

        // VALIDATION : exam_grade
        $is_valid_exam_grade = GUMP::is_valid($this->request->post, array('exam_grade' => 'required|numeric|max_len,2'));
        if ( $is_valid_exam_grade !== true ):
            echo json_encode( array( "error" => "Please select a grade" ), JSON_PRETTY_PRINT );
            exit();
        endif;

            // CHECK GRADE HAS CLASSES
            if ( $this->model_class->select('id')->where('grade_id', '=', $this->request->post['exam_grade'])->first() == NULL ):
                echo json_encode( array( "error" => "This grade has no classes" ), JSON_PRETTY_PRINT );
                exit();
            endif;

            // CHECK CLASSES HAVE STUDENTS
            foreach ( $this->model_class->select('id')->where('grade_id', '=', $this->request->post['exam_grade'])->get() as $key => $element):
                if ( $this->model_student_class->select('id')->where('class_id', '=', $element->id)->first() == NULL ):
                    echo json_encode( array( "error" => "This grade has classes with no students" ), JSON_PRETTY_PRINT );
                    exit();
                endif;
            endforeach;

        // VALIDATION : exam_subject_name
        $is_valid_exam_subject_name = GUMP::is_valid($this->request->post, array('exam_subject_name' => 'required|numeric|max_len,3'));
        if ( $is_valid_exam_subject_name !== true ):
            echo json_encode( array( "error" => "Please select a subject" ), JSON_PRETTY_PRINT );
            exit();
        endif;

        // CHECK EXAM_GRADE AND SUBJECT IS EXIST
        $exam_grade = $this->model_exam_grade->select('id')->where('exam_id', '=', $this->request->post['select_exam_name'])->where('grade_id', '=', $this->request->post['exam_grade'])->first();
        if ( $exam_grade != NULL ):

            // we have exam schedule
            if ( $this->model_exam_schedule->select('id')->where('exam_grade_id', '=', $exam_grade->id)->where('subject_id', '=', $this->request->post['exam_subject_name'])->first() != null ):
                echo json_encode( array( "error" => "This Subject schedule already exists" ), JSON_PRETTY_PRINT );
                exit();
            endif;

        endif;

        // VALIDATION : exam_date
        $is_valid_exam_date = GUMP::is_valid($this->request->post, array('exam_date' => 'required|date'));
        if ( $is_valid_exam_date !== true ):
            echo json_encode( array( "error" => "Please set a exam subject date" ), JSON_PRETTY_PRINT );
            exit();
        endif;

        // VALIDATION : exam_starttime
        $is_valid_exam_starttime = GUMP::is_valid($this->request->post, array('exam_starttime' => 'required'));
        if ( $is_valid_exam_starttime !== true ):
            echo json_encode( array( "error" => "Please set exam subject start time" ), JSON_PRETTY_PRINT );
            exit();
        endif;

        // VALIDATION : exam_endtime
        $is_valid_exam_endtime = GUMP::is_valid($this->request->post, array('exam_endtime' => 'required'));
        if ( $is_valid_exam_endtime !== true ):
            echo json_encode( array( "error" => "Please set exam subject end time" ), JSON_PRETTY_PRINT );
            exit();
        endif;

        // VALIDATION : subject_exam_venue
        $is_valid_subject_exam_venue = GUMP::is_valid($this->request->post, array('subject_exam_venue' => 'alpha_space|max_len,50'));
        if ( $is_valid_subject_exam_venue !== true ):
            echo json_encode( array( "error" => "Please insert a valid exam venue" ), JSON_PRETTY_PRINT );
            exit();
        endif;

        // VALIDATION : subject_exam_instructions
        $is_valid_subject_exam_instructions = GUMP::is_valid($this->request->post, array('subject_exam_instructions' => 'alpha_space|max_len,200'));
        if ( $is_valid_subject_exam_instructions !== true ):
            echo json_encode( array( "error" => "Please insert valid instructions" ), JSON_PRETTY_PRINT );
            exit();
        endif;

        // VALIDATE : TIME COMPARISION
        if ( $this->request->post['exam_starttime'] >= $this->request->post['exam_endtime'] ):
            echo json_encode( array( "error" => "Please insert a valid exam time" ), JSON_PRETTY_PRINT );
            exit();
        endif;

        // SUBMIT IF EXAM AND GRADE NOT AVAILABLE
        $is_exist = $this->model_exam_grade->select('id')->where('exam_id', '=', $this->request->post['select_exam_name'])->where('grade_id', '=', $this->request->post['exam_grade'])->first();

        if ( $is_exist != NULL ):
            
            // we have to get ID according to the values we supply.
            $this->model_exam_grade->id = $this->model_exam_grade->select('id')->where('exam_id', '=', $this->request->post['select_exam_name'])->where('grade_id', '=', $this->request->post['exam_grade'])->first()->id;
        
            // TIME SLOT VALIDATION
            foreach( $this->model_exam_grade->select('id')->where('grade_id', '=' ,$this->request->post['exam_grade'])->get() as $key => $element ):

                $is_valid_time = $this->model_exam_schedule->select('id')->where('exam_grade_id', '=', $element->id)->whereDate('date', '=', $this->request->post['exam_date']);

                // WHERE (exam_grade_id) AND (exam_grade) AND ( (1) OR (2) OR (3) )
                $is_valid_time->where(function ($query) {

                    // 1
                    $query->orWhere(function ($query) {
                        $query->whereTime('start_time', '<=', $this->request->post['exam_starttime']);
                        $query->whereTime('end_time', '>=', $this->request->post['exam_starttime']);
                    });

                    // 2
                    $query->orWhere(function ($query) {
                        $query->whereTime('start_time', '<=', $this->request->post['exam_endtime']);
                        $query->whereTime('end_time', '>=', $this->request->post['exam_endtime']);
                    });

                    // 3
                    $query->orWhere(function ($query) {
                        $query->whereTime('start_time', '>=', $this->request->post['exam_starttime']);
                        $query->whereTime('end_time', '<=', $this->request->post['exam_endtime']);
                    });

                });                

                
                if ( $is_valid_time->first() != NULL ):
                    echo json_encode( array( "error" => "This time schedule is already occupied" ), JSON_PRETTY_PRINT );
                    exit();
                endif;

            endforeach;

            // insert schedule without creating a exam_grade
            $this->model_exam_schedule->exam_grade_id = $this->model_exam_grade->id;
            $this->model_exam_schedule->subject_id = $this->request->post['exam_subject_name'];
            $this->model_exam_schedule->date = $this->request->post['exam_date'];
            $this->model_exam_schedule->start_time = $this->request->post['exam_starttime'];
            $this->model_exam_schedule->end_time = $this->request->post['exam_endtime'];
            $this->model_exam_schedule->venue = ( $this->request->post['subject_exam_venue']  == "" )  ? null : $this->request->post['subject_exam_venue'];
            $this->model_exam_schedule->instructions = ( $this->request->post['subject_exam_instructions'] == "" )  ? null : $this->request->post['subject_exam_instructions'];

            // SUBMIT
            if ( $this->model_exam_schedule->save() ):
                
                // SELECT ALL CLASSES IN A GRADE
                foreach ( $this->model_class->select('id')->where('grade_id', '=', $this->request->post['exam_grade'])->get() as $key => $element ):
                    
                    // CHECK ONE OR MORE STUDENT IN A CLASS EXIST
                    if( $this->model_student_class->select('student_id')->where('class_id', '=', $element->id)->first() != NULL ):
                        
                        // SELECT ALL STUDENTS IN A CLASS
                        foreach ( $this->model_student_class->select('student_id')->where('class_id', '=', $element->id)->get() as $key2 => $element2 ):

                            try {
                                // CREATE STUDENT HAS EXAM SCHEDULE RECORD
                                $this->model_student_exam->create([
                                    'student_id'        => $element2->student_id,
                                    'exam_schedule_id'  => $this->model_exam_schedule->id
                                ]);

                                // CHECK AVAILABLE USER
                                $available_user = $this->model_user->select('id')->where('ref_id', '=', $element2->student_id)->where('user_type', '=', 'student')->first();
                                if ( $available_user != NULL ):
                                    $this->model_notification->create([
                                        'sender_id'        => $_SESSION['user']['id'],
                                        'receiver_id'      => $available_user->id,
                                        'title'  => "New Exam Schedule Found",
                                        'body'  => "A new exam schedule has been assigned to you on ".$this->request->post['exam_date']
                                    ]);
                                endif;

                            } catch (Exception $e) {
                                echo json_encode( array( "status" => "failed" ), JSON_PRETTY_PRINT );
                                exit();
                            }
                                   
                        endforeach;

                        echo json_encode( array( "status" => "success" ), JSON_PRETTY_PRINT );
                        exit();

                    else:
                        echo json_encode( array( "status" => "success" ), JSON_PRETTY_PRINT );
                        exit();
                    endif;

                endforeach;            
            else:
                echo json_encode( array( "status" => "failed", "id" => $this->model_exam_grade->id ), JSON_PRETTY_PRINT );
                exit();
            endif;

        else:

            // creating a new exam_grade
            $this->model_exam_grade->exam_id = $this->request->post['select_exam_name'];
            $this->model_exam_grade->grade_id = $this->request->post['exam_grade'];

            if ( $this->model_exam_grade->save() != true ):
                echo json_encode( array( "status" => "failed" ), JSON_PRETTY_PRINT );
                exit();
            else:
                // creating exam schedule
                $this->model_exam_schedule->exam_grade_id = $this->model_exam_grade->id;
                $this->model_exam_schedule->subject_id = $this->request->post['exam_subject_name'];
                $this->model_exam_schedule->date = $this->request->post['exam_date'];
                $this->model_exam_schedule->start_time = $this->request->post['exam_starttime'];
                $this->model_exam_schedule->end_time = $this->request->post['exam_endtime'];
                $this->model_exam_schedule->venue = ( $this->request->post['subject_exam_venue']  == "" )  ? null : $this->request->post['subject_exam_venue'];
                $this->model_exam_schedule->instructions = ( $this->request->post['subject_exam_instructions'] == "" )  ? null : $this->request->post['subject_exam_instructions'];

                // SUBMIT
                if ( $this->model_exam_schedule->save() ):

                    // Create Student has Exam Schedule
                    foreach ( $this->model_class->select('id')->where('grade_id', '=', $this->request->post['exam_grade'])->get() as $key => $element ):
                        
                        if( $this->model_student_class->select('student_id')->where('class_id', '=', $element->id)->first() !== NULL ):

                            foreach ( $this->model_student_class->select('student_id')->where('class_id', '=', $element->id)->get() as $key2 => $element2 ):

                                try {
                                    $this->model_student_exam->create([
                                        'student_id'        => $element2->student_id,
                                        'exam_schedule_id'  => $this->model_exam_schedule->id
                                    ]);

                                    // CHECK AVAILABLE USER
                                    $available_user = $this->model_user->select('id')->where('ref_id', '=', $element2->student_id)->where('user_type', '=', 'student')->first();
                                    if ( $available_user != NULL ):
                                        $this->model_notification->create([
                                            'sender_id'        => $_SESSION['user']['id'],
                                            'receiver_id'      => $available_user->id,
                                            'title'  => "New Exam Schedule Found",
                                            'body'  => "A new exam schedule has been assigned to you on ".$this->request->post['exam_date']
                                        ]);
                                    endif;                                    
    
                                    echo json_encode( array( "status" => "success" ), JSON_PRETTY_PRINT );
                                    exit();
    
                                } catch (Exception $e) {
                                    echo json_encode( array( "status" => "failed" ), JSON_PRETTY_PRINT );
                                    exit();
                                }
                                       
                            endforeach;

                        else:
                            echo json_encode( array( "status" => "success" ), JSON_PRETTY_PRINT );
                            exit();
                        endif;

                    endforeach;

                else:
                    $this->model_exam_grade->destroy();
                    echo json_encode( array( "status" => "failed", "id" => $this->model_exam_grade->id ), JSON_PRETTY_PRINT );
                    exit();
                endif;
            endif;

        endif;
    }

    public function ajax_edit_exam_schedule() {

        //CHECK LOGIN STATUS
		if( !isset($_SESSION['user']) OR $_SESSION['user']['is_login'] != true ):
			header( 'Location:' . $this->config->get('base_url') . '/logout' );
			exit();
		endif;

        /**
         * This method will receive ajax request from
         * the front end with the payload
         * 
         *	exam_year
         *  exam_type_id
         *  exam_venue
         *  exam_instructions
         * 
         * We need to validate the data and then perform
         * the following tasks.
         *    - validate
         *    - CRUD
         *    - response ( JSON )
         */

        // MODEL
        $this->load->model('exam/schedule');
        $this->load->model('user');


        // SET JSON HEADER
        header('Content-Type: application/json');

        // PERMISSION
        if ( !$this->model_user->find($_SESSION['user']['id'])->hasPermission('exam-create-edit-schedule') ):
            echo json_encode( array( "status" => "failed", "message" => "Permission denied" ), JSON_PRETTY_PRINT );
            exit();
        endif;

        // VALIDATION : venue
        $is_valid_venue = GUMP::is_valid($this->request->post, array('venue' => 'alpha_space|max_len,50'));
        if ( $is_valid_venue !== true ):
            echo json_encode( array( "status" => "failed", "message" => $is_valid_venue[0] ), JSON_PRETTY_PRINT );
            exit();
        endif;

        // VALIDATION : instructions
        $is_valid_instructions = GUMP::is_valid($this->request->post, array('instructions' => 'alpha_space|max_len,200'));
        if ( $is_valid_instructions !== true ):
            echo json_encode( array( "status" => "failed", "message" => $is_valid_instructions[0] ), JSON_PRETTY_PRINT );
            exit();
        endif;

        try {
			$this->model_exam_schedule->where('id', '=', $this->request->post['id'])->update([
                'venue' => $this->request->post['venue'],
                'instructions' => $this->request->post['instructions']
			]);
			echo json_encode( array("status" => "success"), JSON_PRETTY_PRINT );
			exit();

		} catch (\Illuminate\Database\QueryException $e) {
			// var_dump( $e->errorInfo );
			echo json_encode( array( "status" => "failed", "message" => "Unable to edit exam schedule details. Please contact System Administrator" ), JSON_PRETTY_PRINT );
			exit();
		}
    }

    public function ajax_remove_examschedule() {

        //CHECK LOGIN STATUS
		if( !isset($_SESSION['user']) OR $_SESSION['user']['is_login'] != true ):
			header( 'Location:' . $this->config->get('base_url') . '/logout' );
			exit();
		endif;

        // SET JSON HEADER
        header('Content-Type: application/json'); 

        // MODEL
        $this->load->model('exam/schedule');
        $this->load->model('student/exam');
        $this->load->model('user');

        // PERMISSION
        if ( !$this->model_user->find($_SESSION['user']['id'])->hasPermission('exam-search-delete-schedule') ):
            echo json_encode( array( "status" => "failed", "message" => "Permission denied" ), JSON_PRETTY_PRINT );
            exit();
        endif;

        $date_now = Carbon::now()->isoFormat('YYYY-MM-DD');

        /**
         * check if the exam schedule ID is correct and
         * this exam has no results associated with it.
         */
        if ( isset($this->request->post['id']) AND !empty($this->request->post['id']) AND $this->request->post['date'] >= $date_now ):
            if ( $this->model_student_exam->select('id', 'marks')->where('exam_schedule_id', '=', $this->request->post['id'])->where('marks', '!=', NULL)->first() == NULL ):
                if ( $this->model_exam_schedule->find($this->request->post['id'])->delete() ):
                    echo json_encode( array( "status" => "success"), JSON_PRETTY_PRINT );
                    exit();
                else:
                    echo json_encode( array( "status" => "failed", "message" => "Cannot delete this exam schedule" ), JSON_PRETTY_PRINT );
                    exit();
                endif;
            else:
                echo json_encode( array( "status" => "failed", "message" => "This exam schedule already has results" ), JSON_PRETTY_PRINT );
                exit();
            endif;
        else:
            echo json_encode( array( "status" => "failed", "message" => "Cannot delete the exam schedule. Schedule date has expired" ), JSON_PRETTY_PRINT );
            exit();
        endif;
    }
    
}
?>