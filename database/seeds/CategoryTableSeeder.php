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
  				'name' 			=> 'Phones and Accessories',
  				'slug' 			=> str_slug('Phones and Accessories'),
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
  				'name' 			=> 'Computers & Laptops',
  				'slug' 			=> str_slug('Computers & Laptops'),
  				'created_at' 	=> $this->date,
  				'updated_at' 	=> $this->date,
  			],

  			[
  				'name' 			=> 'Home Ware and Appliances',
  				'slug' 			=> str_slug('Home Ware and Appliances'),
  				'created_at' 	=> $this->date,
  				'updated_at' 	=> $this->date,
  			],

  			[
  				'name' 			=> 'Office Ware and Appliances',
  				'slug' 			=> str_slug('Office Ware and Appliances'),
  				'created_at' 	=> $this->date,
  				'updated_at' 	=> $this->date,
  			],

  			[
  				'name' 			=> 'Health and Beauty',
  				'slug' 			=> str_slug('Health and Beauty'),
  				'created_at' 	=> $this->date,
  				'updated_at' 	=> $this->date,
  			],

  			[
  				'name' 			=> 'Grocery',
  				'slug' 			=> str_slug('Grocery'),
  				'created_at' 	=> $this->date,
  				'updated_at' 	=> $this->date,
  			],

  			[
  				'name' 			=> 'Baby Products',
  				'slug' 			=> str_slug('Baby Products'),
  				'created_at' 	=> $this->date,
  				'updated_at' 	=> $this->date,
  			],

  			[
  				'name' 			=> 'Fashion',
  				'slug' 			=> str_slug('Fashion'),
  				'created_at' 	=> $this->date,
  				'updated_at' 	=> $this->date,
  			],

  			[
  				'name' 			=> 'Artifacts',
  				'slug' 			=> str_slug('Artifacts'),
  				'created_at' 	=> $this->date,
  				'updated_at' 	=> $this->date,
  			],

  			[
  				'name' 			=> 'Handmade Products',
  				'slug' 			=> str_slug('Handmade Products'),
  				'created_at' 	=> $this->date,
  				'updated_at' 	=> $this->date,
  			],

  			[
  				'name' 			=> 'Sports Ware',
  				'slug' 			=> str_slug('Sports Ware'),
  				'created_at' 	=> $this->date,
  				'updated_at' 	=> $this->date,
  			],

  			[
  				'name' 			=> 'Apparel and Accessories',
  				'slug' 			=> str_slug('Apparel and Accessories'),
  				'created_at' 	=> $this->date,
  				'updated_at' 	=> $this->date,
  			],

  			[
  				'name' 			=> 'Safety and Security',
  				'slug' 			=> str_slug('Safety and Security'),
  				'created_at' 	=> $this->date,
  				'updated_at' 	=> $this->date,
  			],

  			[
  				'name' 			=> 'Outdoor and Adventure Products',
  				'slug' 			=> str_slug('Outdoor and Adventure Products'),
  				'created_at' 	=> $this->date,
  				'updated_at' 	=> $this->date,
  			],

        [
          'name'      => 'Games and Toys',
          'slug'      => str_slug('Games and Toys'),
          'created_at'  => $this->date,
          'updated_at'  => $this->date,
        ],

        [
          'name'      => 'Books',
          'slug'      => str_slug('Books'),
          'created_at'  => $this->date,
          'updated_at'  => $this->date,
        ],

        [
          'name'      => 'Movies and Music',
          'slug'      => str_slug('Movies and Music'),
          'created_at'  => $this->date,
          'updated_at'  => $this->date,
        ],

        [
          'name'      => 'Automobile Products',
          'slug'      => str_slug('Automobile Products'),
          'created_at'  => $this->date,
          'updated_at'  => $this->date,
        ],

        [
          'name'      => 'Others',
          'slug'      => str_slug('Others'),
          'created_at'  => $this->date,
          'updated_at'  => $this->date,
        ],

  		];

  		Category::insert($categories);
    }
}
