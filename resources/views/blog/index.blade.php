<?php

use App\Enums\Size;
use \App\Models\Article;
use Illuminate\Pagination\Paginator;

/**
 * @var Article[]|Paginator $articles
 */

?>


@extends('layouts.main')

@section('title')
    DateAssured | Blog
@endsection

@section('content')
    <style>
        .news_section-title {
            font-weight: 500;
            font-size: 1.75rem;
            color: #333;
            margin-bottom: 1rem;
            border-bottom: 5px solid #ff458d;
            padding-bottom: 0.5rem;
        }

        .news {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(25rem, 1fr));
            gap: 1rem;
        }

        .news_item {
            display: flex;
            flex-direction: column;
        }

        .news_image-wrap {
            width: 100%;
            position: relative;
            margin-bottom: 1rem;
            background-color: #eee;
            border-radius: 0.25rem;
        }

        .news_image-wrap::before {
            content: '';
            display: block;
            width: 100%;
            padding-top: 50%;
        }

        .news_image {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 0.25rem;
        }

        .news_title {
            font-weight: 500;
            font-size: 1.1rem;
            margin-bottom: 1rem;
            color: #333;
        }

        .news_snippet {
            font-size: 0.9rem;
            color: #333;
            margin-bottom: 2rem;
        }

        .news_read-more-btn {
            margin-top: auto;
            margin-left: auto;
            text-decoration: none;
            height: 2.5rem;
            display: flex;
            align-items: center;
            background-color: transparent;
            padding: 0 1rem;
            border-radius: 0.25rem;
            color: #333;
            cursor: pointer;
            border: 2px solid #ccc;
            transition: background-color 150ms;
        }

        .news_read-more-btn:hover {
            background-color: #eee;
        }
    </style>

    <div class="icons-bg pt-3">
        <div class="width-limiter">
            <h1 class="news_section-title">Blog</h1>
            <div class="news">

                @foreach($articles as $article)
                    <div class="news_item pad p-2">
                        <div class="news_image-wrap">
                            <img src="{{ $article->getImageUrl(Size::LARGE) }}" alt="{{ $article->title }}"
                                 class="news_image">
                        </div>
                        <div class="news_title">{{ $article->title }}</div>
                        <div class="news_snippet">{{ $article->snippet }}</div>
                        <a href="{{ route('blog.post', ['slug' => $article->slug], false) }}"
                           class="news_read-more-btn">Read more...</a>
                    </div>
                @endforeach
            </div>

            @if($articles->hasPages())
                <div class="p-2">
                    {{ $articles->appends($_GET)->links('common.ui.pagination') }}
                </div>
            @endif
        </div>
    </div>
@endsection
