<?php

namespace App\Models;

use App\Enums\ArticleStatus;
use App\Enums\ArticleType;
use App\Enums\Size;
use App\Traits\ImageContainer;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property string $slug
 * @property string $title
 * @property string $snippet
 * @property string $content
 * @property int $author_id
 * @property ArticleStatus $status
 * @property ArticleType $type
 * @property string $image_json
 * @property string $meta_title
 * @property string $meta_description
 * @property string $meta_keywords
 * @property string $published_at
 * @property string $created_at
 * @property string $updated_at
 *
 * @property User $author
 */
class Article extends Model
{
    use ImageContainer;

    protected $casts = [
        'status' => ArticleStatus::class,
        'type' => ArticleType::class,
    ];

    /**
     * Configuration of the user's photo variants.
     * @return array<int, int>
     */
    protected function getImageSizes(): array
    {
        return [
            Size::SMALLEST->value => 120,
            Size::SMALL->value    => 240,
            Size::MEDIUM->value   => 480,
            Size::LARGE->value    => 800,
            Size::LARGEST->value  => 1200,
        ];
    }

    protected function getImagePathPrefix(): string
    {
        return 'articles';
    }

    protected function getImageFieldName(): string
    {;
        return 'image_json';
    }

    public function getDefaultImageUrl() : string
    {
        return '/images/article.png';
    }

    public function getImageAspectRatio(): float
    {
        return 2;
    }

    public function author(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'author_id');
    }

    public function getCreatedAtAttribute($date)
    {
        return Carbon::createFromFormat('Y-m-d H:i:s', $date)->format('d.m.Y H:i');
    }
}
