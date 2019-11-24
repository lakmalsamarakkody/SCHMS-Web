<?php

// USE
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

        // CHECK IF SUBMITED
        if ( isset($this->request->post['class_id']) AND !empty($this->request->post['class_id']) ):

            // IS CORRECT CLASS ID
            if ( $this->model_class::select('name')->where('id', '=', $this->request->post['class_id'])->first() === NULL ):
                echo json_encode( array("status" => "failed", "error" => "Incorrect class id" ), JSON_PRETTY_PRINT );  // WENAS KARAHAN
                exit();
            endif;

            // STUDENT NAMES
            $PDF = new Fpdf('L', 'mm', 'A4');
            $PDF->SetMargins(0,0,0);
            $PDF->AddPage();
            $PDF->Image(ABS_PATH.'/data/img/report_header.png', null, null, 210, 30);
            $PDF->SetFont('Arial','B',16);

            // CONTENT
            $PDF->SetTextColor(255, 255, 255);
            $PDF->Cell(0, 15,'Attendance By Class', 0, 1, 'C', true);

            // CLASS DATA
            $PDF->SetFont('Arial','B', 12);
            $PDF->SetTextColor(0, 0, 0);
            $PDF->SetLeftMargin(100);
            $PDF->Cell(0, 15,'Class : 10-A', 0, 0, 'L', false);
            $PDF->Cell(0, 15,'Class :', 0, 0, 'R', false);

            // FOOTER


            // OUTPUT
            $PDF->Output(ABS_PATH.'/data/reports/gg.pdf', 'F');

            // ATTENDANCE
            //$data = $this->model_attendance::select()

            echo json_encode( array("status" => "success", "path" => $this->config->get('base_url').'/data/report/gg' ), JSON_PRETTY_PRINT );  // WENAS KARAHAN
            exit();


        else:
            echo json_encode( array("status" => "failed", "error" => "Something funcky happned" ), JSON_PRETTY_PRINT );  // WENAS KARAHAN
            exit();
        endif;

    }
}