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
            'name',
            'number'
        ];
        
        /**
         * Get all modules by course
         *
         * @param array $courseKeys
         *
         * @return array|mixed
         */
        public static function getAllByCourse(array $courseKeys = [])
        {
            
            // if no course keys are submitted, assign all course keys
            if (empty($courseKeys)) {
                $courseKeys = Course::getAllKeys();
            }
            
            // loop through each course
            $allModulesByCourse = [];
            foreach ($courseKeys as $courseKey) {
                
                // loop through each module per course and
                $courseModules = [];
                for ($i = 1; $i <= Course::$MODULES_PER_COURSE; $i++) {
                    
                    // add course module
                    array_push($courseModules, $i);
                }
                
                // add course modules
                $allModulesByCourse[$courseKey] = $courseModules;
            }
            
            return $allModulesByCourse;
            
        }
        
        /**
         * Get modules completed by user
         *
         * @param $user
         *
         * @return mixed
         */
        public static function getCompletedByUser(User $user)
        {
            
            $completedModules = $user->completed_modules()->get();
            
            // loop through completed modules
            $completedModulesByCourse = [];
            foreach ($completedModules as $moduleCompleted) {
                $courseKey    = $moduleCompleted->course_key;
                $courseNumber = $moduleCompleted->number;
                
                // assign each model by course
                $completedModulesByCourse[$courseKey][] = $courseNumber;
            }
            
            return $completedModulesByCourse;
        }
        
        
        /**
         * Get next incomplete module
         *
         * @param $modulesByCourse
         * @param $completedModulesByCourse
         *
         * @return mixed
         */
        public static function getNextIncomplete(array $modulesByCourse, array $completedModulesByCourse)
        {
            
            // if no modules are completed
            if (empty($completedModulesByCourse)) {
                $firstCourse = array_keys($modulesByCourse)[0];
                $firstModule = min($modulesByCourse[$firstCourse]);
                
                // return first course module
                return [$firstCourse, $firstModule];
            }
            
            // loop through each course
            $courseKeys = array_keys($modulesByCourse);
            foreach ($courseKeys as $courseKey) {
                
                // determine uncompleted modules
                $uncompletedCourseModules = array_diff($modulesByCourse[$courseKey],
                    $completedModulesByCourse[$courseKey]);
                
                // if all course modules are completed, skip to next course modules
                if (self::isCourseCompleted($uncompletedCourseModules)) {
                    continue;
                }
                
                // find the next uncompleted course module after the last highest complete module
                $maxCompletedModule = max($completedModulesByCourse[$courseKey]);
                foreach ($uncompletedCourseModules as $index => $uncompletedCourseModule) {
                    if ($uncompletedCourseModule > $maxCompletedModule) {
                        
                        // return the next uncompleted course module
                        return [$courseKey, $uncompletedCourseModule];
                    }
                }
            }
            
            // otherwise return course as completed
            return [ModuleReminderTag::$COURSES_STATUS_COMPLETED, null];
        }
        
        
        /**
         * Determine if all course modules are completed, skip to next course modules
         *
         * @param $uncompletedCourseModules
         *
         * @return bool
         */
        private static function isCourseCompleted($uncompletedCourseModules)
        {
            
            if (count($uncompletedCourseModules) == Course::$MODULES_PER_COURSE
                || empty($uncompletedCourseModules)) {
                return true;
            } else {
                return false;
            }
        }
    }
