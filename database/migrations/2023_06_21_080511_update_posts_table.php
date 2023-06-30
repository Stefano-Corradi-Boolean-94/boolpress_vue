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
        Schema::table('posts', function (Blueprint $table) {

            //1. creo la colonna della FK
            $table->unsignedBigInteger('category_id')->nullable()->after('id');

            //2. assegno la FK alla colonna creata
            $table->foreign('category_id')
                    ->references('id')
                    ->on('categories')
                    ->onDelete('set null'); // se viene eliminta una categoria i post in relazione non vengono persi e avranno catrgory_id = null
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('posts', function (Blueprint $table) {

            //1. elimino la FK
            $table->dropForeign(['category_id']);
            //$table->dropForeign('posts_category_id_foreign');

            //2. elimino la colonna
            $table->dropColumn('category_id');
        });
    }
};
