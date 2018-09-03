<?php
    
    namespace App\Http\Controllers;
    
    
    use App\Http\Helpers\InfusionsoftHelper;
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
        
        public function __construct(
            UserRepositoryInterface $userRepository,
            UserCRMRepositoryInterface $userCRMRepository
        ) {
            
            $this->userRepository    = $userRepository;
            $this->userCRMRepository = $userCRMRepository;
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
                
                return response()->json([
                    'success' => false,
                    'message' => $error_message
                ], 422);
            }
            
            $crmUser = $this->userCRMRepository->getByEmail($request->contact_email);
            $crmUserCourses = $this->userCRMRepository->getPurchasedCourses($crmUser);
            $user    = $this->userRepository->getByEmail($request->contact_email);
            // TODO - get all courses
            // TODO - get all completed modules
            // TODO - determine next course reminder
            
            print_r($crmUser);
            print_r($user);
            print_r($crmUserCourses);
            
            
            return response()->json([
                'success' => true,
                'message' => 'some message'
            ], 201);
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
