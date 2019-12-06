<?php

use Carbon\Carbon;

class Api extends Controller {

    /**
     * We only need to authenticate staff users to
     * this endpoint. When agent hit this location we
     * first validate the data and then preform a login
     * flow
     *     - validate
     *     - login
     */
    public function auth() {

        // SET JSON HEADER
        header('Content-Type: application/json');

        // MODELS
        $this->load->model('user');

        // VALIDATE
        $validate = GUMP::is_valid($this->request->post, ['username' => 'required', 'password' => 'required']);
        if ( $validate !== true ):
            echo json_encode(array("status" => "failed", "error" => array("message" => "validation failed")), JSON_PRETTY_PRINT);
            exit();
        endif;

        // AUTH
        $user = $this->model_user::where('username', $this->request->post['username'])->where('user_type', '=', 'staff')->first();
        if( $user != null ):
            if( password_verify($this->request->post['password'], $user->password) ):
                echo json_encode(array("status" => "success"), JSON_PRETTY_PRINT);
                exit();
            else:
                echo json_encode(array("status" => "failed", "error" => array("message" => "authentication failed")), JSON_PRETTY_PRINT);
                exit();
            endif;
        else:
            echo json_encode(array("status" => "failed", "error" => array("message" => "account not found")), JSON_PRETTY_PRINT);
            exit();
        endif;

    }



    /**
     * This endpoint gives the ability to mark attendance from
     * external sources such as android apps for pre authenticated
     * clients using the API auth method.
     */
    public function attendance($action) {

        // SET JSON HEADER
        header('Content-Type: application/json');

        // CHECK IF THE USER HAS PERMISSION TO ADD ATTENDANCE FIRST

        /**
         * External applications can mark attendnace of students
         * using this API action.
         */
        if ( $action == 'mark' ):

            // MODELS
            $this->load->model('student/attendance');
            $this->load->model('staff/attendance');

            if ( $this->request->post['type'] === 'student' ):

                // VALIDATE
                // $this->request->post['id']

                // MARK ATTENDANCE
                $this->model_student_attendance->student_id = $this->request->post['id'];
                $this->model_student_attendance->date = Carbon::now()->format('Y-m-d');
                if ( $this->model_student_attendance->save() ):
                    echo json_encode(array("status" => "success"), JSON_PRETTY_PRINT);
                    exit();
                else:
                    echo json_encode(array("status" => "failed", "error" => array("message" => "can't update attendance")), JSON_PRETTY_PRINT);
                    exit();
                endif;

            elseif ( $this->request->post['type'] === 'staff' ):

                // VALIDATE
                // $this->request->post['id']

                // MARK ATTENDANCE
                $this->model_staff_attendance->staff_id = $this->request->post['id'];
                $this->model_staff_attendance->date = Carbon::now()->format('Y-m-d');
                if ( $this->model_staff_attendance->save() ):
                    echo json_encode(array("status" => "success"), JSON_PRETTY_PRINT);
                    exit();
                else:
                    echo json_encode(array("status" => "failed", "error" => array("message" => "can't update attendance")), JSON_PRETTY_PRINT);
                    exit();
                endif;

            else:
                echo json_encode(array("status" => "failed", "error" => array("message" => "invalid user type")), JSON_PRETTY_PRINT);
                exit();
            endif;

        else:
            echo json_encode(array("status" => "failed", "error" => array("message" => "invalid api action")), JSON_PRETTY_PRINT);
            exit();
        endif;
    }



    /**
     * This API endpoint provide details about the specified
     * student or staff user to external sources such as
     * android apps etc.
     */
    public function details() {

        // SET JSON HEADER
        header('Content-Type: application/json');

        if ( $this->request->post['type'] === 'student' ):

            // MODEL
            $this->load->model('student');
            $this->load->model('district');
            $this->load->model('province');
            $this->load->model('religion');

            // QUERY
            $student = $this->model_student::find($this->request->post['id']);
            $district = $this->model_district::find($student->district_id);
            $province = $this->model_province::find($district->province_id);
            $religion = $this->model_religion::find($student->religion_id);

            $data = array(
                'id'        => $student->id,
                'admission' => array(
                    'no'    => $student->admission_no,
                    'date'  => $student->admission_date
                ),
                'name'      => array(
                    'initials'  => $student->initials,
                    'surname'   => $student->surname,
                    'full'      => $student->full_name,
                ),
                'dob'       => $student->dob,
                'gender'    => $student->gender,
                'religion'  => $religion->name,
                'email'     => $student->email,
                'phone'     => array(
                    'mobile'    => $student->phone_mobile
                ),
                'address'   => array(
                    'address'   => $student->address,
                    'city'      => $student->city,
                    'district'  => $district->name,
                    'province'  => $province->name
                )
            );

            // JSON
            echo json_encode(array("status" => "success", "data" => $data), JSON_PRETTY_PRINT);
            exit();

        elseif ( $this->request->post['type'] === 'staff' ):
        else:
            echo json_encode(array("status" => "failed", "error" => array("message" => "invalid user type")), JSON_PRETTY_PRINT);
            exit();
        endif;

    }
}

?>