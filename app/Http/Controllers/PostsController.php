<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;

class PostsController extends Controller
{
    public function index()
	{
		$page_title = "Blog";
		$posts = Blog::active()->paginate(config('app.item_per_page'));
		return view('app.Posts.index', compact('page_title', 'posts'));
	}

	public function create()
	{
		return view('app.Posts.create');
	}
}
