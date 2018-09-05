<?php
    
    namespace Tests\Feature;
    
    use App\Models\Course;
    use App\Models\User;
    use Tests\TestCase;
    
    
    class ModuleReminderAssignerApiTest extends TestCase
    {
        
        private static $moduleReminderAssignerUrl = 'api/module_reminder_assigner';
        
        public $user;
        public $mockInfusionSoftUser;
        public $infusionSoftHelper;
        
        
        public function setUp()
        {
            
            parent::setUp();
            
            $this->user = factory(User::class)->create();
            
            $courses = [
                Course::$COURSE_KEY_IPHONE_EDITING_ACADEMY,
                Course::$COURSE_KEY_IPHONE_ART_ACADEMY,
                Course::$COURSE_KEY_IPHONE_PHOTO_ACADEMY,
            ];
            
            $this->mockInfusionSoftUser = [
                "Email"     => $this->user->email,
                "Groups"    => 120,
                "_Products" => implode(",", $courses),
                "Id"        => 3654
            ];
            
        }
        
        /**
         * Test if all modules complete in previous course
         *
         * If no modules are completed it should attach first tag in order.
         */
        public function testValidIfNoModulesAreCompleted()
        {
            
            $this->mockInfusionSoftHelperSDKForModuleReminderTests();
            
            $this->add_completed_modules($this->user, [
                Course::$COURSE_KEY_IPHONE_EDITING_ACADEMY => [],
                Course::$COURSE_KEY_IPHONE_ART_ACADEMY     => [],
                Course::$COURSE_KEY_IPHONE_PHOTO_ACADEMY   => []
            
            ]);
            
            $data     = ['contact_email' => $this->user->email];
            $response = $this->json('POST', self::$moduleReminderAssignerUrl, $data);
            $response->assertStatus(201);
            $response->assertJson(['success' => true]);
            $response->assertJson(['message' => 'Start IEA Module 1 Reminders']);
        }
        
        /**
         * Test if all modules complete in previous course
         *
         * If no modules are completed it should attach first tag in order.
         */
        public function testValidIfAnyFirstCourseModulesAreCompletedAttachNextUncompletedModule()
        {
            
            $this->mockInfusionSoftHelperSDKForModuleReminderTests();
            
            $this->add_completed_modules($this->user, [
                Course::$COURSE_KEY_IPHONE_EDITING_ACADEMY => [1, 3, 6],
                Course::$COURSE_KEY_IPHONE_ART_ACADEMY     => [],
                Course::$COURSE_KEY_IPHONE_PHOTO_ACADEMY   => []
            
            ]);
            
            $data     = ['contact_email' => $this->user->email];
            $response = $this->json('POST', self::$moduleReminderAssignerUrl, $data);
            $response->assertStatus(201);
            $response->assertJson(['success' => true]);
            $response->assertJson(['message' => 'Start IEA Module 7 Reminders']);
        }
        
        /**
         * Test if all modules complete in previous course attach next uncompleted module in next course
         *
         * If all (or last) first course modules are completed - attach next uncompleted module
         * after the last completed of the second course. Same applies in case of a third course.
         */
        public function testValidIfAllModulesCompleteInPreviousCourseAttachNextUncompletedModuleInNextCourse()
        {
            
            $this->mockInfusionSoftHelperSDKForModuleReminderTests();
            
            $this->add_completed_modules($this->user, [
                Course::$COURSE_KEY_IPHONE_EDITING_ACADEMY => [1, 2, 3, 4, 5, 6, 7],
                Course::$COURSE_KEY_IPHONE_ART_ACADEMY     => [2],
                Course::$COURSE_KEY_IPHONE_PHOTO_ACADEMY   => [1, 3, 4]
            
            ]);
            
            $data     = ['contact_email' => $this->user->email];
            $response = $this->json('POST', self::$moduleReminderAssignerUrl, $data);
            $response->assertStatus(201);
            $response->assertJson(['success' => true]);
            $response->assertJson(['message' => 'Start IAA Module 3 Reminders']);
        }
        
        /**
         * Test if all modules complete in previous course
         *
         * If all modules of all courses are completed - attach “Module reminders completed” tag.
         */
        public function testValidIfAllModulesCompletedInEachCourse()
        {
            
            $this->mockInfusionSoftHelperSDKForModuleReminderTests();
            
            $this->add_completed_modules($this->user, [
                Course::$COURSE_KEY_IPHONE_EDITING_ACADEMY => [1, 2, 3, 4, 5, 6, 7],
                Course::$COURSE_KEY_IPHONE_ART_ACADEMY     => [1, 2, 3, 4, 5, 6, 7],
                Course::$COURSE_KEY_IPHONE_PHOTO_ACADEMY   => [1, 2, 3, 4, 5, 6, 7]
            
            ]);
            
            $data     = ['contact_email' => $this->user->email];
            $response = $this->json('POST', self::$moduleReminderAssignerUrl, $data);
            $response->assertStatus(201);
            $response->assertJson(['success' => true]);
            $response->assertJson(['message' => 'Module reminders completed']);
        }
        
        /**
         * Test if last modules complete in previous course
         *
         * If last modules of all courses are completed - attach “Module reminders completed” tag.
         */
        public function testValidIfLastModulesCompletedInEachCourse()
        {
            
            $this->mockInfusionSoftHelperSDKForModuleReminderTests();
            
            $this->add_completed_modules($this->user, [
                Course::$COURSE_KEY_IPHONE_EDITING_ACADEMY => [7],
                Course::$COURSE_KEY_IPHONE_ART_ACADEMY     => [7],
                Course::$COURSE_KEY_IPHONE_PHOTO_ACADEMY   => [7]
            
            ]);
            
            $data     = ['contact_email' => $this->user->email];
            $response = $this->json('POST', self::$moduleReminderAssignerUrl, $data);
            $response->assertStatus(201);
            $response->assertJson(['success' => true]);
            $response->assertJson(['message' => 'Module reminders completed']);
        }
        
        
        /**
         *  Test an invalid request with no contact email parameter
         *
         * @return void
         */
        public function testInvalidRequestNoContactEmail()
        {
            
            $data     = [];
            $response = $this->json('POST', self::$moduleReminderAssignerUrl, $data);
            $response->assertStatus(422);
            $response->assertJson(['success' => false]);
            $response->assertJson(['message' => 'The contact email field is required.']);
        }
        
        
        /**
         *  Test an invalid request where contact email does not exist
         *
         * @return void
         */
        public function testInvalidRequestContactEmailDoesNotExist()
        {
            
            $data     = ['contact_email' => 'email@thatdoesnotexist.com'];
            $response = $this->json('POST', self::$moduleReminderAssignerUrl, $data);
            $response->assertStatus(422);
            $response->assertJson(['success' => false]);
            $response->assertJson(['message' => 'The selected contact email is invalid.']);
        }
    }
