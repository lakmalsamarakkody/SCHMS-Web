<?php

// EXTEND ( ELOQUENT MODEL )
use Illuminate\Database\Eloquent\Model as EloquentModel;

class StaffType_Model extends EloquentModel {

	const CREATED_AT = 'created_on';
	const UPDATED_AT = 'updated_on';

	// PARENT PROPERTIES
	protected $table = 'staff_type';
	protected $fillable = [ 'id', 'name', 'category_id' ];
}

?>