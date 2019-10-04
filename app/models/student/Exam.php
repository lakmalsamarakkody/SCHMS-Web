<?php

// MODELS
require_once ABS_PATH.'/app/models/Student.php';

// EXTEND ( ELOQUENT MODEL )
use Illuminate\Database\Eloquent\Model as EloquentModel;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * relational model
 */
class StudentExam_Model extends EloquentModel {

	const CREATED_AT = 'created_on';
	const UPDATED_AT = 'updated_on';
	const DELETED_AT = 'deleted_on';

	// PARENT PROPERTIES
	protected $table = 'student_has_exam_schedule';
	protected $fillable = [ 'id', 'student_id', 'exam_schedule_id', 'marks' ];

	// RELATION
	public function student() {
		return $this->hasOne(Student_Model::class, 'id', 'student_id');
	}
}

?>