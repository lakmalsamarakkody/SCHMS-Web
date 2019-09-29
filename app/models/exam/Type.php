<?php

// EXTEND ( ELOQUENT MODEL )
use Illuminate\Database\Eloquent\Model as EloquentModel;
use Illuminate\Database\Eloquent\SoftDeletes;

class ExamType_Model extends EloquentModel {
	use SoftDeletes;
	const CREATED_AT = 'created_on';
	const UPDATED_AT = 'updated_on';
	const DELETED_AT = 'deleted_on';

	// PARENT PROPERTIES
	protected $table = 'exam_type';
	protected $fillable = [ 'id', 'name' ];
}

?>