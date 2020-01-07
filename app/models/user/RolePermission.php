<?php

// EXTEND ( ELOQUENT MODEL )
use Illuminate\Database\Eloquent\Model as EloquentModel;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Capsule\Manager as DB;

class UserRolePermission_Model extends EloquentModel {

	const CREATED_AT = 'created_on';
	const UPDATED_AT = 'updated_on';
	const DELETED_AT = 'deleted_on';

	// PARENT PROPERTIES
	protected $table = 'user_role_has_permission';
	protected $fillable = [ 'id', 'role_id', 'permission_id' ];

	public function roleHasPermission( $role_id, $permission_id ){

		$roleHasPermission = DB::table('user_role_has_permission')->where('role_id', $role_id)->where('permission_id', $permission_id)->first();

		if ( $roleHasPermission != NULL ):
			return true;
		else:
			return false;
		endif;

	}
}

?>