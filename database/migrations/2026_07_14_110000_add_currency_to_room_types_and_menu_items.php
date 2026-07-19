<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('room_types', function (Blueprint $table) {
            $table->string('currency', 3)->default('RWF')->after('price_per_night');
        });
        Schema::table('menu_items', function (Blueprint $table) {
            $table->string('currency', 3)->default('RWF')->after('price');
        });
    }

    public function down(): void
    {
        Schema::table('room_types', fn (Blueprint $table) => $table->dropColumn('currency'));
        Schema::table('menu_items', fn (Blueprint $table) => $table->dropColumn('currency'));
    }
};
