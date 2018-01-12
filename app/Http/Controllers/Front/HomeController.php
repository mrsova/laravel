<?php

namespace App\Http\Controllers\Front;

use App\Category;
use App\Tag;
use function compact;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Post;
use Illuminate\Support\Facades\Auth;
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
        return view('front.index')->with('posts', $posts);
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
