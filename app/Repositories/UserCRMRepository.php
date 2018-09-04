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
         * @param $crmUser
         * @param $tagId
         *
         * @return bool|mixed
         */
        public function addTag($crmUser, $tagId)
        {
            
            return $this->crmApi->addTag($crmUser['Id'], $tagId);
        }
        
        
        /**
         *  Get CRM user courses
         *
         * @param $crmUser
         *
         * @return array|mixed
         */
        public function getPurchasedCourses($crmUser)
        {
            
            $courses = explode(',', $crmUser['_Products']);
            
            return $courses;
        }
    }
