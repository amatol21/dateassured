<?php

namespace App\Filters;

use App\Enums\ArticleStatus;
use App\Enums\ArticleType;
use App\Models\Article;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class BlogFilter extends AbstractFilter
{
    public static function createQuery(Request $request): Model|Builder
    {
        $query = Article::where('type', ArticleType::POST->value)
            ->where('status', '!=', ArticleStatus::DELETED->value);

        if ($request->has('title') && !empty($request->get('title'))) {
            $query->where('title', 'LIKE', $request->get('title').'%');
        }
        if ($request->has('status') && $request->get('status') !== null) {
            $status = ArticleStatus::from(intval($request->get('status')));
            $query->where('status', '=', $status->value);
        }

        $sort = $request->get('sort', '');
        $order = $request->get('order') === 'asc' ? 'asc' : 'desc';
        if ($sort === 'title') {
            $query->orderBy('title', $order);
        } else if ($sort === 'status') {
            $query->orderBy('status', $order);
        } else if ($sort === 'created_at') {
            $query->orderBy('created_at', $order);
        } else if ($sort === 'author_id') {
            $query->orderBy('author_id', $order);
        }

        return $query;
    }
}
