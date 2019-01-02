<?php

use Illuminate\Database\Seeder;

use App\{User, Profile};

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
                'is_admin'                      => '1',
                'email_verified'                => '1',
        		'email_verified_at'   			=> $this->date,
                
                'created_at'                    => $this->date,
                'updated_at'                    => $this->date,
        	],

            [
                'fname'                         => 'Root',
                'lname'                         => 'User',
                'name'                          => 'Root User',
                'email'                         => 'root@mail.com',
                'username'                      => 'root',
                'password'                      => bcrypt('@Welcome123'),
                'social_level'                  => 'MWANZO',
                'social_level_attained_at'      => $this->date,
                'last_seen'                     => $this->date,
                'coins'                         => config('coins.earn.join_community'),
                'accumulated_coins'             => config('coins.earn.join_community'),
                'dob'                           => '1992-07-10',
                'usertype'                      => 'ADMIN',
                'is_admin'                      => '1',
                'email_verified'                => '1',
                'email_verified_at'             => $this->date,
                
                'created_at'                    => $this->date,
                'updated_at'                    => $this->date,
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
        		'coins' 						=> config('coins.social_levels.hodari'),
        		'accumulated_coins' 			=> config('coins.social_levels.hodari'),
        		'dob' 							=> '1992-07-10',
                'email_verified'                => '1',
                'email_verified_at'             => $this->date,

                'created_at'                    => $this->date,
                'updated_at'                    => $this->date,
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
        		'coins' 						=> config('coins.social_levels.shujaa'),
        		'accumulated_coins' 			=> config('coins.social_levels.shujaa'),
        		'dob' 							=> '1992-07-10',
                'email_verified'                => '1',
                'email_verified_at'             => $this->date,

                'created_at'                    => $this->date,
                'updated_at'                    => $this->date,
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
        		'coins' 						=> config('coins.social_levels.bingwa'),
        		'accumulated_coins' 			=> config('coins.social_levels.bingwa'),
        		'dob' 							=> '1992-07-10',
                'email_verified'                => '1',
                'email_verified_at'             => $this->date,

                'created_at'                    => $this->date,
                'updated_at'                    => $this->date,
        	],
        ];

        User::insert($admins);
        User::insert($users);

        $users = User::get();

        foreach ($users as $user) {
            $profile = new Profile;
            $profile->user_id = $user->id;
            $profile->save();
        }
    }
}
