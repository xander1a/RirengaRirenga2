<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('page_contents', function (Blueprint $table) {
            $table->id();
            $table->string('page'); // home, about, services
            $table->string('section'); // hero, intro, cta, etc.
            $table->string('key');
            $table->longText('value')->nullable();
            $table->longText('value_fr')->nullable();
            $table->unique(['page', 'section', 'key']);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('page_contents');
    }
};
