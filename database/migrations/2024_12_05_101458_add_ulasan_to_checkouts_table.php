<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('checkouts', function (Blueprint $table) {
            $table->text('ulasan')->nullable()->after('catatan_admin'); // Menambahkan kolom ulasan setelah catatan_admin
        });
    }

    public function down()
    {
        Schema::table('checkouts', function (Blueprint $table) {
            $table->dropColumn('ulasan');
        });
    }

};
