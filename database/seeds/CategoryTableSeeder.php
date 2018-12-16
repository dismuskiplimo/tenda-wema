<?php

use Illuminate\Database\Seeder;

use App\Category;

use Carbon\Carbon;

class CategoryTableSeeder extends Seeder
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
  		$categories = [
  			[
  				'name' 			=> 'Clothing',
  				'slug' 			=> str_slug('Clothing'),
  				'created_at' 	=> $this->date,
  				'updated_at' 	=> $this->date,
  			],

  			[
  				'name' 			=> 'Shoes',
  				'slug' 			=> str_slug('Shoes'),
  				'created_at' 	=> $this->date,
  				'updated_at' 	=> $this->date,
  			],

  			[
  				'name' 			=> 'Mobile Phones',
  				'slug' 			=> str_slug('Mobile Phones'),
  				'created_at' 	=> $this->date,
  				'updated_at' 	=> $this->date,
  			],

  			[
  				'name' 			=> 'Electronics',
  				'slug' 			=> str_slug('Electronics'),
  				'created_at' 	=> $this->date,
  				'updated_at' 	=> $this->date,
  			],

  			[
  				'name' 			=> 'Computers',
  				'slug' 			=> str_slug('Computers'),
  				'created_at' 	=> $this->date,
  				'updated_at' 	=> $this->date,
  			],

  			[
  				'name' 			=> 'Laptops',
  				'slug' 			=> str_slug('Laptops'),
  				'created_at' 	=> $this->date,
  				'updated_at' 	=> $this->date,
  			],

  			[
  				'name' 			=> 'Household Goods',
  				'slug' 			=> str_slug('Household Goods'),
  				'created_at' 	=> $this->date,
  				'updated_at' 	=> $this->date,
  			],

  			[
  				'name' 			=> 'Cars',
  				'slug' 			=> str_slug('Cars'),
  				'created_at' 	=> $this->date,
  				'updated_at' 	=> $this->date,
  			],

  			[
  				'name' 			=> 'Bicycles',
  				'slug' 			=> str_slug('Bicycles'),
  				'created_at' 	=> $this->date,
  				'updated_at' 	=> $this->date,
  			],

  			[
  				'name' 			=> 'Toys',
  				'slug' 			=> str_slug('Toys'),
  				'created_at' 	=> $this->date,
  				'updated_at' 	=> $this->date,
  			],

  			[
  				'name' 			=> 'Dolls',
  				'slug' 			=> str_slug('Dolls'),
  				'created_at' 	=> $this->date,
  				'updated_at' 	=> $this->date,
  			],

  			[
  				'name' 			=> 'Foodstuff',
  				'slug' 			=> str_slug('Foodstuff'),
  				'created_at' 	=> $this->date,
  				'updated_at' 	=> $this->date,
  			],

  			[
  				'name' 			=> 'Services',
  				'slug' 			=> str_slug('Services'),
  				'created_at' 	=> $this->date,
  				'updated_at' 	=> $this->date,
  			],

  			[
  				'name' 			=> 'Stationery',
  				'slug' 			=> str_slug('Stationery'),
  				'created_at' 	=> $this->date,
  				'updated_at' 	=> $this->date,
  			],

  			[
  				'name' 			=> 'Other',
  				'slug' 			=> str_slug('Other'),
  				'created_at' 	=> $this->date,
  				'updated_at' 	=> $this->date,
  			],

  		];

  		Category::insert($categories);
    }
}
