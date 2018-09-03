<?php
    
    namespace App\Interfaces;
    
    interface UserCRMRepositoryInterface
    {
        
        /**
         * Get CRM user by email
         *
         * @param $email
         *
         * @return mixed
         */
        public function getByEmail($email);
        
        /**
         * Get CRM user tags
         *
         * @return mixed
         */
        public function getAllTags();
        
        
        /**
         * Add CRM user tag
         *
         * @return mixed
         */
        public function addTag($user, $tag);
        
        
        /**
         * Get CRM user courses
         *
         * @return mixed
         */
        public function getPurchasedCourses($crmUser);
        
    }