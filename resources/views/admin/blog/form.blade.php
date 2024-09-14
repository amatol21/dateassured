<?php

use App\Enums\Size;
use App\Models\Article;

/**
 * @var Article $article
 */
?>

@extends('admin.index')

@section('adminContent')
    <form action="{{ route('admin.blog.save', [], false) }}" class="pad" method="POST" id="article-form" enctype="multipart/form-data">
        @csrf

        <h2 class="account_title mb-2">
            <a href="{{ route('admin.blog', [], false) }}" class="admin_back-button">Blog</a>
            <span>{{ $article->exists ? $article->title : 'Article creation' }}</span>
        </h2>

        @if($article->exists)
            <input type="hidden" name="id" value="{{ $article->id }}">
        @endif

        <div class="pb-2 pl-2 pr-2">

            <div class="tabs">
                <div class="tab active" data-for="#article-general">General info</div>
                <div class="tab" data-for="#article-content">Content</div>
                <div class="tab" data-for="#article-meta">Meta information</div>
            </div>

            @if ($errors->any())
                <div class="errors mb-1 mt-1">
                    @foreach ($errors->all() as $error)
                        <div class="errors-item">{{ $error }}</div>
                    @endforeach
                </div>
            @endif

            <div id="article-general">
                <div class="mb-2">
                    @include('common.ui.imageInput', [
                        'value' => $article->getImageUrl(Size::LARGEST),
                        'ratio' => $article->getImageAspectRatio()
                    ])
                </div>

                <label>
                    <span class="label">Title</span>
                    <input type="text" name="title" class="input" value="{{ old('title', $article->title) }}">
                    @error('title')
                    <span class="error">{{ $message }}</span>
                    @enderror
                </label>

                <div class="mt-2"></div>

                <label>
                    <span class="label">Preview text</span>
                    <textarea name="snippet" class="input" rows="10">{{ old('snippet', $article->snippet) }}</textarea>
                    @error('snippet')
                    <span class="error">{{ $message }}</span>
                    @enderror
                </label>
            </div>

            <div id="article-content" style="display: none">
                <input type="hidden" name="content" id="article-data" value="{{ old('content', $article->content) }}">
                <div id="content-editor"></div>
            </div>

            <div id="article-meta" style="display: none">
                <label>
                    <span class="label">Meta title</span>
                    <input type="text" name="meta_title" class="input" value="{{ old('meta_title', $article->meta_title) }}">
                    @error('meta_title')
                    <span class="error">{{ $message }}</span>
                    @enderror
                </label>

                <div class="mt-2"></div>

                <label>
                    <span class="label">Meta description</span>
                    <textarea name="meta_description" class="input" rows="10">{{ old('meta_description', $article->meta_description) }}</textarea>
                    @error('meta_description')
                    <span class="error">{{ $message }}</span>
                    @enderror
                </label>

                <div class="mt-2"></div>

                <label>
                    <span class="label">Meta keywords (separated by comma)</span>
                    <textarea name="meta_keywords" class="input" rows="10">{{ old('meta_keywords', $article->meta_keywords) }}</textarea>
                    @error('meta_keywords')
                    <span class="error">{{ $message }}</span>
                    @enderror
                </label>
            </div>

        </div>

        <div class="p-2 flex jc-end">
            <button type="submit" class="btn btn-pink">{{ $article->exists ? 'Save' : 'Create' }}</button>
        </div>
    </form>

    <script>
        (() => {
            let contentEditor = null;
            let content = document.getElementById('article-data');
            let form = document.getElementById('article-form');

            ClassicEditor
                .create(document.getElementById('content-editor'), {
                    ckfinder: {
                        uploadUrl: '/api/upload/image'
                    },
                    heading: {
                        options: [
                            {model: 'paragraph', title: 'Paragraph', class: 'article_p'},
                            {model: 'heading1', view: 'h1', title: 'Heading 1', class: 'article_h1'},
                            {model: 'heading2', view: 'h2', title: 'Heading 2', class: 'article_h2'}
                        ]
                    }
                })
                .then(editor => {
                    contentEditor = editor;
                    editor.setData(content.value);
                })
                .catch(error => {
                    console.log(error);
                });


            form.addEventListener('submit', async e => {
                content.value = contentEditor.getData();
            });
        })();
    </script>

@endsection
