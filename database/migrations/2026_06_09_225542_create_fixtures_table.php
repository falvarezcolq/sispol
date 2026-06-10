<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('fixtures', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('country_id_1');
            $table->foreign('country_id_1')->references('id')->on('countries')->onDelete('cascade');
            $table->unsignedBigInteger('country_id_2');
            $table->foreign('country_id_2')->references('id')->on('countries')->onDelete('cascade');
            $table->unsignedBigInteger('group_id')->nullable();
            $table->foreign('group_id')->references('id')->on('groups');
            $table->dateTime('match_date');
            $table->integer('gol_1')->nullable();
            $table->integer('gol_2')->nullable();
            $table->boolean('played')->default(false);
            $table->boolean('penalties')->default(false);
            $table->integer('penalties_gol_1')->nullable();
            $table->integer('penalties_gol_2')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable();   
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fixtures');
    }
};
