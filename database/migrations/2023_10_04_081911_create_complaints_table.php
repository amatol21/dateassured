<?php

use App\Enums\ComplaintCategory;
use App\Enums\ComplaintStatus;
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
        Schema::create('complaints', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('category')->unsigned()->default(ComplaintCategory::VIDEO_SESSION->value);
            $table->bigInteger('creator_id')->unsigned()->nullable(false);
            $table->bigInteger('resolver_id')->unsigned()->nullable()->default(null);
            $table->bigInteger('video_session_id')->unsigned()->nullable()->default(null);
            $table->string('subject');
            $table->text('message');
            $table->tinyInteger('status')->unsigned()->default(ComplaintStatus::NEW->value);
            $table->timestamp('resolved_at')->nullable()->default(null);
            $table->timestamps();

            $table->index('video_session_id');

            $table->foreign('creator_id')->references('id')->on('users')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->foreign('resolver_id')->references('id')->on('users')
                ->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('complaints');
    }
};
