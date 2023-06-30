<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Database\Eloquent\Builder;

class PostController extends Controller
{
    public function index(){

        $posts = Post::with('category', 'tags', 'user')->paginate(10);
        $categories = Category::all();
        $tags = Tag::all();

        return response()->json(compact('posts','categories','tags'));
    }

    public function getPostsByCategory($id){
        $posts = Post::where('category_id', $id)->with('category', 'tags', 'user')->paginate(10);
        $categories = Category::all();
        $tags = Tag::all();

        return response()->json(compact('posts','categories','tags'));

    }

    public function getPostsByTag($id){

        ////// soluzione A //////
        // prendo tutti il tag con tutti i posts in relazione
        // $tag = Tag::where('id',$id)->with('posts')->first();
        // creo un array vuoto che poi speporterò
        // $posts = [];
        // ciclo tutti i post del tag
        // foreach ($tag->posts as $post) {
        //    // prendo ogni post con le sue relazioni e llo pusho in $list_post
        //    $posts[] = Post::where('id',$post->id)->with('category', 'tags', 'user')->first();
        // }

        ////// soluzione B - OK //////
        $posts = Post::with('category', 'tags', 'user')
                    ->whereHas('tags', function(Builder $query) use($id){
                        $query->where('tag_id',$id);
                    })->paginate(10);



        $categories = Category::all();
        $tags = Tag::all();

        return response()->json(compact('posts','categories','tags'));
    }

    public function getCategories(){

        $category = Category::all();

        return response()->json($category);
    }

    public function getTags(){

        $tags = Tag::all();

        return response()->json($tags);
    }

    public function getPostDetail($slug){

        $post = Post::where('slug', $slug)->with('category', 'tags', 'user')->first();
        if($post->image_path) $post->image_path = asset('storage/' . $post->image_path) ;
        else{
            $post->image_path = asset('storage/uploads/placeholder.png') ;
            $post->image_original_name = '- no image -';
        }
        return response()->json($post);
    }

    public function search($tosearch){
        $posts = Post::where('title','like', "%$tosearch%")->with('category', 'tags', 'user')->paginate(10);


        return response()->json($posts);
    }
}
