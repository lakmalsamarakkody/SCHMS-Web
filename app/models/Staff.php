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
	protected $fillable = [ 'id', 'employee_number', 'nic', 'admission_date', 'type_id', 'full_name', 'initials', 'surname', 'dob', 'gender', 'email', 'phone_home', 'phone_mobile', 'address', 'city', 'district_id', 'religion_id'];

}

?>