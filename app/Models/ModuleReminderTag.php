<?php
	
	namespace App\Models;
	
	use Illuminate\Database\Eloquent\Model;
	
	class ModuleReminderTag extends Model
	{
		
		protected $table = 'module_reminder_tags';
		
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