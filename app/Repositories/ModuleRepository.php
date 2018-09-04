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
         * @param $allPurchasedModules
         * @param $allCompletedModules
         *
         * @return mixed
         */
        public function getNextIncomplete($allPurchasedModules, $allCompletedModules)
        {
            // TODO - determine next module
            // If no modules are completed it should attach first tag in order.
            // In case any of first course modules are completed then it should attach next uncompleted module
            //  - after the last completed of the first course. (e.g.. M1, M2 & M4 are completed, then attach M5 tag).
            // If all (or last) first course modules are completed - attach next uncompleted module after the last completed of the second course. Same applies in case of a third course.
            // If all (or last) modules of all courses are completed - attach “Module reminders completed” tag.
        }
    }