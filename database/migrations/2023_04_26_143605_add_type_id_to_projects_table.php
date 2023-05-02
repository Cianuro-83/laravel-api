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
        Schema::table('projects', function (Blueprint $table) {
                // 1. aggiungo la colonna della foreingKey
                $table->unsignedBigInteger('type_id')->nullable()->after('id')->onDelete('CASCADE')->onUpdate('CASCADE');;

                // 2. creo la relazione tra la foreingKey e la PrimaryKey
                $table->foreign('type_id')->references('id')->on('types')->onDelete('CASCADE')->onUpdate('CASCADE');;
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('projects', function (Blueprint $table) {
               // 2. droppo la realzione tra le tabelle
            $table->dropForeign(['type_id']);

            // 1. droppo la colonna
            $table->dropColumn('type_id');
        });
    }
};