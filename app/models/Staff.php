<?php

// EXTEND ( ELOQUENT MODEL )
use Illuminate\Database\Eloquent\Model as EloquentModel;
use Illuminate\Database\Eloquent\SoftDeletes;

class Staff_Model extends EloquentModel {

	const CREATED_AT = 'created_on';
	const UPDATED_AT = 'updated_on';
	const DELETED_AT = 'deleted_on';

	// PARENT PROPERTIES
	protected $table = 'staff';
	protected $fillable = [ 'id', 'staff_id', 'nic', 'admission_date', 'type_id', 'position', 'full_name', 'initials', 'surname', 'dob', 'gender', 'email', 'phone_home', 'phone_mobile', 'address', 'street', 'city', 'district_id', 'religion_id', 'health_id'];

}

?>