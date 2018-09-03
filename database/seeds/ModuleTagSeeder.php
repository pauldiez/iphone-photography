<?php
	
	
	use Illuminate\Database\Seeder;
	
	use App\Models\ModuleTag;
	
	class ModuleTagSeeder extends Seeder
	{
		
		private static $module_tags = [
			[
				"id"          => 110,
				"name"        => 'Start IPA Module 1 Reminders',
				"description" => '',
				"category"    => null
			],
			[
				"id"          => 112,
				"name"        => 'Start IPA Module 2 Reminders',
				"description" => '',
				"category"    => null
			],
			[
				"id"          => 114,
				"name"        => 'Start IPA Module 3 Reminders',
				"description" => '',
				"category"    => null
			],
			[
				"id"          => 116,
				"name"        => 'Start IPA Module 4 Reminders',
				"description" => '',
				"category"    => null
			],
			[
				"id"          => 118,
				"name"        => 'Start IPA Module 5 Reminders',
				"description" => '',
				"category"    => null
			],
			[
				"id"          => 120,
				"name"        => 'Start IPA Module 6 Reminders',
				"description" => '',
				"category"    => null
			],
			[
				"id"          => 122,
				"name"        => 'Start IPA Module 7 Reminders',
				"description" => '',
				"category"    => null
			],
			[
				"id"          => 124,
				"name"        => 'Start IEA Module 1 Reminders',
				"description" => '',
				"category"    => null
			],
			[
				"id"          => 126,
				"name"        => 'Start IEA Module 2 Reminders',
				"description" => '',
				"category"    => null
			],
			[
				"id"          => 128,
				"name"        => 'Start IEA Module 3 Reminders',
				"description" => '',
				"category"    => null
			],
			[
				"id"          => 130,
				"name"        => 'Start IEA Module 4 Reminders',
				"description" => '',
				"category"    => null
			],
			[
				"id"          => 132,
				"name"        => 'Start IEA Module 5 Reminders',
				"description" => '',
				"category"    => null
			],
			[
				"id"          => 134,
				"name"        => 'Start IEA Module 6 Reminders',
				"description" => '',
				"category"    => null
			],
			[
				"id"          => 136,
				"name"        => 'Start IEA Module 7 Reminders',
				"description" => '',
				"category"    => null
			],
			[
				"id"          => 138,
				"name"        => 'Start IAA Module 1 Reminders',
				"description" => '',
				"category"    => null
			],
			[
				"id"          => 140,
				"name"        => 'Start IAA Module 2 Reminders',
				"description" => '',
				"category"    => null
			],
			[
				"id"          => 142,
				"name"        => 'Start IAA Module 3 Reminders',
				"description" => '',
				"category"    => null
			],
			[
				"id"          => 144,
				"name"        => 'Start IAA Module 4 Reminders',
				"description" => '',
				"category"    => null
			],
			[
				"id"          => 146,
				"name"        => 'Start IAA Module 5 Reminders',
				"description" => '',
				"category"    => null
			],
			[
				"id"          => 148,
				"name"        => 'Start IAA Module 6 Reminders',
				"description" => '',
				"category"    => null
			],
			[
				"id"          => 150,
				"name"        => 'Start IAA Module 7 Reminders',
				"description" => '',
				"category"    => null
			],
			[
				"id"          => 154,
				"name"        => 'Module reminders completed',
				"description" => '',
				"category"    => null
			]
		];
		
		
		/**
		 * Run the Module Tags seeds.
		 *
		 * @return void
		 */
		public function run()
		{
			foreach (self::$module_tags as $module_tag) {
				ModuleTag::insert($module_tag);
			}
		}
	}