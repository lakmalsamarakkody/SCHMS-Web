<?php

// EXTEND ( ELOQUENT MODEL )
use Illuminate\Database\Eloquent\Model as EloquentModel;

class Grade_Model extends EloquentModel {

	const CREATED_AT = 'created_on';
	const UPDATED_AT = 'updated_on';

	// PARENT PROPERTIES
	protected $table = 'grade';
	protected $fillable = [ 'id', 'name'];

}

?>