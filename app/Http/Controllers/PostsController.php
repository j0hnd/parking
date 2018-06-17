<?php

namespace App\Http\Controllers;

use App\Models\Posts;
use Illuminate\Http\Request;

class PostsController extends Controller
{
    public function index()
	{
		$page_title = "Posts";
		$posts = Posts::active()->paginate(config('app.item_per_page'));
		return view('app.Posts.index', compact('page_title', 'posts'));
	}

	public function create()
	{
		$page_title = "Create Posts";
		return view('app.Posts.create', compact('page_title'));
	}
}
