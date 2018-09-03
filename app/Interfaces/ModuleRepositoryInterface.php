<?php
    
    namespace App\Interfaces;
    
    interface ModuleRepositoryInterface
    {
        
        /**
         * Get next module reminder tag
         *
         * @param $user
         *
         * @return mixed
         */
        public function get($email);
        
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