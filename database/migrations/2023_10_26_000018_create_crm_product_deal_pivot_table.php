<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCrmProductDealPivotTable extends Migration
{
    public function up()
    {
        Schema::create('crm_product_deal', function (Blueprint $table) {
            $table->unsignedBigInteger('deal_id');
            $table->foreign('deal_id', 'deal_id_fk_8391512')->references('id')->on('deals')->onDelete('cascade');
            $table->unsignedBigInteger('crm_product_id');
            $table->foreign('crm_product_id', 'crm_product_id_fk_8391512')->references('id')->on('crm_products')->onDelete('cascade');
        });
    }
}
