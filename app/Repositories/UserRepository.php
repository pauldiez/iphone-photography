<?php
	
	namespace App\Repositories;
	
	use App\Http\Helpers\InfusionsoftHelper;
	use App\Interfaces\UserRepositoryInterface;
	
	class UserRepository implements UserRepositoryInterface
	{
		
		/**
		 * Get InfusionSoft user account by Email
		 *
		 * @param $email
		 *
		 * @return mixed
		 */
		public function getCRMUserAccountByEmail($email)
		{
			$infusionSoft = new InfusionsoftHelper();
			$account      = $infusionSoft->getContact($email);
			
			return $account;
		}
	}
