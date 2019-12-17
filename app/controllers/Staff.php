<?php

use Carbon\Carbon;
use Illuminate\Database\Capsule\Manager as DB;

class Staff extends Controller {
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

        //MODEL
        $this->load->model('staff');
        $this->load->model('staff/attendance');
		$this->load->model('class');
        $this->load->model('grade');

        $date_now = Carbon::now()->isoFormat('YYYY-MM-DD');

        // STAFF TOTAL
		$data['staff']['total']['all'] = $this->model_staff->select('id')->count();
		$data['staff']['total']['male'] = $this->model_staff->select('id')->where('gender', '=', 'male')->count();
        $data['staff']['total']['female'] = $this->model_staff->select('id')->where('gender', '=', 'female')->count();

        // STAFF TOTAL ATTENDANCE
        $data['staff']['total']['attendance']['all'] = DB::table('staff_attendance')
        ->join('staff', 'staff_attendance.staff_id', '=', 'staff.id')
		->select('staff.id')
		->where('date', '=', $date_now)
        ->count();
        
        $data['staff']['total']['attendance']['male'] = DB::table('staff_attendance')
        ->join('staff', 'staff_attendance.staff_id', '=', 'staff.id')
		->select('staff.id')
		->where('date', '=', $date_now)
        ->where('gender', '=', 'male')
        ->count();
        
        $data['staff']['total']['attendance']['female'] = DB::table('staff_attendance')
        ->join('staff', 'staff_attendance.staff_id', '=', 'staff.id')
		->select('staff.id')
		->where('date', '=', $date_now)
        ->where('gender', '=', 'female')
        ->count();
        
        $data['staff']['total']['absent']['all'] = $data['staff']['total']['all'] - $data['staff']['total']['attendance']['all'];
        $data['staff']['total']['absent']['male'] = $data['staff']['total']['male'] - $data['staff']['total']['attendance']['male'];
        $data['staff']['total']['absent']['female'] = $data['staff']['total']['female'] - $data['staff']['total']['attendance']['female'];
        
        // STAFF ACADEMIC
        $data['staff']['academic']['all'] = DB::table('staff')
        ->join('staff_type', 'staff.type_id', '=', 'staff_type.id')
        ->join('staff_category', 'staff_type.category_id', '=', 'staff_category.id')
		->select('staff.id')
        ->where('staff_category.name', '=', 'Academic')
        ->count();
        
        $data['staff']['academic']['male'] = DB::table('staff')
        ->join('staff_type', 'staff.type_id', '=', 'staff_type.id')
        ->join('staff_category', 'staff_type.category_id', '=', 'staff_category.id')
        ->select('staff.id')
        ->where('gender', '=', 'male')
        ->where('staff_category.name', '=', 'Academic')
        ->count();
        
        $data['staff']['academic']['female'] = DB::table('staff')
        ->join('staff_type', 'staff.type_id', '=', 'staff_type.id')
        ->join('staff_category', 'staff_type.category_id', '=', 'staff_category.id')
        ->select('staff.id')
        ->where('gender', '=', 'female')
        ->where('staff_category.name', '=', 'Academic')
        ->count();

        // STAFF ACADEMIC ATTENDANCE
        $data['staff']['academic']['attendance']['all'] = DB::table('staff_attendance')
        ->join('staff', 'staff_attendance.staff_id', '=', 'staff.id')
        ->join('staff_type', 'staff.type_id', '=', 'staff_type.id')
        ->join('staff_category', 'staff_type.category_id', '=', 'staff_category.id')
		->select('staff.id')
		->where('date', '=', $date_now)
        ->where('staff_category.name', '=', 'Academic')
        ->count();
        
        $data['staff']['academic']['attendance']['male'] = DB::table('staff_attendance')
        ->join('staff', 'staff_attendance.staff_id', '=', 'staff.id')
        ->join('staff_type', 'staff.type_id', '=', 'staff_type.id')
        ->join('staff_category', 'staff_type.category_id', '=', 'staff_category.id')
		->select('staff.id')
		->where('date', '=', $date_now)
        ->where('gender', '=', 'male')
        ->where('staff_category.name', '=', 'Academic')
        ->count();
        
