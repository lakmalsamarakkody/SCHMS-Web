<?php

use Carbon\Carbon;
use Illuminate\Database\Capsule\Manager as DB;

class Home extends Controller {
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

		//Check Login Status
		if( !isset($_SESSION['user']) OR $_SESSION['user']['is_login'] != true ):

			header( 'Location:' . $this->config->get('base_url') . '/logout' );
			exit();

		endif;

		// MODEL
		$this->load->model('student');
		$this->load->model('student/attendance');
		$this->load->model('staff');
		$this->load->model('staff/attendance');

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

		// RENDER VIEW
		$this->load->view('home/index', $data);

	}
}

?>