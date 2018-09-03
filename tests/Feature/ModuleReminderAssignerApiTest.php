<?php
	
	namespace Tests\Feature;
	
	use Tests\TestCase;
	
	class ModuleReminderAssignerApiTest extends TestCase
	{
		
		private static $moduleReminderAssignerUrl = 'api/module_reminder_assigner';
		
		/**
		 *  Test a valid module_reminder_assigner endpoint POST request
		 *
		 * @return void
		 */
		public function testValidPostResponseStatus()
		{
			
			$data     = ['contact_email' => 'some.email@gmail.com'];
			$response = $this->json('POST', self::$moduleReminderAssignerUrl, $data);
			$response->assertStatus(201);
		}
		
		/**
		 *  Test a valid module_reminder_assigner endpoint POST request
		 *
		 * @return void
		 */
		public function testInValidPostResponseNoContactEmail()
		{
			
			$data     = [];
			$response = $this->json('POST', self::$moduleReminderAssignerUrl, $data);
			$response->assertStatus(422);
			$response->assertJson(['success' => false]);
			$response->assertJson(['message' => 'The contact email field is required.']);
		}
		
		/**
		 *  Test a valid module_reminder_assigner endpoint POST request
		 *
		 * @return void
		 */
		public function testValidPostResponseData()
		{
			
			$data     = ['contact_email' => 'some.email@gmail.com'];
			$response = $this->json('POST', self::$moduleReminderAssignerUrl, $data);
			$response->assertStatus(201);
			$response->assertJsonStructure(['success', 'message']);
			$response->assertJson(['success' => true]);
		}
	}
