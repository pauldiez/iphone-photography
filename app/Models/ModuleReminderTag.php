<?php
    
    namespace App\Models;
    
    use Illuminate\Database\Eloquent\Model;

    class ModuleReminderTag extends Model
    {
        
        protected $table = 'module_reminder_tags';
    
        public static $COURSES_STATUS_COMPLETED = 'completed';
        
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
        
        /**
         * Get next module reminder tag
         *
         * @param string $courseKey
         * @param        $moduleNumber
         *
         * @return mixed|void
         */
        public static function getByCourseAndModule(string $courseKey, $moduleNumber)
        {
            
            // if course is completed, return completed module reminder tag
            if ($courseKey == ModuleReminderTag::$COURSES_STATUS_COMPLETED) {
                $moduleReminderTag = ModuleReminderTag::where('name', 'like', '%completed%')->first();
            } else {
                $likeSearchTerm    = "%{$courseKey} module {$moduleNumber}%";
                $moduleReminderTag = ModuleReminderTag::where('name', 'like', $likeSearchTerm)->first();
            }
            
            return $moduleReminderTag;
            
        }
    }