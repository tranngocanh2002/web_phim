<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomePageController;
use App\Http\Controllers\HomeController;
//admin controller
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\GenreController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\EpisodeController;
use App\Http\Controllers\InfoController;
use App\Http\Controllers\LinkMovieController;
use App\Http\Controllers\LeechMovieController;
use Illuminate\Support\Facades\Artisan;

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

//Route::get('/',);
Route::get('/', [HomePageController::class, 'home'])->name('homepage');
Route::get('/danh-muc/{slug}', [HomePageController::class, 'category'])->name('category');
Route::get('/the-loai/{slug}', [HomePageController::class, 'genre'])->name('genre');
Route::get('/quoc-gia/{slug}', [HomePageController::class, 'country'])->name('country');
Route::get('/phim/{slug}', [HomePageController::class, 'movie'])->name('movie');
Route::get('/xem-phim/{slug}/{tap}/{server_active}', [HomePageController::class, 'watch'])->name('watch');
Route::get('/so-tap', [HomePageController::class, 'episode'])->name('so-tap');
Route::get('/nam/{year}', [HomePageController::class, 'year']);
Route::get('/tag/{tag}', [HomePageController::class, 'tag']);
Route::get('/search', [HomePageController::class, 'search'])->name('search');
Route::get('/filter', [HomePageController::class, 'filter'])->name('filter');
Route::post('/add-rating', [HomePageController::class, 'add_rating'])->name('add-rating');


Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');

//Admin
Route::resource('category',CategoryController::class);
Route::resource('genre', GenreController::class);
Route::resource('country',CountryController::class);
Route::resource('episode',EpisodeController::class);
Route::resource('movie', MovieController::class);
Route::resource('leech_movie', LeechMovieController::class);
Route::get('add-episode/{id}', [EpisodeController::class,'add_episode'])->name('add-episode');
Route::get('select-movie', [EpisodeController::class,'select_movie'])->name('select-movie');
Route::get('/update-year-phim', [MovieController::class, 'update_year']);
Route::get('/update-topview-phim', [MovieController::class, 'update_topview']);
Route::post('/filter-topview-phim', [MovieController::class, 'filter_topview']);
Route::get('/filter-topview-default', [MovieController::class, 'filter_default']);
Route::get('/update-season-phim', [MovieController::class, 'update_season']);
Route::resource('info',InfoController::class);
Route::resource('linkmovie',LinkMovieController::class);
Route::get('leech-movie', [LeechMovieController::class,'leech_movie'])->name('leech-movie');
Route::get('leech-detail/{slug}', [LeechMovieController::class,'leech_detail'])->name('leech-detail');
Route::post('leech-store/{slug}', [LeechMovieController::class,'leech_store'])->name('leech-store');
Route::get('leech-episode/{slug}', [LeechMovieController::class,'leech_episode'])->name('leech-episode');
Route::post('leech-episode-store/{slug}', [LeechMovieController::class,'leech_episode_store'])->name('leech-episode-store');
Route::post('leech-episode-update/{slug}', [LeechMovieController::class,'leech_episode_update'])->name('leech-episode-update');
Route::post('leech_add_movie', [LeechMovieController::class,'leech_add_movie'])->name('leech_add_movie');




// Thay đổi theo ajax
Route::get('/category-select', [MovieController::class,'category_select'])->name('category-select');
Route::get('/country-select', [MovieController::class,'country_select'])->name('country-select');
Route::get('/status-select', [MovieController::class,'status_select'])->name('status-select');
Route::get('/type-select', [MovieController::class,'type_select'])->name('type-select');
Route::get('/phim_hot-select', [MovieController::class,'phim_hot_select'])->name('phim_hot-select');
Route::get('/resolution-select', [MovieController::class,'resolution_select'])->name('resolution-select');
Route::get('/sub-select', [MovieController::class,'sub_select'])->name('sub-select');

// Post
Route::post('/update-image-movie-ajax', [MovieController::class,'update_image_movie_ajax'])->name('update-image-movie-ajax');


Route::get('/c_u_sitemap', function(){
    return Artisan::call('sitemap:create');
});
Route::get('/cronjob', function(){
    return Artisan::call('cronjob:create');
});