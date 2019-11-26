<?php

// EXTEND ( ELOQUENT MODEL )
use Illuminate\Database\Eloquent\Model as EloquentModel;
use Illuminate\Database\Eloquent\SoftDeletes;

class Religion_Model extends EloquentModel {

	const CREATED_AT = 'created_on';
	const UPDATED_AT = 'updated_on';
    const DELETED_AT = 'deleted_on';
    
    use SoftDeletes;

	// PARENT PROPERTIES
	protected $table = 'report';
	protected $fillable = [ 'id', 'type', 'file_name', 'generated_by', 'generated_at' ];

}

?>