        $data['staff']['academic']['attendance']['female'] = DB::table('staff_attendance')
        ->join('staff', 'staff_attendance.staff_id', '=', 'staff.id')
        ->join('staff_type', 'staff.type_id', '=', 'staff_type.id')
        ->join('staff_category', 'staff_type.category_id', '=', 'staff_category.id')
		->select('staff.id')
		->where('date', '=', $date_now)
        ->where('gender', '=', 'female')
        ->where('staff_category.name', '=', 'Academic')
        ->count();
        
        $data['staff']['academic']['absent']['all'] = $data['staff']['academic']['all'] - $data['staff']['academic']['attendance']['all'];
        $data['staff']['academic']['absent']['male'] = $data['staff']['academic']['male'] - $data['staff']['academic']['attendance']['male'];
        $data['staff']['academic']['absent']['female'] = $data['staff']['academic']['female'] - $data['staff']['academic']['attendance']['female'];

        // STAFF NON ACADEMIC
        $data['staff']['nonacademic']['all'] = DB::table('staff')
        ->join('staff_type', 'staff.type_id', '=', 'staff_type.id')
        ->join('staff_category', 'staff_type.category_id', '=', 'staff_category.id')
		->select('staff.id')
        ->where('staff_category.name', '=', 'Non-Academic')
        ->count();
        
        $data['staff']['nonacademic']['male'] = DB::table('staff')
        ->join('staff_type', 'staff.type_id', '=', 'staff_type.id')
        ->join('staff_category', 'staff_type.category_id', '=', 'staff_category.id')
        ->select('staff.id')
        ->where('gender', '=', 'male')
        ->where('staff_category.name', '=', 'Non-Academic')
        ->count();
        
        $data['staff']['nonacademic']['female'] = DB::table('staff')
        ->join('staff_type', 'staff.type_id', '=', 'staff_type.id')
        ->join('staff_category', 'staff_type.category_id', '=', 'staff_category.id')
        ->select('staff.id')
        ->where('gender', '=', 'female')
        ->where('staff_category.name', '=', 'Non-Academic')
        ->count();
        
        // STAFF NON-ACADEMIC ATTENDANCE
        $data['staff']['nonacademic']['attendance']['all'] = DB::table('staff_attendance')
        ->join('staff', 'staff_attendance.staff_id', '=', 'staff.id')
        ->join('staff_type', 'staff.type_id', '=', 'staff_type.id')
        ->join('staff_category', 'staff_type.category_id', '=', 'staff_category.id')
		->select('staff.id')
		->where('date', '=', $date_now)
        ->where('staff_category.name', '=', 'Non-Academic')
        ->count();
        
        $data['staff']['nonacademic']['attendance']['male'] = DB::table('staff_attendance')
        ->join('staff', 'staff_attendance.staff_id', '=', 'staff.id')
        ->join('staff_type', 'staff.type_id', '=', 'staff_type.id')
        ->join('staff_category', 'staff_type.category_id', '=', 'staff_category.id')
		->select('staff.id')
		->where('date', '=', $date_now)
        ->where('gender', '=', 'male')
        ->where('staff_category.name', '=', 'Non-Academic')
        ->count();
        
        $data['staff']['nonacademic']['attendance']['female'] = DB::table('staff_attendance')
        ->join('staff', 'staff_attendance.staff_id', '=', 'staff.id')
        ->join('staff_type', 'staff.type_id', '=', 'staff_type.id')
        ->join('staff_category', 'staff_type.category_id', '=', 'staff_category.id')
		->select('staff.id')
		->where('date', '=', $date_now)
        ->where('gender', '=', 'female')
        ->where('staff_category.name', '=', 'Non-Academic')
        ->count();
        
