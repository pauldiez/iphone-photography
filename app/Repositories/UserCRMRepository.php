<?php
    
    namespace App\Repositories;
    
    use App\Http\Helpers\InfusionsoftHelper;
    use App\Interfaces\UserCRMRepositoryInterface;
    
    class UserCRMRepository implements UserCRMRepositoryInterface
    {
        
        /**
         * @var CRM API object
         */
        public $crmAPI;
        
        
        public function __construct(InfusionsoftHelper $infusionSoftHelper)
        {
            
            $this->crmApi = $infusionSoftHelper;
        }
        
        /**
         * Get user by CRM user email
         *
         * @param $email
         *
         * @return mixed
         */
        public function getByEmail($email)
        {
            
            $account = $this->crmApi->getContact($email);
            
            return $account;
        }
        
        /**
         * Get all CRM tags
         *
         * @param $email
         *
         * @return mixed
         */
        public function getAllTags()
        {
            
            return $this->crmApi->getAllTags()->toArray();
        }
        
        /**
         * Add module reminder tag to CRM users account
         *
         * @param $user
         * @param $tag
         *
         * @return bool|mixed
         */
        public function addTag($user, $tag)
        {
            
            return $this->crmApi->addTag($user['Id'], $tag->id);
        }
        
        
        /**
         *  Get CRM user courses
         *
         * @param $user
         *
         * @return array|mixed
         */
        public function getPurchasedCourses($crmUser)
        {
            
            $courses = explode(',', $crmUser['_Products']);
            
            return $courses;
        }
    }
