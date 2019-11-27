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

    public function attendance_ajax_by_class() {

        // SET JSON HEADER
        header('Content-Type: application/json');

        // MODELS
        $this->load->model("class");
        $this->load->model("grade");
        $this->load->model("student");
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
            if ( $this->model_class::select('name')->where('id', '=', $this->request->post['class_id'])->first() === NULL ):
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
                $data['student'][$key]['index']  = 10;
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

            echo json_encode( array("status" => "success", "path" => $this->config->get('base_url').'/data/report/attendance/gg' ), JSON_PRETTY_PRINT );  // WENAS KARAHAN
            exit();


        else:
            echo json_encode( array("status" => "failed", "error" => "Something funcky happned" ), JSON_PRETTY_PRINT );  // WENAS KARAHAN
            exit();
        endif;

    }

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

		// RENDER VIEW
        $this->load->view('report/timetable', $data);
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