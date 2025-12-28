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

class BlogCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $blogCategories = BlogCategory::all();

        // return Inertia::render('Blog/CategoryPage', [
        //     'categories' => $blogCategories,
        // ]);
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
     * @param  \App\Models\BlogCategory  $blogCategory
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        try {
            $validator = Validator::make(
                [
                    'category' => $request->route('category')
                ],
                [
                    'category' => "required|string|exists:blog_categories,name"
                ]
            )->validate();

            $name = $validator['category'];

            $query = Cache::remember("blog - category - $name", 1800, function () use ($name)
            {
                return BlogCategory::where('name', $name)->first();
            });

            $categoriesQuery = Cache::remember("blog - categories", 1800, function ()
            {
                return BlogCategory::all();
            });

            $category = $query ? $query->toArray() : [];
            $posts = $query ? $query->posts->toArray() : [];
            $categories = $categoriesQuery ? $categoriesQuery->toArray() : [];



            return Inertia::render('Blog/CategoryPage', [
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
     * @param  \App\Models\BlogCategory  $blogCategory
     * @return \Illuminate\Http\Response
     */
    public function edit(BlogCategory $blogCategory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\BlogCategory  $blogCategory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, BlogCategory $blogCategory)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\BlogCategory  $blogCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(BlogCategory $blogCategory)
    {
        //
    }
}
