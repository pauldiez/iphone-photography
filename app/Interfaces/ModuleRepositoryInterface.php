<?php
    
    namespace App\Interfaces;
    
    use App\Models\User;

    interface ModuleRepositoryInterface
    {
        
        /**
         * Get modules completed by user
         *
         * @param $user
         *
         * @return mixed
         */
        public function getCompletedByUser(User $user);
        
        /**
         * Get all modules
         *
         * @param array $courses
         *
         * @return mixed
         */
        public function getAllByCourse(array $courseKeys);
        
        /**
         * Get next incomplete module
         *
         * @param $purchasedModules
         * @param $completedModules
         *
         * @return mixed
         */
        public function getNextIncomplete($purchasedModules, $completedModules);
    }