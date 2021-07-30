<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\modle;
use Faker\Generator as Faker;
use Faker\Provider\en_US\PhoneNumber;
use App\emp_info;

$factory->define(emp_info::class, function (Faker $faker) {
    return [

        //
          
        'company_id' => 1,
        'employee_id'=>$faker->unique()->numberBetween($min = 1, $max = 10000),
        'name'=>' ',
        'first_name' => $faker->firstName,
        'fourth_name' => $faker->lastName,
        'birth_date' => $faker->dateTimeBetween($startDate = '-50 years', $endDate = '-22 years', $timezone = null),
        'hiring_date' => $faker->dateTimeBetween($startDate = '-30 years', $endDate = 'now', $timezone = null),
        'gender' => $faker->numberBetween($min = 1, $max = 2),
        'social_status' => $faker->numberBetween($min = 1, $max = 4),
        'blood_type' => $faker->numberBetween($min = 1, $max = 8),
		'religion_type' => $faker->numberBetween($min = 1, $max = 2),
		'nationalty_type' => $faker->numberBetween($min = 1, $max = 5),
		'job_type' => $faker->numberBetween($min = 1, $max = 5),
		'shift_type' => $faker->numberBetween($min = 1, $max = 2),
//		'picture'=>
		'mobilephone'=>' ',
  		'second_name' => ' ',
	    'third_name'=>' ',
	    'first_name_ar'=>'',
	    'second_name_ar'=>' ',
	    'third_name_ar'=>' ',
	    'fourth_name_ar'=>'',
	    'name_ar'=>$faker->Name,
	    'manager_id'=>' ',
	    'card_id'=>' ',
	    'dept_section_structure'=>1,
	    'notes'=>' ',
	    'landphone'=>' ',
	    'picture'=>' ',
	    'define_date'=> now(),
		'termination_date'=>NULL,
		//'updated_at'=>$faker->dateTimeBetween($startDate = '-50 years', $endDate = '-22 years', $timezone = null),
		


    ];
});