        $data['staff']['nonacademic']['absent']['all'] = $data['staff']['nonacademic']['all'] - $data['staff']['nonacademic']['attendance']['all'];
        $data['staff']['nonacademic']['absent']['male'] = $data['staff']['nonacademic']['male'] - $data['staff']['nonacademic']['attendance']['male'];
        $data['staff']['nonacademic']['absent']['female'] = $data['staff']['nonacademic']['female'] - $data['staff']['nonacademic']['attendance']['female'];
        
        // CLASS
        foreach( $this->model_class->select('id', 'grade_id', 'staff_id','name')->orderBy('grade_id')->get() as $key => $element ):
            
			$data['classes'][$key]['id'] = $element->id;
			$data['classes'][$key]['grade']['id'] = $element->grade_id;
			$data['classes'][$key]['name'] = $element->name;

			// GET GRADE DETAILS
			$data['classes'][$key]['grade']['name'] = $this->model_grade->select('name')->where('id', '=', $element->grade_id)->first()->name;

			// GET STAFF DETAILS
			if ( $element->staff_id !== NULL):
				$data['classes'][$key]['staff']['name'] = $this->model_staff->select('initials', 'surname')->where('id', '=', $element->staff_id)->first()->toArray();
			else:
				$data['classes'][$key]['staff']['name'] = "";
            endif;
            
            // GET STATUS
            if ( $this->model_class->select('staff_id')->where('id', '=', $element->id)->first()->staff_id !== NULL ):
                if ( $this->model_staff_attendance->select('id')->where('staff_id', '=', $element->staff_id)->where('date', '=', $date_now)->first() !== NULL ):
                    $data['classes'][$key]['staff']['status'] = "Present";
                else:
                    $data['classes'][$key]['staff']['status'] = "Absent";
                endif;
            else:
                $data['classes'][$key]['staff']['status'] = "";
            endif;

		endforeach;

		// RENDER VIEW
        $this->load->view('staff/index', $data);
        
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

        // MODELS
        $this->load->model('staff');
        $this->load->model('staff/subject');
        $this->load->model('staff/type');
        $this->load->model('class');
        $this->load->model('grade');
        $this->load->model('district');
        $this->load->model('subject');
        $this->load->model('religion');

        // TYPE
        foreach( $this->model_staff_type->select('id', 'name')->orderBy('name')->get() as $key => $element ):
            $data['staff_types'][$key]['id'] = $element->id;
            $data['staff_types'][$key]['name'] = $element->name;
        endforeach;

        //STAFF CLASS
        foreach( $this->model_class->select('id', 'grade_id', 'staff_id', 'name')->orderBy('grade_id')->orderBy('name')->get() as $key => $element ):
            $data['staff_class'][$key]['id'] = $element->id;
            $data['staff_class'][$key]['grade']['id'] = $element->grade_id;
            $data['staff_class'][$key]['staff']['id'] = $element->staff_id;
            $data['staff_class'][$key]['name'] = $element->name;

            $data['staff_class'][$key]['grade']['name'] = $this->model_grade->select('name')->where('id', '=', $element->grade_id)->first()->name;
        endforeach;

        // CITY
        foreach( $this->model_staff->select('id', 'city')->orderBy('city')->distinct()->get() as $key => $element ):
            $data['staff_city'][$key]['id'] = $element->id;
            $data['staff_city'][$key]['name'] = $element->city;
        endforeach;

        //DISTRICT
        foreach( $this->model_district->select('id', 'province_id', 'name')->orderBy('name')->get() as $key => $element ):
            $data['staff_district'][$key]['id'] = $element->id;
            $data['staff_district'][$key]['province']['id'] = $element->province_id;
            $data['staff_district'][$key]['name'] = $element->name;
        endforeach;

        //SUBJECT
        foreach( $this->model_subject->select('id', 'name', 'si_name')->orderBy('name')->get() as $key => $element ):
            $data['staff_subject'][$key]['id'] = $element->id;
            $data['staff_subject'][$key]['name'] = $element->name;
            $data['staff_subject'][$key]['si_name'] = $element->si_name;
        endforeach;

