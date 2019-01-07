<?php

use Illuminate\Database\Seeder;

use Carbon\Carbon;

use App\Setting;

class SettingTableSeeder extends Seeder
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
        $settings = [
        	[
        		'name'			=> 'available_balance',
        		'value'			=> '0',
        		'created_at'	=> $this->date,
        		'updated_at'	=> $this->date,
        	],

        	[
        		'name'			=> 'coins_in_circulation',
        		'value'			=> '0',
        		'created_at'	=> $this->date,
        		'updated_at'	=> $this->date,
        	],

            [
                'name'          => 'mail_enabled',
                'value'         => 1,
                'created_at'    => $this->date,
                'updated_at'    => $this->date,
            ],

            [
                'name'          => 'mail_db_preferred',
                'value'         => 0,
                'created_at'    => $this->date,
                'updated_at'    => $this->date,
            ],

        	[
        		'name'			=> 'mail_driver',
        		'value'			=> '',
        		'created_at'	=> $this->date,
        		'updated_at'	=> $this->date,
        	],

            [
                'name'          => 'mail_host',
                'value'         => '',
                'created_at'    => $this->date,
                'updated_at'    => $this->date,
            ],

            [
                'name'          => 'mail_port',
                'value'         => '',
                'created_at'    => $this->date,
                'updated_at'    => $this->date,
            ],

            [
                'name'          => 'mail_username',
                'value'         => '',
                'created_at'    => $this->date,
                'updated_at'    => $this->date,
            ],

            [
                'name'          => 'mail_password',
                'value'         => '',
                'created_at'    => $this->date,
                'updated_at'    => $this->date,
            ],

            [
                'name'          => 'mail_encryption',
                'value'         => '',
                'created_at'    => $this->date,
                'updated_at'    => $this->date,
            ],

            [
                'name'          => 'mail_from_address',
                'value'         => '',
                'created_at'    => $this->date,
                'updated_at'    => $this->date,
            ],

            [
                'name'          => 'mail_from_name',
                'value'         => '',
                'created_at'    => $this->date,
                'updated_at'    => $this->date,
            ],

            [
                'name'          => 'sparkpost_secret',
                'value'         => '28b0336902591c2fb5dd86204c553631bacbc6ce',
                'created_at'    => $this->date,
                'updated_at'    => $this->date,
            ], 

            [
                'name'          => 'sparkpost_endpoint',
                'value'         => '',
                'created_at'    => $this->date,
                'updated_at'    => $this->date,
            ],

            [
                'name'          => 'mailgun_domain',
                'value'         => '',
                'created_at'    => $this->date,
                'updated_at'    => $this->date,
            ],

            [
                'name'          => 'mailgun_secret',
                'value'         => '',
                'created_at'    => $this->date,
                'updated_at'    => $this->date,
            ],

            [
                'name'          => 'mailgun_endpoint',
                'value'         => '',
                'created_at'    => $this->date,
                'updated_at'    => $this->date,
            ],


            [
                'name'          => 'paypal_enabled',
                'value'         => '1',
                'created_at'    => $this->date,
                'updated_at'    => $this->date,
            ],

            [
                'name'          => 'mpesa_enabled',
                'value'         => '1',
                'created_at'    => $this->date,
                'updated_at'    => $this->date,
            ],

        	[
        		'name'			=> 'coin_value',
        		'value'			=> '10',
        		'created_at'	=> $this->date,
        		'updated_at'	=> $this->date,
        	],

        	[
        		'name'			=> 'system_currency',
        		'value'			=> 'KES',
        		'created_at'	=> $this->date,
        		'updated_at'	=> $this->date,
        	],


        	//************************PAYPAL******************************
        	[
        		'name'			=> 'paypal_mode',
        		'value'			=> 'sandbox',
        		'created_at'	=> $this->date,
        		'updated_at'	=> $this->date,
        	],

        	[
        		'name'			=> 'paypal_currency',
        		'value'			=> 'USD',
        		'created_at'	=> $this->date,
        		'updated_at'	=> $this->date,
        	],

        	[
        		'name'			=> 'paypal_client_id_sandbox',
        		'value'			=> 'ATM4R5bntlNfcLVJzc0TK2j4S-gK0YpoVnNn0H-zVA3wMulqe2Xck1Xh6Hi6dl_CHqzSe-Wx53PiV1qn',
        		'created_at'	=> $this->date,
        		'updated_at'	=> $this->date,
        	],

        	[
        		'name'			=> 'paypal_secret_sandbox',
        		'value'			=> 'EKlsxkJIkJxHqANjGZicCynqpoYz9wYQlJgNcZY4RYGUbmj9p0IMaRoBHhEfLYv03z3O-DgrMNP3OHj7',
        		'created_at'	=> $this->date,
        		'updated_at'	=> $this->date,
        	],

            [
                'name'  		=> 'paypal_client_id_live',
                'value' 		=> 'AV1RG2EM6ES4OivSXurYxywLWIDl7VAt6-_SprgdqBdot6Ca15vJ3qAjduRoehLN73NGicX4dhGj9Bn3',
                'created_at'    => $this->date,
                'updated_at'    => $this->date,
            ],

            [
                'name'  		=> 'paypal_secret_live',
                'value' 		=> 'EIjcpWYpP_P83cxYJdhF-xnbHjAUtOGqrsiKVXSuv4FMuW6n1fwgHEMS0crDpVo7ADieO3CrM1nUJww-',
                'created_at'    => $this->date,
                'updated_at'    => $this->date,
            ],

            //******************************END OF PAYPAL SETTINGS*************************8

            //******************************MPESA SETTING *********************************8

        	[
        		'name'			=> 'mpesa_mode',
        		'value'			=> 'sandbox',
        		'created_at'	=> $this->date,
        		'updated_at'	=> $this->date,
        	],

        	[
                'name'  		=> 'mpesa_shortcode',
                'value' 		=> '174379',
                'created_at'    => $this->date,
                'updated_at'    => $this->date,
            ],

            [
                'name'  		=> 'mpesa_passkey',
                'value' 		=> 'bfb279f9aa9bdbcf158e97dd71a467cd2e0c893059b10f78e6b72ada1ed2c919',
                'created_at'    => $this->date,
                'updated_at'    => $this->date,
            ],

            [
                'name'  => 'mpesa_callback_url',
                'value' => '',
                'created_at'    => $this->date,
                'updated_at'    => $this->date,
            ],

        	[
        		'name'			=> 'mpesa_consumer_key_live',
        		'value'			=> '',
        		'created_at'	=> $this->date,
        		'updated_at'	=> $this->date,
        	],

        	[
        		'name'			=> 'mpesa_consumer_secret_live',
        		'value'			=> '',
        		'created_at'	=> $this->date,
        		'updated_at'	=> $this->date,
        	],

        	[
        		'name'			=> 'mpesa_consumer_key_sandbox',
        		'value'			=> 'dJ8z0skcGONvVa1w1NMbP531pxlGRxZA',
        		'created_at'	=> $this->date,
        		'updated_at'	=> $this->date,
        	],

        	[
        		'name'			=> 'mpesa_consumer_secret_sandbox',
        		'value'			=> 'v4hzjn4X5afZoG3G',
        		'created_at'	=> $this->date,
        		'updated_at'	=> $this->date,
        	],

        	//*************************************END OF MPESA SETTINGS*****************

        	[
        		'name'			=> 'exchange_rate',
        		'value'			=> '100',
        		'created_at'	=> $this->date,
        		'updated_at'	=> $this->date,
        	],
        ];

        Setting::insert($settings);
    }
}
