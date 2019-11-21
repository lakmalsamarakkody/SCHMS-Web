<?php

// EXTEND ( ELOQUENT MODEL )
use Illuminate\Database\Eloquent\Model as EloquentModel;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * relational model
 */
class StudentHealth_Model extends EloquentModel {

	const CREATED_AT = 'created_on';
	const UPDATED_AT = 'updated_on';
	const DELETED_AT = 'deleted_on';

	// PARENT PROPERTIES
	protected $table = 'student_health';
	protected $fillable = [ 'id', 'student_id', 'heart_rate', 'blood_pressure', 'height', 'weight', 'vaccination', 'speciality', 'date' ];
}

?>