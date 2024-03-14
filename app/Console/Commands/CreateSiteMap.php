<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Category;
use App\Models\Genre;
use App\Models\Country;
use App\Models\Movie;
use App\Models\Episode;
use App\Models\MovieGenre;
use App\Models\Rating;
// use Facade\FlareClient\Stacktrace\File;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use File;
use Illuminate\Support\Facades\App;

class CreateSiteMap extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sitemap:create';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $sitemap = App::make('sitemap');
        // add home pages mặc định
        $sitemap->add(route('homepage'), Carbon::now('Asia/Ho_Chi_Minh'), '1.0', 'daily');

        // phim
        $movie = Movie::orderBy('id','DESC')->get();
        foreach($movie as $mov) {
            $sitemap->add(env('APP_URL'). "/phim/{$mov->slug}", Carbon::now('Asia/Ho_Chi_Minh'),'0.9','daily');
        }

        // $movie_episode = Movie::orderBy('id','DESC')->get();
        // $episode = Episode::all();
        // foreach($movie_episode as $mov_ep) {
        //     foreach ($episode as $ep) {
        //         if ($mov_ep->id == $ep->movie_id) {
        //             $sitemap->add(env('APP_URL'). "/xem-phim/{$mov_ep->slug}/tap-{$ep->episode}", Carbon::now('Asia/Ho_Chi_Minh'),'0.8','daily');
        //         }
        //     }
        // }

        // Post
        $genre = Genre::orderBy('id','DESC')->get();
        foreach($genre as $gen) {
            $sitemap->add(env('APP_URL'). "/the-loai/{$gen->slug}", Carbon::now('Asia/Ho_Chi_Minh'),'0.7','daily');
        }

        $category = Category::orderBy('id','DESC')->get();
        foreach($category as $cate) {
            $sitemap->add(env('APP_URL'). "/danh-muc/{$cate->slug}", Carbon::now('Asia/Ho_Chi_Minh'),'0.7','daily');
        }

        $country = Country::orderBy('id','DESC')->get();
        foreach($country as $coun) {
            $sitemap->add(env('APP_URL'). "/quoc-gia/{$coun->slug}", Carbon::now('Asia/Ho_Chi_Minh'),'0.7','daily');
        }

        $years = range(Carbon::now('Asia/Ho_Chi_Minh')->year, 2020);
        foreach($years as $year) {
            $sitemap->add(env('APP_URL'). "/nam/{$year}", Carbon::now('Asia/Ho_Chi_Minh'),'0.6','daily');
        }
        
        // tạp file
        $sitemap->store('xml', 'sitemap');
        if (File::exists(public_path() . '/sitemap.xml')) {
            File::copy(public_path('sitemap.xml'),base_path('sitemap.xml'));
        }
    }
}
