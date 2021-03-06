<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateViolencemetersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('violencemeters', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->enum('risk_level', ['alert', 'reaction', 'urgent']);
            $table->longText('attention_route');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('violencemeters');
    }
}
