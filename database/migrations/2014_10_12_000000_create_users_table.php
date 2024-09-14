<?php

use App\Enums\Gender;
use App\Enums\Purpose;
use App\Enums\Sexuality;
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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('social_id')->nullable()->default(null)->unique();
            $table->integer('role_id')->nullable()->unsigned()->default(null);
            $table->string('first_name');
            $table->string('second_name');
            $table->string('username');
            $table->text('photo_json')->default('');
            $table->tinyInteger('age')->unsigned()->default(18);
            $table->tinyInteger('gender')->default(Gender::MALE->value);
            $table->tinyInteger('sexuality')->default(Sexuality::STRAIGHT->value);
            $table->tinyInteger('purpose')->default(Purpose::CASUAL_FUN->value);
            $table->string('email')->unique();
            $table->timestamp('email_verification_sent_at')->nullable()->default(null);
            $table->string('email_verification_token')->nullable()->default(null);
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
