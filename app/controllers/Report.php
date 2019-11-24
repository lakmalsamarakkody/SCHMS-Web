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
        $this->load->model("student");
        $this->load->model("student/attendance");

        $time_now = Carbon::now();
        $date_now = Carbon::now()->isoFormat('YYYY-MM-DD');

        // VALIDATION : month
        $is_valid_month = GUMP::is_valid($this->request->post, array('month' => 'required|max_len,8'));
        if ( $is_valid_month !== true ):
            echo json_encode( array("status" => "failed", "error" => "Please select a valid Month" ), JSON_PRETTY_PRINT );
            exit();
        endif;

        // CHECK IF SUBMITED
        if ( isset($this->request->post['class_id']) AND !empty($this->request->post['class_id']) ):

            // IS CORRECT CLASS ID
            if ( $this->model_class::select('name')->where('id', '=', $this->request->post['class_id'])->first() === NULL ):
                echo json_encode( array("status" => "failed", "error" => "Invalid Class is Selected" ), JSON_PRETTY_PRINT );
                exit();
            endif;

            // FPDF LAYOUT
            $PDF = new Fpdf('L', 'mm', 'A4');
            $PDF->SetMargins(0,0,0);
            $PDF->AddPage();
            
            // HEADER
            // $PDF->Image(ABS_PATH.'/data/img/report_header.png', null, null, 210, 30);
            $PDF->SetFillColor(114, 124, 245);
            $PDF->SetTextColor(255, 255, 255);

            // $PDF->SetFont('Arial','',8);
            // $PDF->Cell(0, 10,'Peellawaththa, Andiambalama', 0, 0, 'L', true);
            $PDF->SetFont('Arial','B',14);;
            $PDF->Cell(0, 10,'WP/NG David De Silva College', 0, 0, 'C', true);
            $PDF->SetFont('Arial','',8);
            $PDF->Cell(0, 10,'time : '.$time_now, 0, 1, 'R', true);

            // $PDF->SetFont('Arial','',8);
            // $PDF->Cell(0, 10,'wpngdavidsilvacollege@gmail.com', 0, 0, 'L', true);
            $PDF->SetFont('Arial','',12);
            $PDF->Cell(0, 5,'Minuwangoda', 0, 0, 'C', true);
            $PDF->SetFont('Arial','',8);
            $PDF->Cell(0, 5,'generated_by : '.$_SESSION['user']['id'], 0, 1, 'R', true);


            // TITLE
            $PDF->SetMargins(5,5,5);
            $PDF->SetTextColor(100, 100, 100);
            $PDF->SetFont('Arial','B',14);
            $PDF->Cell(0, 15,'Attendance Report', 0, 1, 'C', false);

            // CLASS DATA
            $PDF->SetFont('Arial','B', 12);
            $PDF->SetTextColor(0, 0, 0);
            $PDF->Cell(0, 5,'Class : 10-A', 0, 0, 'L', false);
            $PDF->Cell(0, 5,'Month : '.$this->request->post['month'], 0, 1, 'R', false);

            // CONTENT

            // FOOTER
            // $PDF->SetMargins(5,5,5);
            $PDF->SetY(182);
            // $PDF->SetY(271);
            $PDF->SetFont('Arial','',8);
            $PDF->Cell(0,5,'Authorized by : ________________',0,0,'L');
            $PDF->SetFont('Arial','I',8);
            $PDF->Cell(0,5,'Page '.$PDF->PageNo(),0,0,'R');


            // OUTPUT
            $PDF->Output(ABS_PATH.'/data/reports/attendance/gg.pdf', 'F');

            // ATTENDANCE
            //$data = $this->model_attendance::select()

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