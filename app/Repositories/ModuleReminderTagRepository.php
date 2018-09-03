<?php
    
    namespace App\Repositories;
    
    use App\Interfaces\ModuleReminderTagRepositoryInterface;
    use App\Models\ModuleReminderTag;
    
    
    class ModuleReminderTagRepository implements ModuleReminderTagRepositoryInterface
    {
        
        /**
         * @return ModuleReminderTag[]|\Illuminate\Database\Eloquent\Collection|mixed
         */
        public function getNext($email)
        {
            //
        }
        
        /**
         * Get all module reminder tags
         *
         * @return ModuleReminderTag[]|\Illuminate\Database\Eloquent\Collection|mixed
         */
        public function getAll()
        {
            
            return ModuleReminderTag::all();
        }
        
        /**
         * Create or update module reminder tags
         * @return bool|mixed
         */
        public function createOrUpdate()
        {
            
            $module_reminder_tags = UserCRMRepository::getAllTags();
            foreach ($module_reminder_tags as $module_reminder_tag) {
                ModuleReminderTag::updateOrCreate($module_reminder_tags);
            }
            
            return true;
        }
        
        
    }
