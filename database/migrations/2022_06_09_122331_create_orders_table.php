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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('fk_pigeon_id');
            $table->unsignedBigInteger('fk_user_id');
            $table->unsignedInteger('distance')->default(0)->comment('km');
            $table->decimal('price', 30);
            $table->timestamp('should_deliver_at')->nullable()->comment('deadline');
            $table->timestamp('delivered_at')->nullable();
            $table->char('status', 50)->nullable()->default('delivering');
            $table->timestamps();

            $table->index(['fk_pigeon_id', 'delivered_at'], 'pigeon_delivered_idx');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
};
