<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToDealsTable extends Migration
{
    public function up()
    {
        Schema::table('deals', function (Blueprint $table) {
            $table->unsignedBigInteger('contact_name_id')->nullable();
            $table->foreign('contact_name_id', 'contact_name_fk_8391507')->references('id')->on('crm_contacts');
            $table->unsignedBigInteger('source_id')->nullable();
            $table->foreign('source_id', 'source_fk_8391682')->references('id')->on('deal_sources');
            $table->unsignedBigInteger('stage_id')->nullable();
            $table->foreign('stage_id', 'stage_fk_8391508')->references('id')->on('deal_stages');
            $table->unsignedBigInteger('created_by_id')->nullable();
            $table->foreign('created_by_id', 'created_by_fk_9147978')->references('id')->on('users');
        });
    }
}
