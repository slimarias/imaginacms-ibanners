<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNulablesBannersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::table('ibanners__banners', function (Blueprint $table) {
            $table->string('url')->nullable()->change();
            $table->text('code')->nullable()->change();
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ibanners__banners', function (Blueprint $table) {

            $table->dropForeign('url');
            $table->dropColumn('code');

        });
    }
}
