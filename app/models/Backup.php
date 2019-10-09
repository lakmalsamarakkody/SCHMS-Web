<?php

// EXTEND ( ELOQUENT MODEL )
use Illuminate\Database\Eloquent\Model as EloquentModel;
use Illuminate\Database\Eloquent\SoftDeletes;

class Backup_Model extends EloquentModel {

	const CREATED_AT = 'created_on';
	const UPDATED_AT = 'updated_on';
	const DELETED_AT = 'deleted_on';
	use SoftDeletes;

	// PARENT PROPERTIES
	protected $table = 'backup';
	protected $fillable = [ 'id', 'name', 'description', 'date_time', 'file_size' ];
}

?>