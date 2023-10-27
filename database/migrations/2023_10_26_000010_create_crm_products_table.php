<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCrmProductsTable extends Migration
{
    public function up()
    {
        Schema::create('crm_products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->boolean('product_active')->default(0)->nullable();
            $table->string('product_name');
            $table->string('product_code')->nullable();
            $table->decimal('unit_price', 15, 2)->nullable();
            $table->longText('description')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
