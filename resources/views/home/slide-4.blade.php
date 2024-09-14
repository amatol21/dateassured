<?php

use App\Enums\ArticleStatus;
use App\Enums\ArticleType;
use App\Enums\Size;
use App\Models\Article;

/** @var Article $lastNews */
$lastNews = Article::where('type', ArticleType::NEWS->value)
    ->where('status', ArticleStatus::PUBLISHED->value)
    ->orderBy('id', 'desc')
    ->first();

/** @var Article $lastPost */
$lastPost = Article::where('type', ArticleType::POST->value)
    ->where('status', ArticleStatus::PUBLISHED->value)
    ->orderBy('id', 'desc')
    ->first();

?>

<div class="s4">
    <div class="width-limiter">
        <div class="s4_items">
            <div class="s4_news">
                <div class="s4_news_headline">
                    <div class="s4_news_title">News</div>
                    <a href="/news" class="btn-small btn-blue">More News</a>
                </div>
                @if($lastNews !== null)
                <div class="s4_news_banner">
                    <img src="{{ $lastNews->getImageUrl(Size::LARGE) }}" alt="News" class="s4_news_banner-img">
                    <div class="s4_news_banner-texts">
                        <div class="s4_news_banner-title">{{ $lastNews->title }}</div>
                        <div class="s4_news_banner-snippet">{{ $lastNews->snippet }}</div>
                    </div>
                </div>
            @endif
            </div>

            <div class="s4_blog">
                <div class="s4_blog_headline">
                    <div class="s4_blog_title">Blog</div>
                    <a href="/blog" class="btn-small btn-orange">More Blogs</a>
                </div>
                @if($lastPost !== null)
                <div class="s4_blog_banner">
                    <img src="{{ $lastPost->getImageUrl(Size::LARGE) }}" alt="News" class="s4_blog_banner-img">
                    <div class="s4_news_banner-texts">
                        <div class="s4_news_banner-title">{{ $lastPost->title }}</div>
                        <div class="s4_news_banner-snippet">{{ $lastPost->snippet }}</div>
                    </div>
                </div>
                @endif
            </div>

            <div class="s4_info">
                <div class="s4_info_title">Information</div>
                <div class="s4_info_links">
                    <a href="#" class="s4_info_link">Watch the video</a>
                    <a href="{{ route('aboutUs', [], false) }}" class="s4_info_link">Where am I? About the project</a>
                    <a href="{{ route('faq', [], false) }}" class="s4_info_link">FAQ</a>
                    <a href="{{ route('aboutUs', [], false) }}" class="s4_info_link">About Us</a>
                    <a href="{{ route('termsOfUse', [], false) }}" class="s4_info_link">Terms</a>
                </div>
            </div>
        </div>
    </div>
</div>
