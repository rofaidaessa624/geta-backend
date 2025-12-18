<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ArticleController extends Controller
{
    /** ========== Admin: list all articles ========== */
    public function index()
    {
        $articles = Article::orderBy('sort_order')
            ->orderByDesc('created_at')
            ->get();

        return response()->json([
            'success' => true,
            'message' => 'Articles fetched successfully.',
            'data'    => ['articles' => $articles],
            'errors'  => null,
        ]);
    }

    /** ========== Admin: show single article by ID ========== */
    public function show($id)
    {
        $article = Article::find($id);

        if (! $article) {
            return response()->json([
                'success' => false,
                'message' => 'Article not found.',
                'data'    => null,
                'errors'  => null,
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Article fetched successfully.',
            'data'    => $article,
            'errors'  => null,
        ]);
    }

    /** ========== Admin: create article ========== */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title_ar'     => ['required', 'string', 'max:255'],
            'title_en'     => ['required', 'string', 'max:255'],
            'slug'         => ['nullable', 'string', 'max:255', 'unique:articles,slug'],
            'summary_ar'   => ['nullable', 'string'],
            'summary_en'   => ['nullable', 'string'],
            'body_ar'      => ['nullable', 'string'],
            'body_en'      => ['nullable', 'string'],
            'image_url'    => ['nullable', 'string', 'max:500'],
            'sort_order'   => ['nullable', 'integer'],
            'is_published' => ['nullable', 'boolean'],
        ]);

        // لو الـ slug مش مبعوت، نولده من العنوان الإنجليزي
        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['title_en']);
        }

        // Published At
        if (! empty($validated['is_published']) && $validated['is_published']) {
            $validated['published_at'] = now();
        }

        $article = Article::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Article created successfully.',
            'data'    => $article,
            'errors'  => null,
        ], 201);
    }

    /** ========== Admin: update article ========== */
    public function update(Request $request, $id)
    {
        $article = Article::find($id);

        if (! $article) {
            return response()->json([
                'success' => false,
                'message' => 'Article not found.',
                'data'    => null,
                'errors'  => null,
            ], 404);
        }

        $validated = $request->validate([
            'title_ar'     => ['sometimes', 'required', 'string', 'max:255'],
            'title_en'     => ['sometimes', 'required', 'string', 'max:255'],
            'slug'         => ['nullable', 'string', 'max:255', 'unique:articles,slug,' . $article->id],
            'summary_ar'   => ['nullable', 'string'],
            'summary_en'   => ['nullable', 'string'],
            'body_ar'      => ['nullable', 'string'],
            'body_en'      => ['nullable', 'string'],
            'image_url'    => ['nullable', 'string', 'max:500'],
            'sort_order'   => ['nullable', 'integer'],
            'is_published' => ['nullable', 'boolean'],
        ]);

        if (array_key_exists('slug', $validated) && empty($validated['slug'])) {
            // لو بعتي slug فاضي، نولده من العنوان
            $validated['slug'] = Str::slug($validated['title_en'] ?? $article->title_en);
        }

        // تحديث published_at بناءً على is_published
        if (array_key_exists('is_published', $validated)) {
            if ($validated['is_published'] && ! $article->published_at) {
                $validated['published_at'] = now();
            } elseif (! $validated['is_published']) {
                $validated['published_at'] = null;
            }
        }

        $article->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Article updated successfully.',
            'data'    => $article,
            'errors'  => null,
        ]);
    }

    /** ========== Admin: delete article ========== */
    public function destroy($id)
    {
        $article = Article::find($id);

        if (! $article) {
            return response()->json([
                'success' => false,
                'message' => 'Article not found.',
                'data'    => null,
                'errors'  => null,
            ], 404);
        }

        $article->delete();

        return response()->json([
            'success' => true,
            'message' => 'Article deleted successfully.',
            'data'    => null,
            'errors'  => null,
        ]);
    }

    /** ========== Public: list published articles (for website) ========== */
    public function publicIndex()
    {
        $articles = Article::where('is_published', true)
            ->orderBy('sort_order')
            ->orderByDesc('published_at')
            ->get([
                'id',
                'title_ar',
                'title_en',
                'slug',
                'summary_ar',
                'summary_en',
                'image_url',
                'published_at',
            ]);

        return response()->json([
            'success' => true,
            'message' => 'Published articles fetched successfully.',
            'data'    => ['articles' => $articles],
            'errors'  => null,
        ]);
    }

    /** ========== Public: show article by slug ========== */
    public function publicShow($slug)
    {
        $article = Article::where('slug', $slug)
            ->where('is_published', true)
            ->first();

        if (! $article) {
            return response()->json([
                'success' => false,
                'message' => 'Article not found.',
                'data'    => null,
                'errors'  => null,
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Article fetched successfully.',
            'data'    => $article,
            'errors'  => null,
        ]);
    }
}
