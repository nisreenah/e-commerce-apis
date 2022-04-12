<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stores', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('merchant_id')->constrained('users')->onDelete('RESTRICT')->onDelete('RESTRICT');
            $table->enum('is_VAT_included', [0, 1])->comment('1 = included, 0 = not included in the product price');
            $table->integer('VAT_percentage')->default(0)->comment('0 will be the default value if the is_VAT_included = 0');
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
        Schema::dropIfExists('stores');
    }
}
