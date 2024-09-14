<?php

use App\Enums\ArticleStatus;
use App\Enums\ArticleType;
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
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('author_id')->unsigned()->nullable(false);
            $table->string('slug')->nullable(false)->unique();
            $table->string('title');
            $table->string('snippet', 255);
            $table->text('content');
            $table->text('image_json')->default(null);
            $table->tinyInteger('status')->default(ArticleStatus::NOT_PUBLISHED->value);
            $table->tinyInteger('type')->default(ArticleType::NEWS->value);
            $table->string('meta_title')->nullable()->default(null);
            $table->string('meta_description')->nullable()->default(null);
            $table->string('meta_keywords')->nullable()->default(null);
            $table->timestamp('published_at')->nullable()->default(null);
            $table->timestamps();

            $table->index('author_id');
            $table->foreign('author_id')->references('id')->on('users')
                ->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('articles');
    }
};
