<?php

// EXTEND ( ELOQUENT MODEL )
use Illuminate\Database\Eloquent\Model as EloquentModel;

class User_Model extends EloquentModel {

	const CREATED_AT = 'created_on';
	const UPDATED_AT = 'updated_on';

	// PARENT PROPERTIES
	protected $table = 'user';
	protected $fillable = [ 'id', 'stu_staff_parent_id', 'nic', 'username', 'password', 'email', 'role_id', 'status' ];

}

?>