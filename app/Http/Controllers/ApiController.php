<?php
    
    namespace App\Http\Controllers;
    
    
    use App\Http\Helpers\InfusionsoftHelper;
    use App\Interfaces\ModuleReminderTagRepositoryInterface;
    use App\Interfaces\ModuleRepositoryInterface;
    use App\Interfaces\UserCRMRepositoryInterface;
    use App\Interfaces\UserRepositoryInterface;
    use App\Models\Module;
    use App\Models\User;
    use Illuminate\Http\Request;
    use Validator;
    
    
    class ApiController extends Controller
    {
        
        /**
         * @var UserRepositoryInterface
         */
        private $userRepository;
        
        /**
         * @var UserCRMRepositoryInterface
         */
        private $userCRMRepository;
        
        /**
         * @var ModuleRepositoryInterface
         */
        private $moduleRepository;
        
        /**
         * @var ModuleReminderTagRepositoryInterface
         */
        private $moduleReminderTagRepository;
        
        public function __construct(
            UserRepositoryInterface $userRepository,
            UserCRMRepositoryInterface $userCRMRepository,
            ModuleRepositoryInterface $moduleRepository,
            ModuleReminderTagRepositoryInterface $moduleReminderTagRepository
        ) {
            
            $this->userRepository              = $userRepository;
            $this->userCRMRepository           = $userCRMRepository;
            $this->moduleRepository            = $moduleRepository;
            $this->moduleReminderTagRepository = $moduleReminderTagRepository;
        }
        
        /**
         * @param Request $request
         *
         * @return \Illuminate\Http\JsonResponse
         */
        public function moduleReminderAssigner(Request $request)
        {
            
            // set up a request validator to make sure we have an email
            $validator = Validator::make($request->json()->all(), [
                'contact_email' => 'required|email'
            ]);
            
            // check for errors
            if ($validator->fails()) {
                $error_message = $validator->errors()->first();
                
                // return error
                return response()->json([
                    'success' => false,
                    'message' => $error_message
                ], 422);
            }
            
            $crmUser              = $this->userCRMRepository->getByEmail($request->contact_email);
            $crmUserCourses       = $this->userCRMRepository->getPurchasedCourses($crmUser);
            $user                 = $this->userRepository->getByEmail($request->contact_email);
            $purchasedModules     = $this->moduleRepository->getAllByCourse($crmUserCourses);
            $completedModules     = $this->moduleRepository->getCompletedByUser($user);
            $nextIncompleteModule = $this->moduleRepository->getNextIncomplete($purchasedModules, $completedModules);
            $courseKey            = $nextIncompleteModule[0];
            $moduleNumber         = $nextIncompleteModule[1];
            $moduleReminderTag    = $this->moduleReminderTagRepository->getByModule($courseKey, $moduleNumber);
            $response             = $this->userCRMRepository->addTag($crmUser, $moduleReminderTag->id);
            
            if ($response) {
                return response()->json([
                    'success' => true,
                    'message' => $moduleReminderTag->name
                ], 201);
            } else{
                return response()->json([
                    'success' => false,
                    'message' => 'There was an error processing next module reminder.'
                ], 500);
            }
            
            
        }
        
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
