<?php

use Illuminate\Database\Seeder;

use Carbon\Carbon;

use App\ReportType;

class ReportTypeSeeder extends Seeder
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
        $report_types = [
        	[
        		'type'			=> 'post.flagged',
	        	'description'	=> 'Post is misleading',
	        	'created_at'	=> $this->date,
	        	'updated_at'	=> $this->date,
        	],

        	[
        		'type'			=> 'media.flagged',
	        	'description'	=> 'Media is not appropriate',
	        	'created_at'	=> $this->date,
	        	'updated_at'	=> $this->date,
        	],

        	[
        		'type'			=> 'language.inappropriate',
	        	'description'	=> 'Inappropriate Language used',
	        	'created_at'	=> $this->date,
	        	'updated_at'	=> $this->date,
        	],

        	[
        		'type'			=> 'conduct.inappropriate',
	        	'description'	=> 'Inappropriate conduct',
	        	'created_at'	=> $this->date,
	        	'updated_at'	=> $this->date,
        	],

        	[
        		'type'			=> 'community.disrupt',
	        	'description'	=> 'Disrupts the community',
	        	'created_at'	=> $this->date,
	        	'updated_at'	=> $this->date,
        	],

        	[
        		'type'			=> 'reporting.malicious',
	        	'description'	=> 'Malicious reporting',
	        	'created_at'	=> $this->date,
	        	'updated_at'	=> $this->date,
        	],

        	[
        		'type'			=> 'rules.non-adhere',
	        	'description'	=> 'Non Adherence to ' . config('app.name') . ' Community Policies',
	        	'created_at'	=> $this->date,
	        	'updated_at'	=> $this->date,
        	],
        ];

        ReportType::insert($report_types);
    }
}
