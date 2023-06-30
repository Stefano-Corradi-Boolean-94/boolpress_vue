<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('post_tag', function (Blueprint $table) {

            // relazione con la tabella posts
            // creo la colonna
            $table->unsignedBigInteger('post_id');
            // creo la FK
            $table->foreign('post_id')
                    ->references('id')
                    ->on('posts')
                    ->cascadeOnDelete(); //  all'eleiminazione di un post viene anche eliminata la relazione col tag

            // relazione con la tabella tags
            // creo la colonna
            $table->unsignedBigInteger('tag_id');
            // creo la FK
            $table->foreign('tag_id')
                    ->references('id')
                    ->on('tags')
                    ->cascadeOnDelete(); //  all'eleiminazione di un tag viene anche eliminata la relazione col post

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('post_tag');
    }
};
