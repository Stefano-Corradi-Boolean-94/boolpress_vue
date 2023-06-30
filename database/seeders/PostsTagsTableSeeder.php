<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Tag;
use App\Models\Post;

class PostsTagsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i = 0; $i < 50; $i++){

            // estraggo un post random
            $post = Post::inRandomOrder()->first();

            // estraggo l'ID di un tag random
            $tag_id = Tag::inRandomOrder()->first()->id;

            $post->tags()->attach($tag_id);

        }
    }
}
