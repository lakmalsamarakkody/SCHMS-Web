<?php

use Carbon\Carbon;
use Illuminate\Database\Capsule\Manager as DB;

class Home extends Controller {
	public function index() {

		//Check Login Status
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
		$this->load->model('student');
		$this->load->model('student/attendance');
		$this->load->model('student/sport');
		$this->load->model('staff');
		$this->load->model('staff/attendance');
		$this->load->model('class');
		$this->load->model('exam');
		$this->load->model('exam/schedule');
		$this->load->model('grade');
		$this->load->model('parent');
		$this->load->model('user');
		$this->load->model('sport');
		$this->load->model('coach');

		$date_now = Carbon::now()->isoFormat('YYYY-MM-DD');

		// STUDENT TOTAL
		$data['student']['total']['all'] = $this->model_student->select('id')->count();
		$data['student']['total']['male'] = $this->model_student->select('id')->where('gender', '=', 'male')->count();
		$data['student']['total']['female'] = $this->model_student->select('id')->where('gender', '=', 'female')->count();

		// STUDENT ATTENDANCE
		$data['student']['attendance']['all'] = $this->model_student_attendance->select('id')->where('date', '=', $date_now)->count();

		$data['student']['attendance']['male'] = DB::table('student_attendance')
		->join('student', 'student_attendance.student_id', '=', 'student.id')
		->select('student.id')
		->where('date', '=', $date_now)
		->where('gender', '=', 'male')
		->count();

		$data['student']['attendance']['female'] = DB::table('student_attendance')
		->join('student', 'student_attendance.student_id', '=', 'student.id')
		->select('student.id')
		->where('date', '=', $date_now)
		->where('gender', '=', 'female')
		->count();

		$data['student']['absent']['all'] = $data['student']['total']['all'] - $data['student']['attendance']['all'];
		$data['student']['absent']['male'] = $data['student']['total']['male'] - $data['student']['attendance']['male'];
		$data['student']['absent']['female'] = $data['student']['total']['female'] - $data['student']['attendance']['female'];

		// STAFF TOTAL
		$data['staff']['total']['all'] = $this->model_staff->select('id')->count();
		$data['staff']['total']['male'] = $this->model_staff->select('id')->where('gender', '=', 'male')->count();
		$data['staff']['total']['female'] = $this->model_staff->select('id')->where('gender', '=', 'female')->count();

		// STAFF ATTENDANCE
		$data['staff']['attendance']['all'] = $this->model_staff_attendance->select('id')->where('date', '=', $date_now)->count();

		$data['staff']['attendance']['male'] = DB::table('staff_attendance')
		->join('staff', 'staff_attendance.staff_id', '=', 'staff.id')
		->select('staff.id')
		->where('date', '=', $date_now)
		->where('gender', '=', 'male')
		->count();

		$data['staff']['attendance']['female'] = DB::table('staff_attendance')
		->join('staff', 'staff_attendance.staff_id', '=', 'staff.id')
		->select('staff.id')
		->where('date', '=', $date_now)
		->where('gender', '=', 'female')
		->count();
		
		$data['staff']['absent']['all'] = $data['staff']['total']['all'] - $data['staff']['attendance']['all'];
		$data['staff']['absent']['male'] = $data['staff']['total']['male'] - $data['staff']['attendance']['male'];
		$data['staff']['absent']['female'] = $data['staff']['total']['female'] - $data['staff']['attendance']['female'];

		// DATE AND TIME
        $date_now = Carbon::now()->isoFormat('YYYY-MM-DD');

        // UPCOMING EXAMS
        foreach ( $this->model_exam_schedule->where('date', '>=', $date_now)->orderBy('date')->get()->take(5) as $key => $element ):
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
        foreach ( $this->model_exam_schedule->where('date', '<', $date_now)->orderBy('date', 'DESC')->get()->take(5) as $key => $element ):
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

		// PARENT TOTAL CARD
        $data['parent']['total']['all'] = $this->model_parent->select('id')->count();
        $data['parent']['total']['male'] = $this->model_parent->select('id')->where('gender', '=', 'male')->count();
		$data['parent']['total']['female'] = $this->model_parent->select('id')->where('gender', '=', 'female')->count();
		
		// USER TOTAL CARDS
        $data['user']['total']['all'] = $this->model_user->select('id')->count();
        $data['user']['total']['active'] = $this->model_user->select('id')->where('status', '=', 'Active')->count();
		$data['user']['total']['disabled'] = $this->model_user->select('id')->where('status', '=', 'Inactive')->count();
		
		// SPORT CARD
		$data['sport']['total']['all'] = $this->model_sport->select('id')->count();
		$data['coach']['total']['all'] = $this->model_coach->select('id')->count();
		$data['sport']['student']['total']['all'] = $this->model_student_sport->distinct()->get('student_id')->count();

		// APEX CHARTS
		// STUDENT IN CLASS CHART
		foreach ( $this->model_class->select('id','grade_id','name')->get() as $key => $element ):
            $grade = $this->model_grade->select('name')->where('id', '=', $element->grade_id)->first()->name;
            $data['classes'][$key]['name'] = $grade." - ".$element->name;
            $data['classes'][$key]['total'] = $this->model_student->select('id')->where('class_id', '=', $element->id)->count();
        endforeach;

		// ATTENDANCE IN CLASS CHART
		foreach ( $this->model_class->select('id','grade_id','name')->get() as $key => $element ):
            $grade = $this->model_grade->select('name')->where('id', '=', $element->grade_id)->first()->name;
            $data['classes'][$key]['name'] = $grade." - ".$element->name;
            $data['classes'][$key]['present'] = DB::table('student_attendance')
            ->join('student', 'student_attendance.student_id', '=', 'student.id')
            ->select('student.id')
            ->where('student.class_id', '=', $element->id)
            ->where('date', '=', $date_now)
            ->count();
        endforeach;

		// RENDER VIEW
		$this->load->view('home/index', $data);

	}
}

?>