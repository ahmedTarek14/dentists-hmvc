<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedBigInteger('district_id')->nullable()->after('city_id');
            $table->foreign('district_id')->references('id')->on('districts')->onDelete('set null');

            $table->string('address')->nullable()->after('district_id');
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['district_id']);
            $table->dropColumn(['district_id', 'address']);
        });
    }
};
