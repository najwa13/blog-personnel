<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Article;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        $user =User::factory()->create([
            'name' => 'najwa',
            'email' => 'najwa@email.com',
            'password' => bcrypt('123456'),
        ]); 
        $laravel = Category::create(['name' => 'Laravel']);
        $securite = Category::create(['name' => 'Sécurité']);
        $ia = Category::create(['name' => 'Intelligence Artificielle']);
        $database = Category::create(['name' => 'Base de Données']);

        Article::create([
            'title' => 'Les nouveautés de Laravel 13',
            'content' => 'On explore les nouvelles fonctionnalités du framework cette année...',
            'status' => 'published',
            'category_id' => $laravel->id,
            'user_id' => $user->id,
        ]);

        Article::create([
            'title' => 'Protéger son application des failles SQL',
            'content' => 'Guide pratique pour sécuriser vos requêtes et vos formulaires.',
            'status' => 'published',
           'category_id' => $securite->id,
           'user_id' => $user->id,
        ]);

        Article::create([
            'title' => 'Optimiser ses index MySQL',
            'content' => 'Comment accélérer vos recherches en base de données.',
            'status' => 'draft',
            'category_id' => $database->id,
            'user_id' => $user->id,
        ]);

        Article::create([
            'title' => 'Intégrer l’API Gemini dans Laravel',
            'content' => 'Ajouter de l’intelligence artificielle à vos projets PHP.',
            'status' => 'published',
            'category_id' => $ia->id,
            'user_id' => $user->id,
        ]);

        Article::create([
            'title' => 'Gérer les relations Many-to-Many',
            'content' => 'Tout comprendre sur les tables de pivot dans Eloquent.',
            'status' => 'published',
            'category_id' => $laravel->id,
            'user_id' => $user->id,
        ]);

        Article::create([
            'title' => 'L’avenir de l’IA dans le développement web',
            'content' => 'Réflexion sur l’évolution de notre métier de développeur.',
            'status' => 'draft',
            'category_id' => $ia->id,
            'user_id' => $user->id,
        ]);

    }
    
}
