<?php
    
    namespace App\Repositories;
    
    
    use App\Interfaces\ModuleRepositoryInterface;
    use App\Models\Course;
    use App\Models\User;
    
    class ModuleRepository implements ModuleRepositoryInterface
    {
        
        /**
         * Get modules completed by user
         *
         * @param $user
         *
         * @return mixed
         */
        public function getCompletedByUser(User $user)
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
         * Get all modules
         *
         * @param array $courseKeys
         *
         * @return array|mixed
         */
        public function getAllByCourse(array $courseKeys = [])
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
         * Get next incomplete module
         *
         * @param $modulesByCourse
         * @param $completedModules
         *
         * @return mixed
         */
        public function getNextIncomplete(array $modulesByCourse, array $completedModules)
        {
            
            // TODO - determine next module
            // X If no modules are completed it should attach first tag in order.
            // X In case any of first course modules are completed then it should attach next uncompleted module
            //  - after the last completed of the first course. (e.g.. M1, M2 & M4 are completed, then attach M5 tag).
            // X If all (or last) first course modules are completed - attach next uncompleted module after the last
            //  - completed of the second course. Same applies in case of a third course.
            // X If all (or last) modules of all courses are completed - attach “Module reminders completed” tag.
            
            
            // if no modules are completed it should attach first tag in order.
            if (empty($completedModules)) {
                $firstCourse   = array_keys($modulesByCourse)[0];
                $firstModule   = min($modulesByCourse[$firstCourse]);
                $nextModuleTag = [$firstCourse, $firstModule];
                
                return $nextModuleTag;
            }
            
            // loop through each course
            $courseKeys = array_keys($modulesByCourse);
            foreach ($courseKeys as $courseKey) {
                
                // determine uncompleted modules
                $uncompletedCourseModules = array_diff($modulesByCourse[$courseKey],
                    $completedModules[$courseKey]);
                
                // if all course modules are completed, skip to next course modules
                if (count($uncompletedCourseModules) == Course::$MODULES_PER_COURSE
                    || empty($uncompletedCourseModules)) {
                    continue;
                }
                
                // find the next uncompleted course module after the last highest complete module
                $maxCompletedModule = max($completedModules[$courseKey]);
                foreach ($uncompletedCourseModules as $index => $uncompletedCourseModule) {
                    if ($uncompletedCourseModule > $maxCompletedModule) {
                        return [$courseKey, $uncompletedCourseModule];
                    }
                }
            }
            
            return [];
        }
        
        
    }