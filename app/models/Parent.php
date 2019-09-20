<?php

// EXTEND ( ELOQUENT MODEL )
use Illuminate\Database\Eloquent\Model as EloquentModel;
use Illuminate\Database\Eloquent\SoftDeletes;

class Parent_Model extends EloquentModel {

	use SoftDeletes;
	const CREATED_AT = 'created_on';
	const UPDATED_AT = 'updated_on';
	const DELETED_AT = 'deleted_on';

	// PARENT PROPERTIES
	protected $table = 'parent';
	protected $fillable = [ 'id', 'nic', 'relation_type_id', 'full_name', 'initials', 'surname', 'dob', 'gender', 'email', 'phone_home', 'phone_mobile', 'occupation', 'position', 'income', 'address', 'city' ];

}

?>