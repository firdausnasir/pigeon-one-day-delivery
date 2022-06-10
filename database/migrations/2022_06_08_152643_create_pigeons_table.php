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
        Schema::create('pigeons', function (Blueprint $table) {
            $table->id();
            $table->char('name');
            $table->unsignedInteger('speed')->comment('km/h');
            $table->unsignedInteger('range')->comment('km');
            $table->integer('cost')->comment('$2/km')->default(2);
            $table->boolean('is_available')->default(true);
            $table->integer('downtime')->comment('The time it needs to rest between two deliveries (hr)');
            $table->integer('delivery_before_downtime')->comment('How many delivery available before downtime');
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
        Schema::dropIfExists('pigeons');
    }
};
