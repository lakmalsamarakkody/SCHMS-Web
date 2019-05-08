<?php

// EXTEND ( ELOQUENT MODEL )
use Illuminate\Database\Eloquent\Model as EloquentModel;

class Example_Model extends EloquentModel {

	// PARENT PROPERTIES
	protected $table = 'example';
	protected $fillable = [ 'id', 'email', 'password_hash' ];
	protected $dateFormat = 'U';

}

?>