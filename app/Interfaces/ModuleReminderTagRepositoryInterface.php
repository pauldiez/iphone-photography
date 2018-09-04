<?php
    
    namespace App\Interfaces;
    
    interface ModuleReminderTagRepositoryInterface
    {
        
        /**
         * Get next module reminder tag
         *
         * @param string $courseKey
         * @param int    $moduleNumber
         *
         * @return mixed
         */
        public function getByModule(string $courseKey, int $moduleNumber);
        
        /**
         * Get all module reminder tags
         *
         * @return mixed
         */
        public function getAll();
        
        /**
         * Create or update module reminder tags
         *
         * @return mixed
         */
        public function createOrUpdate();
    }