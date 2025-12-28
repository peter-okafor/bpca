<?php

namespace App\Http\Controllers;

use App\Exceptions\BlogException;
use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\BlogPost;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Inertia\Inertia;

class BlogController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        try {

            $categoriesQuery = Cache::remember("blog - categories", 1800, function ()
            {
                return BlogCategory::all();
            });

            $latestPostsQuery = Cache::remember("blog - recent - posts", 1800, function ()
            {
                return BlogPost::latest()->take(5)->get();
            });

            $latest20PostsQuery = Cache::remember("blog - recent - posts - 20", 1800, function ()
            {
                return BlogPost::latest()->take(20)->get();
            });

            $latestPosts = $latestPostsQuery ? $latestPostsQuery->toArray() : [];
            $latest20Posts = $latest20PostsQuery ? $latest20PostsQuery->toArray() : [];
            $categories = $categoriesQuery ? $categoriesQuery->toArray() : [];

            return Inertia::render('Blog/Home', [
                'latestPosts' => $latestPosts,
                'posts' => $latest20Posts,
                'categories' => $categories
            ]);
        } catch (Exception $e) {
            // Render error page
            return (new BlogException(
                $e->getCode(),
                $e->getMessage()
            ))->render();
            
        }
    }
}
