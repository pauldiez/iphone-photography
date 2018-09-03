<?php
    
    namespace App\Interfaces;
    
    interface ModuleReminderTagRepositoryInterface
    {
        
        /**
         * Get next module reminder tag
         *
         * @param $user
         *
         * @return mixed
         */
        public function getNext($email);
        
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