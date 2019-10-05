<?php

// EXTEND ( ELOQUENT MODEL )
use Illuminate\Database\Eloquent\Model as EloquentModel;

class Coach_Model extends EloquentModel {

	const CREATED_AT = 'created_on';
	const UPDATED_AT = 'updated_on';
	const DELETED_AT = 'deleted_on';

	// PARENT PROPERTIES
	protected $table = 'coach';
	protected $fillable = [ 'id', 'full_name', 'initials', 'surname', 'nic', 'dob', 'gender', 'email', 'phone_home', 'phone_mobile', 'address', 'city' ];
}

?>