        //RELIGION
        foreach( $this->model_religion->select('id', 'name')->orderBy('name')->get() as $key => $element ):
            $data['staff_religion'][$key]['id'] = $element->id;
            $data['staff_religion'][$key]['name'] = $element->name;
        endforeach;

        if ( isset($this->request->post['isSubmited'])):

            $data['form']['field']['staff_id'] = ( isset($this->request->post['staff_id']) AND !empty($this->request->post['staff_id']) ) ? $this->request->post['staff_id'] : "";
            $data['form']['field']['adddate'] = ( isset($this->request->post['adddate']) AND !empty($this->request->post['adddate']) ) ? $this->request->post['adddate'] : "";
            $data['form']['field']['dob'] = ( isset($this->request->post['dob']) AND !empty($this->request->post['dob']) ) ? $this->request->post['dob'] : "";
            $data['form']['field']['name'] = ( isset($this->request->post['name']) AND !empty($this->request->post['name']) ) ? $this->request->post['name'] : "";
            $data['form']['field']['class'] = ( isset($this->request->post['class']) AND !empty($this->request->post['class']) ) ? $this->request->post['class'] : "";
            $data['form']['field']['gender'] = ( isset($this->request->post['gender']) AND !empty($this->request->post['gender']) ) ? $this->request->post['gender'] : "";
            $data['form']['field']['nic'] = ( isset($this->request->post['nic']) AND !empty($this->request->post['nic']) ) ? $this->request->post['nic'] : "";
            $data['form']['field']['staff_type'] = ( isset($this->request->post['staff_type']) AND !empty($this->request->post['staff_type']) ) ? $this->request->post['staff_type'] : "";
            $data['form']['field']['city'] = ( isset($this->request->post['city']) AND !empty($this->request->post['city']) ) ? $this->request->post['city'] : "";
            $data['form']['field']['district'] = ( isset($this->request->post['district']) AND !empty($this->request->post['district']) ) ? $this->request->post['district'] : "";
            $data['form']['field']['subject'] = ( isset($this->request->post['subject']) AND !empty($this->request->post['subject']) ) ? $this->request->post['subject'] : "";
            $data['form']['field']['religion'] = ( isset($this->request->post['religion']) AND !empty($this->request->post['religion']) ) ? $this->request->post['religion'] : "";

            // Eloquent OBJECT
            $staff = $this->model_staff->select('id', 'employee_number', 'type_id', 'admission_date', 'nic', 'full_name', 'initials', 'surname', 'dob', 'gender', 'email', 'phone_home' , 'phone_mobile', 'address', 'city', 'district_id', 'religion_id');

            // FILTER ( EMPLOYEE ID )
            if ( isset($this->request->post['staff_id']) AND !empty($this->request->post['staff_id']) ):
                $staff->where(function($query) {
                    $query->where('employee_number', '=', $this->request->post['staff_id']);
                });
            endif;

            // FILTER ( ADMISSION DATE )
            if ( isset($this->request->post['adddate']) AND !empty($this->request->post['adddate']) ):
                $staff->where(function($query) {
                    $query->where('admission_date', '=', $this->request->post['adddate']);
                });
            endif;

            // FILTER ( DATE OF BIRTH )
            if ( isset($this->request->post['dob']) AND !empty($this->request->post['dob']) ):
                $staff->where(function($query) {
                    $query->where('dob', '=', $this->request->post['dob']);
                });
            endif;

            // FILTER ( NAME )
            if ( isset($this->request->post['name']) AND !empty($this->request->post['name']) ):
                $staff->where(function($query) {
                    $query->where('full_name', 'LIKE', '%'.$this->request->post['name'].'%');
                });
            endif;

            // // FILTER ( CLASS )
            // if ( isset($this->request->post['class']) AND !empty($this->request->post['class']) ):
            //     $class = $this->model_class->select('staff_id')->where('id','=', $this->request->post['class'])->get();
            //     if ( $class != NULL):
            //         $classes = array();
            //         foreach ( $class as $key => $element ):
            //             array_push($classes,$element->staff_id);
            //         endforeach;
            //         $staff->where(function($query) use ($classes) {
            //             $query->whereIn('id', '=', $classes);
            //         });
            //     endif;
            // endif;

