<?php

use App\Http\Controllers\BlogCategoryController;
use App\Http\Controllers\BlogCommentController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\BlogPostController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LocalitiesController;
use App\Http\Controllers\NewLocalitiesController;
use App\Http\Controllers\OrganisationController;
use App\Http\Controllers\PestController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return Inertia::render('Welcome', [
//         'canLogin' => Route::has('login'),
//         'canRegister' => Route::has('register'),
//         'laravelVersion' => Application::VERSION,
//         'phpVersion' => PHP_VERSION,
//     ]);
// });

Route::get('/',  [HomeController::class, 'index'])->name('home');

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get( '/about', [HomeController::class, 'about'])->name('about');

Route::get( 'blog', [BlogController::class, 'show'])->name('blog');

Route::get('blog/category/{category}',[BlogCategoryController::class, 'show'])->name('blog.category');

Route::get('blog/allposts', [BlogPostController::class, 'allPosts'])->name('blog.posts');

Route::get('blog/page/{slug}', [BlogPostController::class, 'show'])->name('blog.page');

Route::put('/comment', [BlogCommentController::class, 'store'])->name('comment');

Route::get('/search/postcode/{postcode}/pest/{pestcode}', [OrganisationController::class, 'find'])->name('search');

Route::get( '/details/{organisation}/{external_id}',  [OrganisationController::class, 'show']);

Route::get('/pests',  [PestController::class, 'webIndex'])->name('pests');

Route::get('/pests/{pest}',  [PestController::class, 'show'])->name('pest');

// Route::get('/pest-controllers/{country?}/{region?}/{county?}/{town?}/{localityId?}', [LocalitiesController::class, 'organisations']);

/**
 * Search page (greedy) routes
 */
// Route::get('/pest-controllers/{country}/{region}/{county}/{town}/{localityId}', [LocalitiesController::class, 'withId']);

// Route::get('/pest-controllers/{country}/{region}/{county}/{town}/{localityId}', [LocalitiesController::class, 'town']);

// Route::get('/pest-controllers/{country}/{region}/{county}/{localityId}', [LocalitiesController::class, 'county']);

// Route::get('/pest-controllers/{country}/{region}/{localityId}', [LocalitiesController::class, 'region']);

// Route::get('/pest-controllers/{country}/{localityId}', [LocalitiesController::class, 'country']);

// Route::get('/pest-controllers/{string?}', [LocalitiesController::class, 'organisations']);

// Route::get('/expand-search', [LocalitiesController::class, 'expandSearch']);

// Blade routes
// Route::get('/blade-pest-controllers', function() {
//     return view('pages.search');
// });

Route::get('/pest-controllers/{country}/{region}/{county}/{town}/{localityId}', [NewLocalitiesController::class, 'town']);

Route::get('/pest-controllers/{country}/{region}/{county}/{localityId}', [NewLocalitiesController::class, 'county']);

Route::get('/pest-controllers/{country}/{region}/{localityId}', [NewLocalitiesController::class, 'region']);

Route::get('/pest-controllers/{country}/{localityId}', [NewLocalitiesController::class, 'country']);

Route::get('/pest-controllers/{string?}', [NewLocalitiesController::class, 'organisations']);

Route::get('/expand-search', [NewLocalitiesController::class, 'expandSearch'])->name('expand-search');

require __DIR__.'/auth.php';
