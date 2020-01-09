<?php

// EXTEND ( ELOQUENT MODEL )
use Illuminate\Database\Eloquent\Model as EloquentModel;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Capsule\Manager as DB;

class User_Model extends EloquentModel {

	const CREATED_AT = 'created_on';
	const UPDATED_AT = 'updated_on';
	const DELETED_AT = 'deleted_on';

	// PARENT PROPERTIES
	protected $table = 'user';
	protected $fillable = [ 'id', 'staff_id', 'username', 'password', 'email', 'role_id', 'status' ];

	// CHECK IF USER HAS SOME PERMISSION
	public function hasPermission($permission) {

		$permission = DB::table('user_permission')->where('name', $permission)->first();

		if ( $permission !== NULL ):
			if ( DB::table('user_role_has_permission')->where('role_id', $this->role_id)->where('permission_id', $permission->id)->first() !== NULL ):
				return true;
			else:
				return false;
			endif;
		else:
			return false;
		endif;
	}


	public function redirectIfNotPermitted($permission){

		if ( !$this->hasPermission($permission) ):
			
			header( 'Location:' . '/logout' );
			exit();

		endif;
		
	}

}

?>