            // FILTER ( GENDER )
            if ( isset($this->request->post['gender']) AND !empty($this->request->post['gender']) ):
                $staff->where(function($query) {
                    $query->where('gender', '=', $this->request->post['gender']);
                });
            endif;

            // FILTER ( NIC )
            if ( isset($this->request->post['nic']) AND !empty($this->request->post['nic']) ):
                $staff->where(function($query) {
                    $query->where('nic', '=', $this->request->post['nic']);
                });
            endif;

            // FILTER ( STAFF TYPE )
            if ( isset($this->request->post['staff_type']) AND !empty($this->request->post['staff_type']) ):
                $staff->where(function($query) {
                    $query->where('type_id', '=', $this->request->post['staff_type']);
                });
            endif;

            // FILTER ( CITY )
            if ( isset($this->request->post['city']) AND !empty($this->request->post['city']) ):
                $staff->where(function($query) {
                    $query->where('city', '=', $this->request->post['city']);
                });
            endif;

            // FILTER ( DISTRICT )
            if ( isset($this->request->post['district']) AND !empty($this->request->post['district']) ):
                $staff->where(function($query) {
                    $query->where('district_id', '=', $this->request->post['district']);
                });
            endif;

            // // FILTER ( SUBJECT )
            // if ( isset($this->request->post['subject']) AND !empty($this->request->post['subject']) ):
            //     $staff->where(function($query) {
            //         $query->where('subject_id', '=', $this->request->post['subject']);
            //     });
            // endif;

            // FILTER ( RELIGION )
            if ( isset($this->request->post['religion']) AND !empty($this->request->post['religion']) ):
                $staff->where(function($query) {
                    $query->where('religion_id', '=', $this->request->post['religion']);
                });
            endif;

            // APPEND DATA TO ARRAY
            foreach( $staff->get() as $key => $value ):
                $data['staff']['details'][$key]['id'] = $value->employee_number;
                $data['staff']['details'][$key]['type'] = $value->type_id;
                $data['staff']['details'][$key]['gender'] = $value->gender;
                $data['staff']['details'][$key]['name'] = $value->full_name;

                echo "hi";
            endforeach;

        endif;

		// RENDER VIEW
        $this->load->view('staff/search', $data);
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

        // MODELS
        $this->load->model('staff');
        $this->load->model('staff/category');
        $this->load->model('staff/type');
        $this->load->model('class');
        $this->load->model('grade');
        $this->load->model('religion');
        $this->load->model('district');


        // STAFF CATEGORY
        foreach( $this->model_staff_category->select('id', 'name')->orderBy('name')->get() as $key => $element ):
            $data['staff_category'][$key]['id'] = $element->id;
            $data['staff_category'][$key]['name'] = $element->name;
        endforeach;

        // STAFF TYPE
        foreach( $this->model_staff_type->select('id', 'name', 'category_id')->orderBy('name')->get() as $key => $element ):
            $data['staff_type'][$key]['id'] = $element->id;
            $data['staff_type'][$key]['name'] = $element->name;
            $data['staff_type'][$key]['category']['id'] = $element->category_id;
        endforeach;

        // CLASS IN CHARGE
        foreach( $this->model_class->select('id', 'grade_id', 'staff_id', 'name')->get() as $key => $element ):
            $data['staff_class'][$key]['id'] = $element->id;
            $data['staff_class'][$key]['grade']['id'] = $element->grade_id;
            $data['staff_class'][$key]['staff']['id'] = $element->staff_id;
            $data['staff_class'][$key]['name'] = $element->name;

            $data['staff_class'][$key]['grade']['name'] = $this->model_grade->select('name')->where('id', '=', $element->grade_id)->first()->name;
        endforeach;

