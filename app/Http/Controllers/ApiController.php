<?php
    
    namespace App\Http\Controllers;
    
    use App\Http\Helpers\InfusionsoftHelper;
    use App\Http\Requests\ModuleReminderAssignerRequest;
    use App\Models\Module;
    use App\Models\ModuleReminderTag;
    use App\Models\User;
    use Illuminate\Http\Request;
    
    class ApiController extends Controller
    {
        
        public $infusionSoftSDK;
        
        public function __construct(InfusionsoftHelper $infusionSoftSDK)
        {
            
            $this->infusionSoftSDK = $infusionSoftSDK;
        }
        
        
        /**
         * @param Request $request
         *
         * @return \Illuminate\Http\JsonResponse
         */
        public function moduleReminderAssigner(ModuleReminderAssignerRequest $request)
        {
            
            // get infusionSoft user
            $crmUser = $this->infusionSoftSDK->getContact($request->contact_email);
            
            // get purchases courses
            $purchasedCourses = explode(',', $crmUser['_Products']);
            
            // get purchased modules for each course
            $purchasedModulesByCourse = Module::getAllByCourse($purchasedCourses);
            
            // get the users completed modules thus far
            $user             = User::where('email', $request->contact_email)->first();
            $completedModules = Module::getCompletedByUser($user);
            
            // find the next incomplete module to consume
            $nextIncompleteCourseModule = Module::getNextIncomplete($purchasedModulesByCourse, $completedModules);
            
            // get the respective module reminder tag, based passed in course module
            list($courseKey, $moduleNumber) = $nextIncompleteCourseModule;
            $moduleReminderTag = ModuleReminderTag::getByCourseAndModule($courseKey, $moduleNumber);
            
            // add module reminder tag to users infusionSoft account
            $this->infusionSoftSDK->addTag($crmUser['Id'], $moduleReminderTag->id);
            
            return response()->json([
                'success' => true,
                'message' => $moduleReminderTag->name
            ], 201);
            
        }
        
        
        /**
         * Populate (create or update) module reminder tags
         *
         * @return bool|mixed
         */
        public function populateModuleReminderTags()
        {
            
            // get all tags from infusionSoftSDK and insert them into table
            $module_reminder_tags = $this->infusionSoftSDK->getAllTags()->toArray();
            foreach ($module_reminder_tags as $module_reminder_tag) {
                ModuleReminderTag::updateOrCreate([
                    'id'   => $module_reminder_tag['id'],
                    'name' => $module_reminder_tag['name']
                ]);
            }
            
            return response()->json($module_reminder_tags, 201);
        }
        
        
        /**
         * Create example customer
         *
         * @return mixed
         */
        public function exampleCustomer()
        {
            
            $infusionsoft = new InfusionsoftHelper();
            
            $uniqid = uniqid();
            
            $infusionsoft->createContact([
                'Email'     => $uniqid . '@test.com',
                "_Products" => 'ipa,iea'
            ]);
            
            $user = User::create([
                'name'     => 'Test ' . $uniqid,
                'email'    => $uniqid . '@test.com',
                'password' => bcrypt($uniqid)
            ]);
            
            // attach IPA M1-3 & M5
            $user->completed_modules()->attach(Module::where('course_key', 'ipa')->limit(3)->get());
            $user->completed_modules()->attach(Module::where('name', 'IPA Module 5')->first());
            
            
            return $user;
        }
        
    }
