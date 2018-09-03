<?php
    
    namespace App\Interfaces;
    
    interface UserRepositoryInterface
    {
        
        /**
         * Get user by Email
         *
         * @param $email
         *
         * @return mixed
         */
        public function getByEmail($email);
        
    }