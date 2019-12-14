<?php

// EXTEND ( ELOQUENT MODEL )
use Illuminate\Database\Eloquent\Model as EloquentModel;
use Illuminate\Database\Eloquent\SoftDeletes;

class Message_Model extends EloquentModel {

	const CREATED_AT = 'created_on';
	const UPDATED_AT = 'updated_on';
	const DELETED_AT = 'deleted_on';
	use SoftDeletes;

	// PARENT PROPERTIES
	protected $table = 'message';
	protected $fillable = [ 'sender_id', 'sender_type', 'receiver_id', 'receiver_type', 'body' ];
}

?>