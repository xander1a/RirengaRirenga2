<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->string('currency', 3)->default('RWF')->after('total_amount');
        });

        // Backfill from each booking's room type currency.
        DB::statement('
            UPDATE bookings b
            JOIN rooms r ON r.id = b.room_id
            JOIN room_types rt ON rt.id = r.room_type_id
            SET b.currency = rt.currency
        ');
    }

    public function down(): void
    {
        Schema::table('bookings', fn (Blueprint $table) => $table->dropColumn('currency'));
    }
};
