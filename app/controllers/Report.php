<?php

// USE
use Carbon\Carbon;
use Illuminate\Database\Capsule\Manager as DB;
use Fpdf\Fpdf;

class Report extends Controller {

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
        $this->load->view('report/index', $data);
    }

    // START : ATTENDANCE REPORTS
    public function attendance() {
    
        // SITE DETAILS
		$data['app']['url']			= $this->config->get('base_url');
		$data['app']['title']		= $this->config->get('site_title');
		$data['app']['theme']		= $this->config->get('app_theme');

		// HEADER / FOOTER
		$data['template']['header']		= $this->load->controller('common/header', $data);
        $data['template']['footer']		= $this->load->controller('common/footer', $data);
        $data['template']['sidenav']	= $this->load->controller('common/sidenav', $data);
        $data['template']['topmenu']	= $this->load->controller('common/topmenu', $data);

        // MODELS
        $this->load->model('class');
        $this->load->model('grade');

        // QUERY CLASS
        foreach( $this->model_class->select('id', 'grade_id', 'staff_id', 'name')->get() as $key => $element ):
            $data['student_class'][$key]['id'] = $element->id;
            $data['student_class'][$key]['grade']['id'] = $element->grade_id;
            $data['student_class'][$key]['staff']['id'] = $element->staff_id;
            $data['student_class'][$key]['name'] = $element->name;

            $data['student_class'][$key]['grade']['name'] = $this->model_grade->select('name')->where('id', '=', $element->grade_id)->first()->name;
        endforeach;

		// RENDER VIEW
        $this->load->view('report/attendance', $data);
    }

    public function class_attendance_ajax() {

        // SET JSON HEADER
        header('Content-Type: application/json');

        // MODELS
        $this->load->model("class");
        $this->load->model("grade");
        $this->load->model("student");
        $this->load->model("student/class");
        $this->load->model("student/attendance");

        // VALIDATION : month
        $is_valid_month = GUMP::is_valid($this->request->post, array('month' => 'required|max_len,8'));
        if ( $is_valid_month !== true ):
            echo json_encode( array("status" => "failed", "error" => "Please select a valid Month" ), JSON_PRETTY_PRINT );
            exit();
        endif;

        $time_now = Carbon::now()->isoFormat('YYYY-MM-DD HH:mm:ss');
        $date_now = Carbon::now()->isoFormat('YYYY-MM-DD');

        // Days in a month
        $dates = Carbon::createFromFormat("d/m/Y", "01/".$this->request->post['month']);
        $month_year = $dates->format("Y-m");
        $days_in_month = $dates->daysInMonth;

        // CHECK IF SUBMITED
        if ( isset($this->request->post['class_id']) AND !empty($this->request->post['class_id']) ):

            // IS CORRECT CLASS ID
            if ( $this->model_class->select('name')->where('id', '=', $this->request->post['class_id'])->first() === NULL ):
                echo json_encode( array("status" => "failed", "error" => "Invalid Class is Selected" ), JSON_PRETTY_PRINT );
                exit();
            endif;

            // CLASS DATA
            $class_data = $this->model_class->select('grade_id', 'name')->where('id', "=", $this->request->post['class_id'])->first();

            // DAY COUTNS
            $data['day_count'] = $days_in_month;

            // TITLE DETAILS
            $data['class_attendance']['class']['name'] = $this->model_grade->select('name')->where('id', '=', $class_data->grade_id)->first()->name." - ".$class_data->name;
            $data['class_attendance']['month'] = $this->request->post['month'];
            $data['class_attendance']['generated_on'] = $time_now;
            $data['class_attendance']['generated_by'] = "";

            // CONTENT
            $student = $this->model_student->select('id', 'class_id', 'admission_no', 'full_name', 'initials', 'surname')->where('class_id', '=', $this->request->post['class_id']);

            foreach( $student->get() as $key => $element ):

                // GET INDEX
                $index_no = $this->model_student_class->select('index_no')->where('student_id', '=', $element->id)->where('class_id', '=', $element->class_id)->first()->index_no;

                // STUDENT DETAILS
                $data['student'][$key]['index']  = $index_no;
                $data['student'][$key]['name'] = $element->initials.' '.$element->surname;

                // STUDENT STATUS FOR MONTH
                for ( $i=1; $i<= $days_in_month; $i++ ):
                    $attendance = $this->model_student_attendance->select('id', 'date')->where('student_id', '=', $element->id)->where('date', '=', $month_year."-".$i)->first();
                    if ( $attendance !== NULL):
                        $data['student'][$key]['attendance'][$i] = true;
                    else:
                        $data['student'][$key]['attendance'][$i] = false;
                    endif;

                    $data['days_in_month'][$i] = $i;
                endfor;

            endforeach;

            // JSReports
            $JSReport = new JSReport();
            $file = 'class_attendance';
            $JSReport->get_report('CLASS_ATTENDANCE', $data, 'attendance/'.$file);

            // ADD ENTRY TO DATABASE ( report table )

            echo json_encode( array("status" => "success", "path" => $this->config->get('base_url').'/data/report/attendance/' ), JSON_PRETTY_PRINT );  
            exit();


        else:
            echo json_encode( array("status" => "failed", "error" => "Invalid Class Selected" ), JSON_PRETTY_PRINT );
            exit();
        endif;

    }

    public function staff_attendance_ajax() {

        // SET JSON HEADER
        header('Content-Type: application/json');

        // MODELS
        $this->load->model("staff");
        $this->load->model("staff/attendance");

        // VALIDATION : month
        $is_valid_month = GUMP::is_valid($this->request->post, array('month' => 'required|max_len,8'));
        if ( $is_valid_month !== true ):
            echo json_encode( array("status" => "failed", "error" => "Please select a valid Month" ), JSON_PRETTY_PRINT );
            exit();
        endif;

        $time_now = Carbon::now()->isoFormat('YYYY-MM-DD HH:mm:ss');
        $date_now = Carbon::now()->isoFormat('YYYY-MM-DD');

        // Days in a month
        $dates = Carbon::createFromFormat("d/m/Y", "01/".$this->request->post['month']);
        $month_year = $dates->format("Y-m");
        $days_in_month = $dates->daysInMonth;

        // CHECK IF SUBMITED
        if ( isset($this->request->post['month']) AND !empty($this->request->post['month']) ):

            // DAY COUTNS
            $data['day_count'] = $days_in_month;

            // TITLE DETAILS
            $data['staff_attendance']['month'] = $this->request->post['month'];
            $data['staff_attendance']['generated_on'] = $time_now;
            $data['staff_attendance']['generated_by'] = "";

            // CONTENT
            $staff = $this->model_staff->select('id', 'employee_number', 'full_name', 'initials', 'surname');

            foreach( $staff->get() as $key => $element ):
                $data['staff'][$key]['employee_number']  = $element->employee_number;
                $data['staff'][$key]['name'] = $element->initials.' '.$element->surname;

                // STAFF STATUS FOR MONTH
                for ( $i=1; $i<= $days_in_month; $i++ ):
                    $attendance = $this->model_staff_attendance->select('id', 'date')->where('staff_id', '=', $element->id)->where('date', '=', $month_year."-".$i)->first();
                    if ( $attendance !== NULL):
                        $data['staff'][$key]['attendance'][$i] = true;
                    else:
                        $data['staff'][$key]['attendance'][$i] = false;
                    endif;

                    $data['days_in_month'][$i] = $i;
                endfor;

            endforeach;

            // JSReports
            $JSReport = new JSReport();
            $file = 'staff_attendance';
            $JSReport->get_report('STAFF_ATTENDANCE', $data, 'attendance/'.$file);

            // ADD ENTRY TO DATABASE ( report table )

            echo json_encode( array("status" => "success", "path" => $this->config->get('base_url').'/data/report/attendance/' ), JSON_PRETTY_PRINT );  
            exit();


        else:
            echo json_encode( array("status" => "failed", "error" => "Invalid Month Selected" ), JSON_PRETTY_PRINT );
            exit();
        endif;

    }
    // END : ATTENDANCE REPORTS

    // START : STUDENT REPORTS
    public function student() {
    
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
        $this->load->view('report/student', $data);
    }

    public function timetable() {
    
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
        $this->load->model('class');
        $this->load->model('grade');
        $this->load->model('staff');

        // QUERY CLASS
        foreach( $this->model_class->select('id', 'grade_id', 'staff_id', 'name')->get() as $key => $element ):
            $data['classes'][$key]['id'] = $element->id;
            $data['classes'][$key]['grade']['id'] = $element->grade_id;
            $data['classes'][$key]['staff']['id'] = $element->staff_id;
            $data['classes'][$key]['name'] = $element->name;

            $data['classes'][$key]['grade']['name'] = $this->model_grade->select('name')->where('id', '=', $element->grade_id)->first()->name;
        endforeach;

        // QUERY STAFF
        foreach( $this->model_staff->select('id', 'full_name')->get() as $key => $element ):
            $data['staffs'][$key]['id'] = $element->id;
            $data['staffs'][$key]['fullname'] = $element->full_name;
        endforeach;

		// RENDER VIEW
        $this->load->view('report/timetable', $data);
    }

    public function class_timetable_ajax() {

        // SET JSON HEADER
        header('Content-Type: application/json');

        // MODELS
        $this->load->model("class");
        $this->load->model("grade");
        $this->load->model("class/timetable");

        $time_now = Carbon::now()->isoFormat('YYYY-MM-DD HH:mm:ss');
        $date_now = Carbon::now()->isoFormat('YYYY-MM-DD');

        // CHECK IF SUBMITED
        if ( isset($this->request->post['class_id']) AND !empty($this->request->post['class_id']) ):

            // IS CORRECT CLASS ID
            if ( $this->model_class->select('name')->where('id', '=', $this->request->post['class_id'])->first() === NULL ):
                echo json_encode( array("status" => "failed", "error" => "Invalid Class is Selected" ), JSON_PRETTY_PRINT );
                exit();
            endif;

            // CLASS DATA
            $class_data = $this->model_class->select('grade_id', 'name')->where('id', "=", $this->request->post['class_id'])->first();

            // DAY COUTNS
            $data['day_count'] = $days_in_month;

            // TITLE DETAILS
            $data['timetable']['name'] = $this->model_grade->select('name')->where('id', '=', $class_data->grade_id)->first()->name." - ".$class_data->name;
            $data['timetable']['generated_on'] = $time_now;
            $data['timetable']['generated_by'] = "";

            // CONTENT
            $class_timetable = $this->model_class_timetable->select('id', 'day', 'period', 'subject_id', 'staff_id')->where('class_id', '=', $this->request->post['class_id']);

            foreach( $class_timetable->get() as $key => $element ):

                // TIMETABLE DETAILS
                $data['class_timetable'][$key]['id']  = $element->id;
                $data['class_timetable'][$key]['day']  = $element->day;
                $data['class_timetable'][$key]['period']  = $element->period;
                $data['class_timetable'][$key]['subject_id']  = $element->subject_id;
                $data['class_timetable'][$key]['staff_id']  = $element->staff_id;

            endforeach;

            // JSReports
            $JSReport = new JSReport();
            $file = 'class_timetable';
            $JSReport->get_report('CLASS_ATTENDANCE', $data, 'attendance/'.$file);

            // ADD ENTRY TO DATABASE ( report table )

            echo json_encode( array("status" => "success", "path" => $this->config->get('base_url').'/data/report/attendance/' ), JSON_PRETTY_PRINT );  
            exit();


        else:
            echo json_encode( array("status" => "failed", "error" => "Invalid Class Selected" ), JSON_PRETTY_PRINT );
            exit();
        endif;


    }

    public function result() {
    
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
        $this->load->view('report/result', $data);
    }

    public function health() {
    
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
        $this->load->view('report/health', $data);
    }

    public function staff() {
    
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
        $this->load->view('report/staff', $data);
    }

}