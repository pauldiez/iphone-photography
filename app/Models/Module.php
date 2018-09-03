<?php
	
	namespace App\Models;
	
	use Illuminate\Database\Eloquent\Model;
	
	class Module extends Model
	{
		
		// table name
		protected $table = 'modules';
		
		/**
		 * The attributes that are mass assignable.
		 *
		 * @var array
		 */
		protected $fillable = [
			'id',
			'course_key',
			'name'
		];
	}
