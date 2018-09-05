<?php
    
    namespace Tests;
    
    use App\Http\Helpers\InfusionsoftHelper;
    use App\Models\Module;
    use Illuminate\Foundation\Testing\RefreshDatabase;
    use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
    use Mockery;

    abstract class TestCase extends BaseTestCase
    {
        
        use CreatesApplication, RefreshDatabase;
        
        public function setUp()
        {
            
            parent::setUp();
            $this->artisan("db:seed");
        }
        
        
        /**
         * Add completed modules
         *
         * @param $user
         * @param $modulesByCourses
         */
        public function add_completed_modules($user, $modulesByCourses)
        {
            
            // loop through each module by course
            foreach ($modulesByCourses as $courseKey => $modules) {
                
                // add them to completed modules table
                foreach ($modules as $index => $number) {
                    $user->completed_modules()->attach(Module::where('course_key', '=', $courseKey)
                        ->where('number', '=', $number)->get());
                }
            }
        }
    
        /**
         * Mock InfusionSoftHelper class calls
         */
        public function mockInfusionSoftHelperSDKForModuleReminderTests()
        {
            
            $mockInfusionSoftSDK = Mockery::mock(InfusionsoftHelper::class);
            $mockInfusionSoftSDK->shouldReceive('getContact')
                ->with($this->user->email)
                ->andReturn($this->mockInfusionSoftUser);
            $mockInfusionSoftSDK->shouldReceive('addTag')
                ->andReturn(1);
            
            $this->app->instance(InfusionsoftHelper::class, $mockInfusionSoftSDK);
        }
    }
