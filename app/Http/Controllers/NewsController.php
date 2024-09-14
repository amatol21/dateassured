<?php

namespace App\Http\Controllers;

use App\Enums\ArticleStatus;
use App\Enums\ArticleType;
use App\Helpers\Breadcrumbs;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\View\View;

class NewsController extends Controller
{
    public function index(): View
    {
        return view('news.index', [
            'articles' => Article::where('type', ArticleType::NEWS->value)
                ->where('status', ArticleStatus::PUBLISHED->value)
                ->orderBy('id', 'desc')
                ->paginate(10),
        ]);
    }

    public function article(Request $request, string $slug): View
    {
        Breadcrumbs::add('News', route('news', [], false));
        $article = Article::where('slug', $slug)->first();
        if ($article == null) abort(404);
        Breadcrumbs::add($article->title, route('news.article', ['slug' => $article->slug], false));
        return view('news.article', ['article' => $article]);
    }
}
