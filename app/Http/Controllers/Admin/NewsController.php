<?php

namespace App\Http\Controllers\Admin;

use App\Enums\ArticleStatus;
use App\Enums\ArticleType;
use App\Filters\NewsFilter;
use App\Helpers\Toast;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ManageArticleRequest;
use App\Http\Requests\Admin\SaveArticleRequest;
use App\Models\Article;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\View\View;

class NewsController extends Controller
{
    public function list(Request $request): View
    {
        return view('admin.news.list', [
            'articles' => NewsFilter::createQuery($request)->paginate(25),
        ]);
    }

    public function editForm(Request $request, int $id): View
    {
        $article = Article::where('id', $id)->first();
        if ($article === null) abort(404);
        return view('admin.news.form', ['article' => $article]);
    }

    public function creationForm(Request $request): View
    {
        return view('admin.news.form', ['article' => new Article()]);
    }

    public function publish(ManageArticleRequest $request): Response
    {
        /** @var Article $article */
        $article = Article::where('id', $request->id)->first();
        if ($article === null) abort(404);
        $article->status = ArticleStatus::PUBLISHED->value;
        if ($article->save()) {
            Toast::success('The news has been successfully published.');
        } else {
            Toast::error('An error occurred on news publishing.');
        }
        return response('OK', 200);
    }

    public function cancelPublication(ManageArticleRequest $request): Response
    {
        /** @var Article $article */
        $article = Article::where('id', $request->id)->first();
        if ($article === null) abort(404);
        $article->status = ArticleStatus::NOT_PUBLISHED->value;
        if ($article->save()) {
            Toast::success('News publication has been successfully canceled.');
        } else {
            Toast::error('An error occurred on news publication cancel.');
        }
        return response('OK', 200);
    }

    public function delete(ManageArticleRequest $request): Response
    {
        /** @var Article $article */
        $article = Article::where('id', $request->id)->first();
        if ($article === null) abort(404);
        $article->status = ArticleStatus::DELETED->value;
        if ($article->save()) {
            Toast::success('The news has been successfully deleted.');
        } else {
            Toast::error('An error occurred on news deletion.');
        }
        return response('OK', 200);
    }

    public function save(SaveArticleRequest $request): RedirectResponse
    {
        $article = $request->has('id') ? Article::where('id', $request->id)->first() : new Article();
        if ($article === null) abort(404);

        $photoFile = $request->file('image');
        if ($photoFile !== null) {
            $article->setFromFile($photoFile);
        }

        $article->author_id = Auth::id();
        $article->title = $request->title;
        $article->slug = Str::slug($article->title);
        $article->snippet = $request->snippet;
        $article->content = $request->content;
        $article->meta_title = $request->post('meta_title', '');
        $article->meta_description = $request->post('meta_description', '');
        $article->meta_keywords = $request->post('meta_keywords', '');
        $article->type = ArticleType::NEWS->value;
        $creating = $article->exists;
        if ($article->save()) {
            Toast::success('Article '.$article->title.' successfully '.($creating ? 'saved.' : 'created.'));
        } else {
            Toast::error('Error occurred on processing your request.');
        }
        return redirect()->route('admin.news');
    }
}
