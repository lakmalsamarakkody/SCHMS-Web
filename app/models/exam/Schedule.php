<?php

// EXTEND ( ELOQUENT MODEL )
use Illuminate\Database\Eloquent\Model as EloquentModel;

class ExamSchedule_Model extends EloquentModel {

	const CREATED_AT = 'created_on';
	const UPDATED_AT = 'updated_on';
	const DELETED_AT = 'deleted_on';

	// PARENT PROPERTIES
	protected $table = 'exam_grade_has_schedule';
	protected $fillable = [ 'id', 'exam_grade_id', 'subject_id', 'date', 'start_time', 'end_time', 'venue', 'instructions' ];
}

?>