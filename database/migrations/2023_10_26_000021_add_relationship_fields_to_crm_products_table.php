<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToCrmProductsTable extends Migration
{
    public function up()
    {
        Schema::table('crm_products', function (Blueprint $table) {
            $table->unsignedBigInteger('product_category_id')->nullable();
            $table->foreign('product_category_id', 'product_category_fk_8355207')->references('id')->on('product_categories');
        });
    }
}