        //RELIGION
        foreach( $this->model_religion->select('id', 'name')->orderBy('name')->get() as $key => $element ):
            $data['staff_religion'][$key]['id'] = $element->id;
            $data['staff_religion'][$key]['name'] = $element->name;
        endforeach;

        //DISTRICT
        foreach( $this->model_district->select('id', 'province_id', 'name')->orderBy('name')->get() as $key => $element ):
            $data['staff_district'][$key]['id'] = $element->id;
            $data['staff_district'][$key]['province']['id'] = $element->province_id;
            $data['staff_district'][$key]['name'] = $element->name;
        endforeach;

		// RENDER VIEW
        $this->load->view('staff/add', $data);
        
    }

    public function ajax_retrive_province_by_district($id) {

        //CHECK LOGIN STATUS
		if( !isset($_SESSION['user']) OR $_SESSION['user']['is_login'] != true ):
			header( 'Location:' . $this->config->get('base_url') . '/logout' );
			exit();
		endif;

        // SET JSON HEADER
        header('Content-Type: application/json');

        // MODEL
        $this->load->model('district');
        $this->load->model('province');

        $province_id = $this->model_district->select('province_id')->where('id', '=', $id)->first()->province_id;


        echo json_encode(array( "status" => "success", "data" => $this->model_province->select('id', 'name')->where('id', '=', $province_id)->first() ));

    }
    
    public function ajax_add() {

        //CHECK LOGIN STATUS
		if( !isset($_SESSION['user']) OR $_SESSION['user']['is_login'] != true ):
			header( 'Location:' . $this->config->get('base_url') . '/logout' );
			exit();
		endif;

        /**
         * This method will receive ajax request from
         * the front end with the following payload
         *   - admission_date
         *   - employee_no
         *   - nic_no
         *   - category
         *   - type
         *   - class
         *   - subject_ids
         *   - fn
         *   - ini
         *   - sn
         *   - dob
         *   - rel_id
         *   - gen
         *   - email
         *   - landno
         *   - mobno
         *   - address
         *   - city
         *   - district
         * 
         * We need to validate the data and then perform
         * the following tasks.
         *    - validate
         *    - CRUD
         *    - response ( JSON )
         */

        // MODEL
        $this->load->model('staff');

        // SET JSON HEADER
        header('Content-Type: application/json');

        // VALIDATION : admission_date
        $is_valid_admission_date = GUMP::is_valid($this->request->post, array('admission_date' => 'required|date'));
        if ( $is_valid_admission_date !== true ):
            echo json_encode( array( "error" => "Please insert admission date" ), JSON_PRETTY_PRINT );
            exit();
        endif;

        // VALIDATION : employee_number
        $is_valid_employee_number = GUMP::is_valid($this->request->post, array('employee_number' => 'required|numeric|max_len,6'));
        if ( $is_valid_employee_number !== true ):
            echo json_encode( array( "error" => "Please insert emplyee number" ), JSON_PRETTY_PRINT );
            exit();
        endif;

        // employee_number IS ENTERED : CHECK FOR DUPLICATE
        if ( $this->model_staff->select('id')->where('employee_number', '=', $this->request->post['employee_number'])->first() != NULL ):
            echo json_encode( array( "error" => "Employee ID is already present" ), JSON_PRETTY_PRINT );
            exit();
        endif;

        // VALIDATION : nic_number
        $is_valid_nic_number = GUMP::is_valid($this->request->post, array('nic_number' => "required"));
        if ( $is_valid_nic_number === true ):
            if ( preg_match("/^([0-9]{9}[x|X|v|V]|[0-9]{12})$/", $this->request->post['nic_number']) == false ):
                echo json_encode( array( "error" => "Please insert a valid NIC number" ), JSON_PRETTY_PRINT );
                exit();
            endif;
        else:
            echo json_encode( array( "error" => "Please insert a NIC number" ), JSON_PRETTY_PRINT );
            exit();
        endif;

            // nic_number IS ENTERED : CHECK FOR DUPLICATE
            if ( $this->model_staff->select('id')->where('nic', '=', $this->request->post['nic_number'])->first() != NULL ):
                echo json_encode( array( "error" => "Employee NIC is already present" ), JSON_PRETTY_PRINT );
                exit();
            endif;

        // VALIDATION : category
        $is_valid_category = GUMP::is_valid($this->request->post, array('category' => 'required|numeric|max_len,2'));
        if ( $is_valid_category !== true ):
            echo json_encode( array( "error" => "Please select a valid staff category" ), JSON_PRETTY_PRINT );
            exit();
        endif;

        // VALIDATION : type
        $is_valid_type = GUMP::is_valid($this->request->post, array('type' => 'required|numeric|max_len,2'));
        if ( $is_valid_type !== true ):
            echo json_encode( array( "error" => "Please select a valid staff type" ), JSON_PRETTY_PRINT );
            exit();
        endif;

        // // VALIDATION : class
        // $is_valid_class = GUMP::is_valid($this->request->post, array('class' => 'numeric|max_len,3'));
        // if ( $is_valid_class !== true ):
        //     echo json_encode( array( "error" => $is_valid_class[0] ), JSON_PRETTY_PRINT );
        //     exit();
        // endif;

        // // VALIDATION : subjects
        // $is_valid_subjects = GUMP::is_valid($this->request->post, array('subjects' => 'numeric|max_len,3'));
        // if ( $is_valid_subjects !== true ):
        //     echo json_encode( array( "error" => $is_valid_subjects[0] ), JSON_PRETTY_PRINT );
        //     exit();
        // endif;

        // VALIDATION : full_name
        $is_valid_full_name = GUMP::is_valid($this->request->post, array('full_name' => 'required|valid_name|max_len,100'));
        if ( $is_valid_full_name !== true ):
            echo json_encode( array( "error" => "Please insert full name" ), JSON_PRETTY_PRINT );
            exit();
        endif;

        // VALIDATION : initials
        $is_valid_initials = GUMP::is_valid($this->request->post, array('initials' => 'required|alpha_space|max_len,20'));
        if ( $is_valid_initials !== true ):
            echo json_encode( array( "error" => "Please insert initials" ), JSON_PRETTY_PRINT );
            exit();
        endif;

        // VALIDATION : surname
        $is_valid_surname = GUMP::is_valid($this->request->post, array('surname' => 'required|valid_name|max_len,50'));
        if ( $is_valid_surname !== true ):
            echo json_encode( array( "error" => "Please insert surname" ), JSON_PRETTY_PRINT );
            exit();
        endif;

        // VALIDATION : date_of_birth
        $is_valid_date_of_birth = GUMP::is_valid($this->request->post, array('date_of_birth' => 'required|date'));
        if ( $is_valid_date_of_birth !== true ):
            echo json_encode( array( "error" => "Please insert date of birth" ), JSON_PRETTY_PRINT );
            exit();
        endif;

        // VALIDATION : religion
        $is_valid_religion = GUMP::is_valid($this->request->post, array('religion' => 'numeric|max_len,2'));
        if ( $is_valid_religion !== true AND $this->request->post['religion'] != "null" ):
            echo json_encode( array( "error" => "Please select a valid religion name" ), JSON_PRETTY_PRINT );
            exit();
        endif;

        // VALIDATION : gender
        $is_valid_gender = GUMP::is_valid($this->request->post, array('gender' => 'required|contains_list,Male;Female'));
        if ( $is_valid_gender !== true ):
            echo json_encode( array( "error" => "Please select a valid gender name" ), JSON_PRETTY_PRINT );
            exit();
        endif;

        // VALIDATION : email
        $is_valid_email = GUMP::is_valid($this->request->post, array('email' => 'valid_email'));
        if ( $is_valid_email !== true ):
            echo json_encode( array( "error" => "Please enter a valid email" ), JSON_PRETTY_PRINT );
            exit();
        endif;

            // email IS ENTERED : CHECK FOR DUPLICATE
            if ( $this->request->post['email'] !== ""):
                if ( $this->model_staff->select('id')->where('email', '=', $this->request->post['email'])->first() != NULL ):
                    echo json_encode( array( "error" => "This Employee Email is already present" ), JSON_PRETTY_PRINT );
                    exit();
                endif;
            endif;

        // VALIDATION : telephone
        $is_valid_telephone = GUMP::is_valid($this->request->post, array('telephone' => 'numeric|max_len,10'));
        if ( $is_valid_telephone !== true ):
            echo json_encode( array( "error" => "Please insert a valid 10 digit telephone number" ), JSON_PRETTY_PRINT );
            exit();
        endif;

        // VALIDATION : mobile_number
        $is_valid_mobile_number = GUMP::is_valid($this->request->post, array('mobile_number' => 'numeric|max_len,10'));
        if ( $is_valid_mobile_number !== true ):
            echo json_encode( array( "error" => "Please insert a valid 10 digit mobile number" ), JSON_PRETTY_PRINT );
            exit();
        endif;

        // VALIDATION : address
        $is_valid_address = GUMP::is_valid($this->request->post, array('address' => 'required|street_address|max_len,50'));
        if ( $is_valid_address !== true ):
            echo json_encode( array( "error" => "Please insert a valid address" ), JSON_PRETTY_PRINT );
            exit();
        endif;

        // VALIDATION : city
        $is_valid_city = GUMP::is_valid($this->request->post, array('city' => 'required|valid_name|max_len,20'));
        if ( $is_valid_city !== true ):
            echo json_encode( array( "error" => "Please insert a valid city" ), JSON_PRETTY_PRINT );
            exit();
        endif;

        // VALIDATION : DISTRICT
        $is_valid_district = GUMP::is_valid($this->request->post, array('district' => 'numeric|max_len,2'));
        if ( $is_valid_district !== true AND $this->request->post['district'] != "null" ):
            echo json_encode( array( "error" => "Please select a district" ), JSON_PRETTY_PRINT );
            exit();
        endif;

        //MODEL
        $this->load->model('staff');

        $this->model_staff->admission_date = $this->request->post['admission_date'];
        $this->model_staff->employee_number = $this->request->post['employee_number'];
        $this->model_staff->nic = $this->request->post['nic_number'];
        // $this->model_staff->category_id = $this->request->post['category'];
        $this->model_staff->type_id = $this->request->post['type'];
        // $this->model_staff->role_id = $this->request->post['class'];
        // $this->model_staff->role_id = $this->request->post['subjects'];
        $this->model_staff->full_name = $this->request->post['full_name'];
        $this->model_staff->initials = $this->request->post['initials'];
        $this->model_staff->surname = $this->request->post['surname'];
        $this->model_staff->dob = $this->request->post['date_of_birth'];
        $this->model_staff->religion_id = ( $this->request->post['religion'] == "null" )  ? null : $this->request->post['religion'];
        $this->model_staff->gender = $this->request->post['gender'];
        $this->model_staff->email = ( $this->request->post['email'] == "" )  ? null : $this->request->post['email'];
        $this->model_staff->phone_home = ( $this->request->post['telephone'] == "" )  ? null : $this->request->post['telephone'];
        $this->model_staff->phone_mobile = ( $this->request->post['mobile_number'] == "" )  ? null : $this->request->post['mobile_number'];
        $this->model_staff->address = $this->request->post['address'];
        $this->model_staff->city = $this->request->post['city'];
        $this->model_staff->district_id = ( $this->request->post['district'] == "null" )  ? null : $this->request->post['district'];

        // SUBMIT
        if ( $this->model_staff->save() ):
            echo json_encode( array( "status" => "success" ), JSON_PRETTY_PRINT );
        else:
            echo json_encode( array( "status" => "failed" ), JSON_PRETTY_PRINT );
        endif;
    }

    public function profile() {

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

        // RENDER VIEW
        $this->load->view('staff/profile', $data);
    }
}
?>