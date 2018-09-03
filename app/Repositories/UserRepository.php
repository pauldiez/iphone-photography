<?php
    
    namespace App\Repositories;
    
    use App\Interfaces\UserRepositoryInterface;
    use App\Models\User;
    
    class UserRepository implements UserRepositoryInterface
    {
        
        /**
         * Get User by email
         *
         * @param $email
         *
         * @return mixed
         */
        public function getByEmail($email)
        {
            
            return User::where('email', $email)->first();
        }
        
    }
