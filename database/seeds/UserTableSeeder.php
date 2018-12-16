<?php

use Illuminate\Database\Seeder;

use App\User;

use Carbon\Carbon;

class UserTableSeeder extends Seeder
{
    protected $date;

    public function __construct(){
    	$this->date = Carbon::now();
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admins = [
        	[
        		'fname' 						=> 'System',
        		'lname' 						=> 'Administrator',
        		'name' 							=> 'System Administrator',
        		'email' 						=> 'admin@mail.com',
        		'username' 						=> 'admin',
        		'password' 						=> bcrypt('administrator'),
        		'social_level' 					=> 'MWANZO',
        		'social_level_attained_at' 		=> $this->date,
        		'last_seen' 					=> $this->date,
        		'coins' 						=> config('coins.earn.join_community'),
        		'accumulated_coins' 			=> config('coins.earn.join_community'),
        		'dob' 							=> '1992-07-10',
        		'usertype' 						=> 'ADMIN',
        		'is_admin' 						=> '1',
        	],
        ];

        $users = [
        	[
        		'fname' 						=> 'Dismus',
        		'lname' 						=> 'Kiplimo',
        		'name' 							=> 'Dismus Kiplimo',
        		'email' 						=> 'dismuskiplimo@gmail.com',
        		'username' 						=> 'dismuskiplimo',
        		'password' 						=> bcrypt('dismuskiplimo'),
        		'social_level' 					=> 'MWANZO',
        		'social_level_attained_at' 		=> $this->date,
        		'last_seen' 					=> $this->date,
        		'coins' 						=> config('coins.earn.join_community'),
        		'accumulated_coins' 			=> config('coins.earn.join_community'),
        		'dob' 							=> '1992-07-10',
        	],

        	[
        		'fname' 						=> 'Dennis',
        		'lname' 						=> 'Muturia',
        		'name' 							=> 'Dennis Muturia',
        		'email' 						=> 'dennis@gmail.com',
        		'username' 						=> 'dennis',
        		'password' 						=> bcrypt('dennis'),
        		'social_level' 					=> 'MWANZO',
        		'social_level_attained_at' 		=> $this->date,
        		'last_seen' 					=> $this->date,
        		'coins' 						=> config('coins.earn.join_community') + 300,
        		'accumulated_coins' 			=> config('coins.earn.join_community') + 300,
        		'dob' 							=> '1992-07-10',
        	],

        	[
        		'fname' 						=> 'Kennedy',
        		'lname' 						=> 'Kirui',
        		'name' 							=> 'Kennedy Kirui',
        		'email' 						=> 'kennedy@gmail.com',
        		'username' 						=> 'kennedy',
        		'password' 						=> bcrypt('kennedy'),
        		'social_level' 					=> 'MWANZO',
        		'social_level_attained_at' 		=> $this->date,
        		'last_seen' 					=> $this->date,
        		'coins' 						=> config('coins.earn.join_community'),
        		'accumulated_coins' 			=> config('coins.earn.join_community'),
        		'dob' 							=> '1992-07-10',
        	],
        ];

        User::insert($admins);
        User::insert($users);
    }
}
