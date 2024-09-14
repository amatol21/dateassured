<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('countries', function (Blueprint $table) {
            $table->string('code', 2)->unique();
            $table->string('locale', 2);
            $table->string('name');
            $table->primary('code');
            $table->index('name');
        });

        DB::table('countries')->insert([
            ['code' => 'AT', 'locale' => 'en', 'name' => 'Austria'],
            ['code' => 'AU', 'locale' => 'en', 'name' => 'Australia'],
            ['code' => 'GB', 'locale' => 'en', 'name' => 'England'],
            ['code' => 'DE', 'locale' => 'de', 'name' => 'Germany'],
            ['code' => 'GR', 'locale' => 'el', 'name' => 'Greece'],
            ['code' => 'IE', 'locale' => 'ga', 'name' => 'Ireland'],
            ['code' => 'IL', 'locale' => 'iw', 'name' => 'Israel'],
            ['code' => 'IT', 'locale' => 'it', 'name' => 'Italy'],
            ['code' => 'PL', 'locale' => 'pl', 'name' => 'Poland'],
            ['code' => 'PT', 'locale' => 'pt', 'name' => 'Portugal'],
            ['code' => 'ES', 'locale' => 'es', 'name' => 'Spain'],
            ['code' => 'SE', 'locale' => 'sv', 'name' => 'Sweden'],
            ['code' => 'CH', 'locale' => 'de', 'name' => 'Switzerland'],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('countries');
    }
};
