<?php

// EXTEND ( ELOQUENT MODEL )
use Illuminate\Database\Eloquent\Model as EloquentModel;

class Class_Model extends EloquentModel {

	const CREATED_AT = 'created_on';
	const UPDATED_AT = 'updated_on';

	// PARENT PROPERTIES
	protected $table = 'class';
	protected $fillable = [ 'id', 'grade_id', 'staff_id', 'name' ];
}

?>