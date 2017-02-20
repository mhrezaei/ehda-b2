<?php
// @TODO: Delete this file

use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		/*--------------------------------------------------------------------------
		| Users ...
		*/
		DB::table('users')->insert([
			[
				'code_melli' => "0074715623",
				'email' => "chieftaha@gmail.com",
				'name_first' => "طاها",
				'name_last' => "کامکار",
				'password' => bcrypt('11111111'),
				'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
			],
			[
				'code_melli' => "0012071110",
				'email' => "mr.mhrezaei@gmail.com",
				'name_first' => "محمدهادی",
				'name_last' => "رضایی",
				'password' => bcrypt('11111111'),
				'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
			],
			[
				'code_melli' => "",
				'email' => "admin@yasnateam.com",
				'name_first' => "ادمین",
				'name_last' => "یسنا",
				'password' => bcrypt('11111111'),
				'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
			]
		]);

		DB::table('posttypes')->insert([
			'slug' => "pages",
			'order' => "1",
			'title' => "برگه‌ها",
			'header_title' => "",
			'features' => "image title text comment gallery visibility_choice searchable template_choice preview keyword",
			'meta' => json_encode([
				'singular_title' => "برگه",
				'template' => "post",
				'icon' => "file-o",
			]),
			'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
		]);


		DB::table('settings')->insert([
			[
				'slug' => "site_title",
				'title' => "عنوان سایت",
				'category' => "upstream",
				'data_type' => "text",
//				'default_value' => \Illuminate\Support\Facades\Crypt::encrypt('یسناوب') ,
				'default_value' => 'یسناوب' ,
				'developers_only' => 1,
				'is_resident' => 1,
//				'is_sensitive' => false,
				'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
			],
			[
				'slug' => "site_locales",
				'title' => "زبان‌های سایت",
				'category' => "upstream",
				'data_type' => "text",
//				'default_value' => \Illuminate\Support\Facades\Crypt::encrypt('fa') ,
				'default_value' => 'fa' ,
				'developers_only' => 1,
				'is_resident' => 1,
//				'is_sensitive' => "true",
				'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
			],
			[
				'slug' => "site_activeness",
				'title' => "فعالیت سایت",
				'category' => "template",
				'data_type' => "boolean",
//				'default_value' => \Illuminate\Support\Facades\Crypt::encrypt('1') ,
				'default_value' => '1' ,
				'developers_only' => 1,
				'is_resident' => "0",
				'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
			],
			[
				'slug' => "overall_activeness",
				'title' => "فعالیت هسته‌ی سایت",
				'category' => "upstream",
				'data_type' => "boolean",
				'default_value' => '1' ,
//				'default_value' => \Illuminate\Support\Facades\Crypt::encrypt('1') ,
				'developers_only' => 1,
				'is_resident' => "0",
				'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
			],
			[
				'slug' => "ssl_available",
				'title' => "آمادگی اس‌اس‌ال",
				'category' => "upstream",
				'data_type' => "boolean",
//				'default_value' => \Illuminate\Support\Facades\Crypt::encrypt('0') ,
				'default_value' => '0' ,
				'developers_only' => 1,
				'is_resident' => "0",
				'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
			],
		]);

		DB::table('roles')->insert([
			[
				'slug' => "admin",
				'title' => "مدیر",
				'plural_title' => "مدیران",
				'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
				'modules' => json_encode([
						'posts' => ['create','edit','publish','report','delete','bin'] ,
				]),
			],
			[
				'slug' => "user",
				'title' => "کاربر",
				'plural_title' => "کاربران",
				'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
				'modules' => null,
			],
		]);

		DB::table('role_user')->insert([
			[
				'user_id' => 1,
				'role_id' => 1,
				'permissions' => "super",
				'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
			],
			[
				'user_id' => 2,
				'role_id' => 1,
				'permissions' => "super",
				'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
			],
			[
				'user_id' => 3,
				'role_id' => 1,
				'permissions' => "super",
				'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
			],
		]);

	}
}
