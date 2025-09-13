<?php

namespace Modules\User;

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('district_id')
                ->nullable()
                ->constrained('districts')
                ->onDelete('set null')
                ->after('city_id');

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
