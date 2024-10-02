<?php

use App\Enums\Size;
use App\Enums\ArticleStatus;
use App\Enums\ArticleType;
use App\Models\Article;
use Illuminate\Pagination\Paginator;

/**
 * @var $articles Article[]|Paginator
 */
?>

@extends('admin.index')

@section('adminContent')
	<div id="articles-list" class="articles-list pad">
		<h2 class="account_title mb-2">
			News
			<a href="{{ route('admin.news.create', [], false) }}" class="btn btn-pink btn-small ml-auto">Create
				news</a>
		</h2>
		<form action="{{ route('admin.news', [], false) }}" id="articles-filter" class="articles-filter mb-2 pl-2 pr-2">
			<select name="status" class="input input-small status-select">
				<option value="" @if(request()->get('status') === '') selected @endif>Any status</option>
				<option value="{{ ArticleStatus::PUBLISHED->value }}"
					@if(request()->get('status') === ''.ArticleStatus::PUBLISHED->value) selected @endif>Published
				</option>
				<option value="{{ ArticleStatus::NOT_PUBLISHED->value }}"
					@if(request()->get('status') === ''.ArticleStatus::NOT_PUBLISHED->value) selected @endif>Not
					published
				</option>
			</select>
			<input type="hidden" name="sorting" value="reg-date">
			<input type="text" name="title" placeholder="News title..." value="{{ request()->get('title', '') }}"
						class="input input-small">
			<button type="submit" class="btn btn-small btn-pink">Search</button>
		</form>

		@if($articles->count() > 0)
			<table id="articles-table" class="pl-2 pr-2 w-100">
				<thead>
				<tr>
					<th style="width: 4rem"></th>
					<th data-sort="title">Title</th>
					<th data-sort="author_id" class="center">Author</th>
					<th data-sort="status" class="center">Status</th>
					<th data-sort="created_at" class="center">Created</th>
					<th style="width: 3rem"></th>
				</tr>
				</thead>
				<tbody>
				@foreach($articles as $article)
					<tr data-id="{{ $article->id }}">

						<td>
							<img src="{{ $article->getImageUrl(Size::SMALLEST) }}" alt="News cover" width="80" height="40">
						</td>

						<td>
							<div class="articles_item_title">{{ $article->title }}</div>
						</td>

						<td class="center">
							{{ $article->author->getFullName() }}
						</td>

						<td class="center">
							<div class="articles_item_status status-{{ $article->status }}"
								title="{{ $article->status === ArticleStatus::PUBLISHED ? 'Published' : 'Not published' }}">
							</div>
						</td>

						<td class="center">
							{{ $article->created_at }}
						</td>

						<td>
							<div class="flex ai-center ml-auto">
								@php
									$payload = ['id' => $article->id, 'title' => $article->title];
									$options = [
										'edit-article' => ['label' => 'Edit', 'payload' => $payload],
										'delete-article' => ['label' => 'Delete', 'payload' => $payload],
									];
									if ($article->status === ArticleStatus::NOT_PUBLISHED) {
										$options['publish-article'] = ['label' => 'Publish', 'payload' => $payload];
									} else {
										$options['cancel-article-publication'] = ['label' => 'Cancel publication', 'payload' => $payload];
									}
								@endphp
								@include('common.ui.dotsMenu', ['options' => $options])
							</div>
						</td>
					</tr>
				@endforeach
				</tbody>
			</table>


			@if($articles->hasPages())
				<div class="p-2">
					{{ $articles->appends($_GET)->links('common.ui.pagination') }}
				</div>
			@endif

		@else

			<div class="no-data-msg">
				<div class="no-data-msg_title">Nothing found by your request</div>
				<div class="no-data-msg_hint">Try to change your request and try again.</div>
			</div>

		@endif
	</div>


	<script>
		(() => {
			initTableSorting('#articles-table', '#articles-filter');

			async function applyToArticle(articleId, action) {
				try {
					let data = {
						_token: '{{ csrf_token() }}',
						id: articleId,
					};
					let res = await fetch('/admin/news/' + action, {
						method: 'POST',
						body: JSON.stringify(data),
						headers: {'Content-Type': 'application/json'}
					});
					if (res.ok) {
						return true;
					}
				} catch (e) {
					console.error(e);
				}
				return false;
			}

			// Delete
			document.addEventListener('delete-article', async e => {
					if (confirm('Are you really want to delete article "' + (e.detail.title.slice(0, 50) + '...') + '"?')) {
						let res = await applyToArticle(e.detail.id, 'delete');
						if (res) window.location.reload();
					}
			});

			// Publish
			document.addEventListener('publish-article', async e => {
					if (confirm('Do you want to publish news "' + (e.detail.title.slice(0, 50) + '...') + '"?')) {
						let res = await applyToArticle(e.detail.id, 'publish');
						if (res) window.location.reload();
					}
			});

			// Cancel publication
			document.addEventListener('cancel-article-publication', async e => {
					//console.log('5');
					if (confirm('Do you want to cancel publication of news "' + (e.detail.title.slice(0, 50) + '...') + '"?')) {
						let res = await applyToArticle(e.detail.id, 'cancel-publication');
						if (res) window.location.reload();
					}
			});

			// Edit
			document.addEventListener('edit-article', async e => {
					window.location = '/admin/news/edit/' + e.detail.id;
			});
		})();
	</script>
@endsection
