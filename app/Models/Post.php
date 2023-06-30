<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Post extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'title',
        'category_id',
        'slug',
        'text',
        'date',
        'reading_time',
        'image_path',
        'image_original_name',
        'user_id'
    ];

    // relazione con la tabella categories
    // nome della tabella in camelCase al singolare perché ogni post ha una sola categoria
    // "appartengo a una categoria"
    public function category(){
        return $this->belongsTo(Category::class);
    }

    public function tags(){
        return $this->belongsToMany(Tag::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public static function generateSlug($str){

        $slug = Str::slug($str, '-');
        $original_slug = $slug;

        // Controllo di univicità
        /*
            1. controllo se lo slug è presente
            2. se non è presente ritorno slo slug generato
            3. se è presente aggiungo un contatore
            4. se ancho col contatore è presente aggiungo +1 al contatore fino a trovare uno slug univoco
        */

        $slug_exixts = Post::where('slug', $slug)->first();
        $c = 1;
        while($slug_exixts){
            $slug = $original_slug . '-' . $c;
            $slug_exixts = Post::where('slug', $slug)->first();
            $c++;
        }

        return $slug;
    }
}
