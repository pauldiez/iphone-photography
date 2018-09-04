<?php
    
    namespace App\Providers;
    
    use App\Interfaces\ModuleReminderTagRepositoryInterface;
    use App\Interfaces\UserCRMRepositoryInterface;
    use App\Interfaces\UserRepositoryInterface;
    use App\Interfaces\ModuleRepositoryInterface;
    
    use App\Repositories\UserCRMRepository;
    use App\Repositories\UserRepository;
    use App\Repositories\ModuleReminderTagRepository;
    use App\Repositories\ModuleRepository;
    use Illuminate\Support\ServiceProvider;
    
    
    class RepositoryServiceProvider extends ServiceProvider
    {
        
        /**
         * Bind the interface to an implementation repository class
         */
        public function register()
        {
            
            $this->app->bind(
                UserRepositoryInterface::class,
                UserRepository::class
            );
            
            $this->app->bind(
                UserCRMRepositoryInterface::class,
                UserCRMRepository::class
            );
            
            $this->app->bind(
                ModuleReminderTagRepositoryInterface::class,
                ModuleReminderTagRepository::class
            );
            
            $this->app->bind(
                ModuleRepositoryInterface::class,
                ModuleRepository::class
            );
            
        }
    }

