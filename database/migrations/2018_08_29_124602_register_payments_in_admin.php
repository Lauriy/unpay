<?php

use Illuminate\Database\Migrations\Migration;

class RegisterPaymentsInAdmin extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('admin_menu')->insert(
            [
                'id' => 8,
                'parent_id' => 2,
                'order' => 0,
                'title' => 'Payments',
                'icon' => 'fa-money',
                'uri' => 'payments'
            ]
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table('admin_menu')->delete(8);
    }
}
