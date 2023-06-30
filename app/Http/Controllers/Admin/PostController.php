<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Http\Requests\PostRequest;
use Illuminate\Support\Facades\Storage;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Support\Facades\Auth;


class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // verifico se è presente la variabile search in GET
        // se c'è faccio la query con LIKE
        // se non cè faccio la query base

        $direction = 'asc';

        if(isset($_GET['search'])){
            $tosearch = $_GET['search'];
            $posts = Post::where('user_id', Auth::id())
                            ->where('title', 'like', "%$tosearch%")
                            ->paginate(10);
        }else{
            $posts = Post::where('user_id', Auth::id())
                    ->orderBy('id',$direction)->paginate(10);
        }


        return view('admin.posts.index', compact('posts','direction'));

    }

    public function orderby($direction, $column){
        $direction = $direction === 'asc' ? 'desc' : 'asc';
        $posts = Post::where('user_id', Auth::id())
                    ->orderBy($column,$direction)->paginate(10);
        return view('admin.posts.index', compact('posts','direction'));
    }

    public function categoryPosts(){
        $categories = Category::all();
        return view('admin.posts.category-posts',compact('categories'));
    }

    public function tagsPosts(){
        $tags = Tag::all();
        return view('admin.posts.tag-posts',compact('tags'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        $tags = Tag::all();
        $title = 'Creazione di un nuovo post';
        $method = 'POST';
        $route = route('admin.posts.store');
        $post = null;
        return view('admin.posts.create-edit', compact('title', 'method', 'route', 'post', 'categories', 'tags'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PostRequest $request)
    {
        $form_data             = $request->all();
        $form_data['slug']     = Post::generateSlug($form_data['title']);
        $form_data['date']     = date('Y-m-d');
        $form_data['user_id']  = Auth::id();

        // verifico se è stata caricata un'immagine
        if(array_key_exists('image',$form_data)){

            // prima di salvare l'immagine salvo il nome
            $form_data['image_original_name'] = $request->file('image')->getClientOriginalName();
            // salvo l'immagine nella cartella uploads e in $form_data['image_path'] salvo il percorso
            $form_data['image_path'] = Storage::put('uploads/',$form_data['image']);

        }

        // $new_post = new Post();
        // $new_post->fill($form_data);
        // $new_post->save();

        // soluzione short per fare quello commentato sopra
        $new_post = Post::create($form_data);

        // se ho inviato almeno un tag
        if(array_key_exists('tags', $form_data)){
            // "attacco" al post appena creato l'array dei tags proveniente dal form
            $new_post->tags()->attach($form_data['tags']);
        }

        return redirect()->route('admin.posts.show', $new_post);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = Post::where('id',$id)
                    ->where('user_id',Auth::id())
                    ->first();

        if(!$post){
            abort('404');
        }

        $date = date_create($post->date);
        $data_formatted = date_format($date, 'd/m/Y') ;
        return view('admin.posts.show', compact('post','data_formatted'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        $categories = Category::all();
        $tags = Tag::all();
        $title = "Modifica di: " . $post->title;
        $method = 'PUT';
        $route = route('admin.posts.update', $post);
        return view('admin.posts.create-edit', compact('title', 'method', 'route', 'post', 'categories', 'tags'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PostRequest $request, Post $post)
    {
        $form_data = $request->all();
        if($form_data['title'] !== $post->title){
            $form_data['slug'] = Post::generateSlug($form_data['title']);
        }else{
            $form_data['slug'] = $post->slug;
        }
        $form_data['date']  = date('Y-m-d');

         // verifico se è stata caricata un'immagine
         if(array_key_exists('image',$form_data)){

            // se l'immagine esiste vuol dire che ne ho caricata una nuova e quindi elimino quella vecchia
           if($post->image_path){
                Storage::disk('public')->delete($post->image_path);
           }

            // prima di salvare l'immagine salvo il nome
            $form_data['image_original_name'] = $request->file('image')->getClientOriginalName();
            // salvo l'immagine nella cartella uploads e in $form_data['image_path'] salvo il percorso
            $form_data['image_path'] = Storage::put('uploads/',$form_data['image']);
        }

        if(array_key_exists('noImage', $form_data) && $post->image_path) {
            Storage::disk('public')->delete($post->image_path);
            $form_data['image_original_name'] = '';
            $form_data['image_path'] = '';
        }

        $post->update($form_data);

        if(array_key_exists('tags', $form_data)){
            // se esiste la chiave sicronizzo con i nuovi dati la tabella pivot
            $post->tags()->sync($form_data['tags']);
        }else{
            // se non passo nessun tag elimino tutte le relazioni
            $post->tags()->detach();
        }

        return redirect()->route('admin.posts.show', $post);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {

        // se nella migration non ho messo cascadeOnDelete devo fare
        // $post->tags()->detach();

        // se il post da eliminare contiene un'immagine la devo cancellare dalla cartella
        if($post->image_path){
            Storage::disk('public')->delete($post->image_path);
       }

        $post->delete();

        return redirect()->route('admin.posts.index')->with('deleted','Post eliminato correttamente');
    }
}
