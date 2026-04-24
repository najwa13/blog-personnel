<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function index(Request $request)
    {
        $query = Article::where('status', 'published')->with(['category', 'user']);

        if ($request->has('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        $articles = $query->latest()->get();
        $categories = Category::all();

        return view('articles.index', compact('articles', 'categories'));
    }

    public function show(Article $article)
    {
        if ($article->status !== 'published') {
            abort(404);
        }
        return view('articles.show', compact('article'));
    }


    // Liste complète pour le blogueur
    public function dashboard()
    {
        // On récupère uniquement les articles de l'utilisateur connecté
        $articles = Article::where('user_id', auth()->id())
            ->with('category')
            ->latest()
            ->get();

        return view('admin.dashboard', compact('articles'));
    }

    // Création
    public function create()
    {
        $categories = Category::all();
        return view('admin.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
            'category_id' => 'required|exists:categories,id',
            'status' => 'required|in:draft,published',
        ]);

        // On force l'ID de l'utilisateur connecté
        $validated['user_id'] = auth()->id();

        Article::create($validated);

        return redirect()->route('admin.dashboard')->with('success', 'Article créé !');
    }

    //Modification
    public function edit(Article $article)
    {
        // Sécurité : Vérifie que l'article appartient bien à l'utilisateur
        if ($article->user_id !== auth()->id()) {
            abort(403);
        }

        $categories = Category::all();
        return view('admin.edit', compact('article', 'categories'));
    }

    public function update(Request $request, Article $article)
    {
        if ($article->user_id !== auth()->id()) {
            abort(403);
        }

        $validated = $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
            'category_id' => 'required|exists:categories,id',
            'status' => 'required|in:draft,published',
        ]);

        $article->update($validated);

        return redirect()->route('admin.dashboard')->with('success', 'Article mis à jour !');
    }

    // Suppression
    public function destroy(Article $article)
    {
        if ($article->user_id !== auth()->id()) {
            abort(403);
        }

        $article->delete();

        return redirect()->route('admin.dashboard')->with('success', 'Article supprimé !');
    }
}
