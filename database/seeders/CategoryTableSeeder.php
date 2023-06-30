<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;
use Illuminate\Support\Str;

class CategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = ['HTML', 'CSS', 'JavasScript', 'PHP', 'C++'];

        foreach($data as $category){
            $new_category = new Category();
            $new_category->name = $category;
            $new_category->slug = Str::slug($category,'-');
            $new_category->save();
        }
    }
}
