<?php

use Carbon\Carbon;
use Illuminate\Database\Capsule\Manager as DB;

class Result extends Controller {
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

		// RENDER VIEW
        $this->load->view('result/index', $data);
        
    }

    public function search() {
    
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
        $this->load->model('class');
        $this->load->model('grade');

        // TWIG : EXAM YEAR
        $exam_year = Carbon::now()->format('Y');
        for ( $i=1; $i<=5; $i++ ):
            $data['years'][$i] = $exam_year;
            $exam_year--;
        endfor;

        // TWIG : EXAMS
        foreach( $this->model_exam->select('id', 'type_id', 'year', 'venue', 'instructions')->orderBy('year')->get() as $key => $element ):
			$data['exams'][$key]['id'] = $element->id;
            $data['exams'][$key]['type_id']= $element->type_id;
            $data['exams'][$key]['year'] = $element->year;
            $data['exams'][$key]['venue'] = $element->venue;
            $data['exams'][$key]['instructions'] = $element->instructions;

            $data['exams'][$key]['type']['name'] = $this->model_exam_type->select('name')->where('id', '=', $element->type_id)->first()->name;
        endforeach;
        
		// RENDER VIEW
        $this->load->view('result/search', $data);
        
    }
    
    public function add() {
    
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
        
            $student_exam = $this->model_student_exam->select('id','student_id','exam_schedule_id', 'marks');

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
            foreach( $student_exam->get() as $key => $element ):                
                
                $data['exam']['schedules'][$key]['id'] = $element->id;
                $data['exam']['schedules'][$key]['student_id'] = $element->student_id;
                $data['exam']['schedules'][$key]['exam_schedule_id'] = $element->exam_schedule_id;
                $data['exam']['schedules'][$key]['marks'] = $element->marks;

                $student_data = DB::table('student_has_exam_schedule')
                    ->join('student', 'student_has_exam_schedule.student_id', '=', 'student.id')
                    ->join('student_has_class', 'student_has_exam_schedule.student_id', '=', 'student_has_class.student_id')
                    ->select('student.admission_no','student.initials','student.surname','student_has_class.class_id','student_has_class.index_no')
                    ->where('student_has_exam_schedule.student_id', '=', $element->student_id)->first();

                    // ->join('exam_grade_has_schedule', 'student_has_exam_schedule.exam_schedule_id', '=', 'exam_grade_has_schedule.id')

                $data['exam']['schedules'][$key]['admission_no'] = $student_data->admission_no;
                $data['exam']['schedules'][$key]['class'] = $student_data->class_id;

                // echo "<pre>";
                //     var_dump( $student_data->surname );
                // echo "</pre>";
            endforeach;

        endif;

		// RENDER VIEW
        $this->load->view('result/add', $data);
        
    }
    
}
?>