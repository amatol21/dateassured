<?php

namespace App\Http\Controllers;

use App\Enums\ArticleStatus;
use App\Enums\ArticleType;
use App\Helpers\Breadcrumbs;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BlogController extends Controller
{
    public function index(): View
    {
        return view('blog.index', [
            'articles' => Article::where('type', ArticleType::POST->value)
                ->where('status', ArticleStatus::PUBLISHED->value)
                ->orderBy('id', 'desc')
                ->paginate(10),
        ]);
    }

    public function post(Request $request, string $slug): View
    {
        Breadcrumbs::add('Blog', route('blog', [], false));
        $article = Article::where('slug', $slug)->first();
        Breadcrumbs::add($article->title, route('blog.post', ['slug' => $article->slug], false));
        if ($article == null) abort(404);
        return view('blog.article', ['article' => $article]);
    }
}
