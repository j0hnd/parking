<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostsFormRequest;
use App\Models\Posts;
use Sentinel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Intervention\Image\ImageManagerStatic as Image;


class PostsController extends Controller
{
    public function index()
	{
		$page_title = "Posts";
		$posts = Posts::active()->orderBy('created_at', 'desc')->paginate(config('app.item_per_page'));
		return view('app.Posts.index', compact('page_title', 'posts'));
	}

	public function create()
	{
		$page_title = "Create Posts";
		return view('app.Posts.create', compact('page_title'));
	}

	public function store(PostsFormRequest $request)
	{
		$current = Carbon::now();

		if ($request->isMethod('post')) {
			$form = $request->only(['title', 'content']);
			$form['slug'] = str_slug($form['title']);
			$form['status'] = 'draft';
			$form['created_by'] = Sentinel::getUser()->id;

			$path = 'uploads/posts/' . $current->format('Y-m-d');

			if ($post = Posts::create($form)) {
				if ($request->hasFile('image')) {
					$image = \Request::file('image');
					$filename   = $image->getClientOriginalName();
					$image_path = "{$path}/".$post->id;

					// check if upload folder is existing, if not create it
					if (!File::exists(public_path($path))) {
						File::makeDirectory(public_path($path));
					}

					if (!File::exists(public_path($image_path))) {
						File::makeDirectory(public_path($image_path));
					}

					$image_resize = Image::make($image->getRealPath());
					$image_resize->resize(350, 253);
					$image_resize->save(public_path("{$image_path}/{$filename}"));
					Posts::where('id', $post->id)->update(['image' => $image_path."/".$filename]);
				}

				return back()->with('success', 'Post has been saved');
			} else {
				return back()->withErrors(['error' => 'Unable to save post']);
			}
		} else {
			return back()->withErrors(['error' => 'Invalid request']);
		}
	}

	public function edit(Request $request)
	{
		$page_title = "Edit Posts";
		$post = Posts::findOrFail($request->id);
		return view('app.Posts.edit', compact('page_title', 'post'));
	}
}
