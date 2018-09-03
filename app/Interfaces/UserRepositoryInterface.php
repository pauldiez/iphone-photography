<?php
	
	namespace App\Interfaces;
	
	interface UserRepositoryInterface
	{
		
		/**
		 * Get third party crm service user account by Email
		 *
		 * @param $email
		 *
		 * @return mixed
		 */
		public function getCRMUserAccountByEmail($email);
	}