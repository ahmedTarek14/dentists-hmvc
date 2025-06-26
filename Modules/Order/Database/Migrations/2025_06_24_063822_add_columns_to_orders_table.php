<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsToOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */  public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            // إعادة تسمية user_id إلى requester_id
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
            $table->foreignId('requester_id')->constrained('users')->onDelete('cascade')->after('id');

            // إضافة الشخص اللي الطلب اتطلب منه
            $table->foreignId('provider_id')->nullable()->constrained('users')->onDelete('set null')->after('requester_id');

            // إضافة الأسعار
            $table->decimal('product_price', 8, 2)->nullable()->after('work_id');
            $table->decimal('shipping_fees', 8, 2)->nullable()->after('product_price');
            $table->decimal('total_price', 8, 2)->nullable()->after('shipping_fees');

            // المدن: من وإلى
            $table->foreignId('city_from_id')->nullable()->constrained('cities')->onDelete('set null')->after('shipping_fees');
            $table->foreignId('city_to_id')->constrained('cities')->onDelete('cascade')->after('city_from_id');

            // رقم الخدمة
            $table->string('service_number')->unique()->nullable()->after('id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {

            $table->dropForeign(['provider_id']);
            $table->dropColumn('provider_id');

            $table->dropForeign(['city_from_id']);
            $table->dropColumn('city_from_id');

            $table->dropForeign(['city_to_id']);
            $table->dropColumn('city_to_id');

            $table->dropColumn(['product_price', 'shipping_fees', 'total_price', 'service_number']);
        });
    }
}
