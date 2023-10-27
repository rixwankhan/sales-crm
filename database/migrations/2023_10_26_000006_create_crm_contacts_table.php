<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCrmContactsTable extends Migration
{
    public function up()
    {
        Schema::create('crm_contacts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('company')->nullable();
            $table->string('contact_first_name');
            $table->string('contact_last_name')->nullable();
            $table->string('contact_phone_1')->nullable();
            $table->string('contact_phone_2')->nullable();
            $table->string('contact_email')->nullable();
            $table->string('contact_address')->nullable();
            $table->string('contact_description')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
