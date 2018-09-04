<?php
    
    namespace App\Repositories;
    
    use App\Interfaces\ModuleReminderTagRepositoryInterface;
    use App\Models\ModuleReminderTag;
    
    
    class ModuleReminderTagRepository implements ModuleReminderTagRepositoryInterface
    {
        
        /**
         * Get next module reminder tag
         *
         * @param string $courseKey
         * @param int    $moduleNumber
         *
         * @return mixed|void
         */
        public function getByModule(string $courseKey, int $moduleNumber)
        {
            
            $likeSearchTerm    = "%{$courseKey} module {$moduleNumber}%";
            $moduleReminderTag = ModuleReminderTag::where('name', 'like', $likeSearchTerm)->first();
            
            // if not results then fetch for completed tag
            if (!$moduleReminderTag) {
                $moduleReminderTag = ModuleReminderTag::where('name', 'like', '%completed%')->first()
                    ->first();
            }
            
            return $moduleReminderTag;
            
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
         *
         * @return bool|mixed
         */
        public function createOrUpdate()
        {
            
            $module_reminder_tags = UserCRMRepository::getAllTags();
            foreach ($module_reminder_tags as $module_reminder_tag) {
                ModuleReminderTag::updateOrCreate($module_reminder_tag);
            }
            
            return true;
        }
        
        
    }
