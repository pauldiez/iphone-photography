<?php
	
	namespace App\Models;
	
	use Illuminate\Database\Eloquent\Model;
	
	class ModuleTag extends Model
	{
		
		protected $table = 'module_tags';
		
		/**
		 * The attributes that are mass assignable.
		 *
		 * @var array
		 */
		protected $fillable = [
			'id',
			'name',
			'description',
			'category'
		];
	}