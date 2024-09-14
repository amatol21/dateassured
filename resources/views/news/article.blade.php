<?php

use App\Enums\ArticleStatus;
use App\Enums\ArticleType;
use App\Enums\Size;
use App\Helpers\Breadcrumbs;
use \App\Models\Article;

/**
 * @var Article $article
 * @var Article[] $otherNews
 */

$otherNews = Article::where('type', ArticleType::NEWS)
    ->where('status', ArticleStatus::PUBLISHED)
    ->where('id', '!=', $article->id)
    ->orderBy('id', 'desc')
    ->limit(5)
    ->get();

?>


@extends('layouts.main')

@section('title'){{ $article->meta_title }}@endsection
@section('description'){{ $article->meta_description }}@endsection

@section('content')

    <style>
        .article {
            width: 50rem;
            max-width: 100%;
            flex-shrink: 0;
            flex-grow: 0;
            overflow: auto;
        }

        .news_section-title {
            font-weight: 500;
            font-size: 1.5rem;
            color: #333;
            margin-bottom: 1rem;
            border-bottom: 5px solid #ff458d;
            padding-bottom: 0.5rem;
            min-height: 3rem;
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
            padding-top: 30%;
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

        .article-wrap {
            display: flex;
            flex-wrap: wrap;
        }

        .other-articles {
            width: 15rem;
            margin-left: 1rem;
            flex-grow: 1;
            margin-bottom: auto;
        }

        .other-article {
            display: flex;
            flex-direction: column;
            text-decoration: none;
        }

        .other-article + .other-article {
            margin-top: 1rem;
            padding-top: 1rem;
            border-top: 1px solid #ccc;
        }

        .other-article_image-wrap {
            width: 100%;
            position: relative;
            margin-bottom: 0.5rem;
            border-radius: 0.25rem;
            background-color: #eee;
        }

        .other-article_image-wrap::before {
            content: '';
            display: block;
            width: 100%;
            padding-top: 50%;
        }

        .other-article_image {
            width: 100%;
            height: 100%;
            position: absolute;
            left: 0;
            top: 0;
            border-radius: 0.25rem;
        }

        .other-article_title {
            font-size: 0.8rem;
            font-weight: 500;
            color: #333;
        }

        .other-article_snippet {
            margin-top: 0.5rem;
            font-size: 0.75rem;
            color: #333;
        }

        .other-articles_title {
            font-weight: 500;
            font-size: 1.1rem;
            color: #333;
            padding-bottom: 0.5rem;
            border-bottom: 5px solid #ccc;
            margin-bottom: 1rem;
            padding-top: 1.5rem;
            height: 4rem;
        }
        @media (max-width: 600px) {
            .other-articles {
                margin-left: 0;
                margin-top: 1rem;
            }
            .article {
                padding: 1rem;
            }
        }
    </style>


    <div class="icons-bg">
        <div class="width-limiter">

            <div class="pt-1 pb-1 pl-2">
                <?= Breadcrumbs::render() ?>
            </div>


            <div class="article-wrap">
                <div class="article pad p-2">
                    <h1 class="news_section-title">{{ $article->title }}</h1>
                    <div class="news_image-wrap">
                        <img src="{{ $article->getImageUrl(Size::LARGEST) }}" alt="{{ $article->title }}"
                             class="news_image">
                    </div>
                    <div class="ck-content">{!! $article->content !!}</div>
                </div>

                <div class="other-articles pad p-1">
                    <div class="other-articles_title">Other news</div>
                    @foreach($otherNews as $news)
                        <a href="{{ route('news.article', ['slug' => $news->slug], false) }}" class="other-article">
                            <div class="other-article_image-wrap">
                                <img src="{{ $news->getImageUrl(Size::SMALL) }}" class="other-article_image"
                                     alt="{{ $news->title }}">
                            </div>
                            <div class="other-article_texts">
                                <div class="other-article_title">{{ $news->title }}</div>
                                <div class="other-article_snippet">{{ $news->snippet }}</div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>


        </div>
    </div>

@endsection
