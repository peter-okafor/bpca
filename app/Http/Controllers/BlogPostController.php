<?php

namespace App\Http\Controllers;

use App\Exceptions\BlogException;
use App\Models\BlogCategory;
use App\Models\BlogPost;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;

class BlogPostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\BlogPost  $blogPost
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        try {
            $validator = Validator::make(
                [
                    'article' => $request->route('slug')
                ],
                [
                    'article' => "required|string|exists:blog_posts,slug"
                ]
            )->validate();

            $name = $validator['article'];

            $query = Cache::remember("blog - post - $name", 1800, function () use ($name)
            {
                return BlogPost::where('slug', $name)->first();
            });

            $categoriesQuery = Cache::remember("blog - categories - 5", 1800, function ()
            {
                return BlogCategory::latest()->take(5)->get();
            });

            $postsQuery = Cache::remember("blog - recent - posts", 1800, function ()
            {
                return BlogPost::latest()->take(5)->get();
            });

            $relatedPostsQuery = Cache::remember("blog - related - posts - post - $name", 1800, function () use ($query)
            {
                if ($query) {
                    return $query->category->posts;
                }
                return [];
            });

            $post = $query ? $query->toArray() : [];
            $posts = $postsQuery ? $postsQuery->toArray() : [];
            $categories = $categoriesQuery ? $categoriesQuery->toArray() : [];
            $relatedPosts = $relatedPostsQuery ? $relatedPostsQuery->take(4)->toArray() : [];


            return Inertia::render('Blog/ContentPage', [
                'title' => $name,
                'post' => $post,
                'posts' => $posts,
                'categories' => $categories,
                'relatedPosts' => $relatedPosts
            ]);
        } catch (Exception $e) {
            // Render error page
            return (new BlogException(
                (int) $e->getCode(),
                $e->getMessage()
            ))->render();
            
        }
    }

    public function allPosts(Request $request)
    {
        try {
            $query = Cache::remember("allposts", 1800, function () {
                return BlogPost::all();
            });

            $categoriesQuery = Cache::remember("blog - categories", 1800, function () {
                return BlogCategory::all();
            });

            $category = $query ? $query->toArray() : [];
            $posts = $query ? $query->toArray() : [];
            $categories = $categoriesQuery ? $categoriesQuery->toArray() : [];

            return Inertia::render('Blog/AllPosts', [
                'category' => $category,
                'posts' => $posts,
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

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\BlogPost  $blogPost
     * @return \Illuminate\Http\Response
     */
    public function edit(BlogPost $blogPost)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\BlogPost  $blogPost
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, BlogPost $blogPost)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\BlogPost  $blogPost
     * @return \Illuminate\Http\Response
     */
    public function destroy(BlogPost $blogPost)
    {
        //
    }
}
