<?php

use Carbon\Carbon;
use Illuminate\Database\Capsule\Manager as DB;

class Permission extends Controller {
	public function ajax_add_or_remove_permission_to_role() {

        // SET JSON HEADER
        header('Content-Type: application/json');

        // VALIDATE IF POST PARAMS SET
        $validate = GUMP::is_valid($this->request->post, ['role_id' => 'required', 'permission_id' => 'required']);

        if ( $validate !== true ){
            echo json_encode(array('status' => 'error', 'error' => 'Invalid data'), JSON_PRETTY_PRINT);
            return;
        }
        
        // MODELS
        $this->load->model('user/role');
        $this->load->model('user/permission');
        $this->load->model('user/rolepermission');
        $this->load->model('user');

		// PERMISSION
        if ( !$this->model_user->find($_SESSION['user']['id'])->hasPermission('user-permission-view-edit') ):
            echo json_encode( array( "status" => "error", "error" => "Permission denied" ), JSON_PRETTY_PRINT );
            exit();
        endif;

        // CHECK IF ROLE EXISTS
        $role = $this->model_user_role->find($this->request->post['role_id']);
        $permission = $this->model_user_permission->find( $this->request->post['permission_id']);
        
        if ( $role == NULL OR $permission == NULL ):
            echo json_encode(array('status' => 'error', 'error' => 'Invalid data'), JSON_PRETTY_PRINT);
            return;
        endif;

        if ( $this->model_user_rolepermission->roleHasPermission($role->id, $permission->id) ):
            $this->removePermissionFromRole($role, $permission);
        else:
            $this->addPermissionToRole($role, $permission);
        endif;

        return;
        echo json_encode(array('status' => 'error', 'data' => $this->model_user_rolepermission->roleHasPermission($role->id, $permission->id) ), JSON_PRETTY_PRINT);
        return;

    }

    protected function removePermissionFromRole($role, $permission){

        $this->load->model('user/rolepermission');
        $rolePermission = $this->model_user_rolepermission->where('role_id', $role->id)->where('permission_id', $permission->id)->first();
        $rolePermission->delete();

        echo json_encode(array("status" => "success"), JSON_PRETTY_PRINT);
        return;

    }

    protected function addPermissionToRole($role, $permission){

        $this->load->model('user/rolepermission');
        $rolePermission = $this->model_user_rolepermission->create(['role_id' => $role->id, 'permission_id' => $permission->id]);
        if ( $rolePermission->exists ):
            echo json_encode(array("status" => "success"), JSON_PRETTY_PRINT);
            return;
        else:
            echo json_encode(array("status" => "error"), JSON_PRETTY_PRINT);
            return;
        endif;

    }
}