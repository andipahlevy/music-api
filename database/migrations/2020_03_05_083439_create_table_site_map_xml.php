<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableSiteMapXml extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('SITE_MAP', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('loc')->nullable();
            $table->dateTime('lastmod')->nullable();
            $table->string('changefreq',100)->nullable();
            $table->string('priority',10)->nullable();
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
        Schema::dropIfExists('SITE_MAP');
    }
}
