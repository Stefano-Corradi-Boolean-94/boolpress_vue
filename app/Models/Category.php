<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name','slug'];

    // relazione con la tabella posts
    // ogni categoria ha tanti post quindi la funzione è al plurale
    // "ho tanto posts"
    public function posts(){
        return $this->hasMany(Post::class);
    }
}
