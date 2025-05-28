<?php

namespace App\Http\Controllers;

use App\Models\ArticleNews;

use App\Models\BannerAdvertisement;
use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;

class FrontController extends Controller
{
    public function index()
    {
        $categories = Category::all();

        $articles = ArticleNews::with(['category'])
            ->where('is_featured', 'not_featured')
            ->take(3)
            ->latest()
            ->get();

        $featured_articles = ArticleNews::with(['category'])
            ->where('is_featured', 'featured')
            ->take(3)
            ->inRandomOrder()
            ->get();

        $users = User::all();

        $bannerAds = BannerAdvertisement::where('is_active', 'active')
            ->where('type', 'banner')
            ->inRandomOrder()
            // ->take(1)
            ->first();

        $entertainment_articles = ArticleNews::whereHas('category', function ($query) {
            $query->where('name', 'Entertainment');
        })
            ->where('is_featured', 'not_featured')
            ->latest()
            ->take(6)
            ->get();

        $entertainment_featured_articles = ArticleNews::whereHas('category', function ($query) {
            $query->where('name', 'Entertainment');
        })
            ->where('is_featured', 'featured')
            ->inRandomOrder() // Mengganti isRandomOrder dengan inRandomOrder
            ->first();

        $business_articles = ArticleNews::whereHas('category', function ($query) {
            $query->where('name', 'Business');
        })
            ->where('is_featured', 'not_featured')
            ->latest()
            ->take(6)
            ->get();

        $business_featured_articles = ArticleNews::whereHas('category', function ($query) {
            $query->where('name', 'Business');
        })
            ->where('is_featured', 'featured')
            ->inRandomOrder()
            ->first();

        $health_articles = ArticleNews::whereHas('category', function ($query){
            $query->where('name', 'Health');
        })
            ->where('is_featured', 'not_featured')
            ->latest()
            ->take(6)
            ->get();


        $health_featured_articles = ArticleNews::whereHas('category', function ($query) {
            $query->where('name', 'Health');
        })
            ->where('is_featured', 'featured')
            ->inRandomOrder()
            ->first();

        $sport_articles = ArticleNews::whereHas('category', function ($query) {
            $query->where('name', 'Sport');
        })
            ->where('is_featured', 'not_featured')
            ->latest()
            ->take(6)
            ->get();

        $sport_featured_articles = ArticleNews::whereHas('category', function ($query) {
            $query->where('name', 'Sport');
        })
            ->where('is_featured', 'featured')
            ->inRandomOrder()
            ->first();

        return view('front.index', compact(
            'entertainment_featured_articles',
            'entertainment_articles',
            'business_articles',
            'business_featured_articles',
            'categories',
            'articles',
            'users',
            'featured_articles',
            'bannerAds'));
    }

    public function category (Category $category){ // menggunakan teknik model binding untuk menampilkan data per category
        $bannerAds = BannerAdvertisement::where('is_active', 'active')
            ->where('type', 'banner')
            ->inRandomOrder()
            // ->take(1)
            ->first();
        $categories= Category::all();
        return view('front.category', compact('category', 'categories', 'bannerAds'));
    }

    public function user (User $user){ // menggunakan teknik model binding untuk menampilkan data per user
        $bannerAds = BannerAdvertisement::where('is_active', 'active')
            ->where('type', 'banner')
            ->inRandomOrder()
            // ->take(1)
            ->first();
        $categories= Category::all();
        return view('front.user', compact('user', 'categories', 'bannerAds'));
    }

    public function search(Request $request)
    {
        $request->validate([
            'keyword' => ['required', 'string', 'max:255'],

        ]);

        $categories = Category::all();

        $keyword = $request->keyword;

        $articles = ArticleNews::with('category', 'user')
            ->where('name', 'like', '%' . $keyword . '%')->paginate(6);

            return view('front.search', compact('articles', 'categories', 'keyword'));
    }

    public function details(ArticleNews $articleNews)
    {
        $categories = Category::all();

        $articles = ArticleNews::with(['category'])
            ->where('is_featured', 'not_featured')
            ->where('id', '!=', $articleNews->id)
            ->take(3)
            ->latest()
            ->get();
        $bannerAds = BannerAdvertisement::where('is_active', 'active')
            ->where('type', 'banner')
            ->inRandomOrder()
            // ->take(1)
            ->first();

        return view('front.details', compact('articleNews', 'categories', 'bannerAds', 'articles'));
    }
}
