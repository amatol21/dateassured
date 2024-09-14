<?php

use App\Enums\UserStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function(Blueprint $table) {
            $table->tinyInteger('status')->unsigned()->default(UserStatus::ACTIVE->value);
            $table->timestamp('banned_to')->nullable()->default(null);
            $table->integer('activity')->unsigned()->default(0);
            $table->integer('money')->unsigned()->default(0);
            $table->index('status');
            $table->index('activity');
            $table->index('money');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function(Blueprint $table) {
            $table->dropColumn('status');
            $table->dropColumn('banned_to');
            $table->dropColumn('activity');
            $table->dropColumn('money');
        });
    }
};
