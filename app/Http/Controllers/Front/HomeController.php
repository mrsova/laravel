<?php

namespace App\Http\Controllers\Front;

use App\Category;
use App\Tag;
use function compact;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Post;
use function view;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::paginate(2);
        $popularPosts = Post::orderBy('views', 'desc')->take(3)->get();
        $featuredPosts = Post::where('is_featured', 1)->take(3)->get();
        $recentPosts = Post::orderBy('date', 'desc')->take(4)->get();
        $categories = Category::all();
        return view('front.index', compact('posts','popularPosts','featuredPosts','recentPosts','categories'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $post = Post::where('slug', $slug)->firstOrFail();
        return view('front.show', compact('post'));
    }

    /**
     * Получить страницу с постами по тегу
     * @param $slug
     */
    public function tag($slug)
    {
        $tag = Tag::where('slug', $slug)->firstOrFail();
        $posts = $tag->posts()->paginate(2);

        return view('front.list', compact('posts'));
    }

    /**
     * Получить страницу с постами по категории
     * @param $slug
     */
    public function category($slug)
    {
        $category = Category::where('slug', $slug)->firstOrFail();
        $posts = $category->posts()->paginate(2);

        return view('front.list', compact('posts'));
    }

}
