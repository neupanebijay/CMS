<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;
use App\Http\Requests\Posts\CreatePostRequest;
use Illuminate\Support\Facades\Storage;
class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::all();
        return view('posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return  view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreatePostRequest $request)
    {
        
        /**
         * upload image
         * create post
         * redirect
         */
      
            // $imageName           = time().'.'.$request->image->getClientOriginalExtension();
            // $request->image->move(public_path('images'), $imageName);
           
        
            
        /**
             * the posts inside store i.e store('posts') is post folder in storage section.
             */
        $image = $request->image->store('posts');


        $post = new Post;
        Post::create([
            'title' => $request->title,
            'description' => $request->description,
            'content' => $request->content,
            'image' => $image,
            'published_at' => $request->published_at,        

        ]);
        return redirect(route('posts.index'))->with('status','Post added succesfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::withTrashed()->where('id',$id)->firstOrFail();
        if($post->trashed()) {
            // to delete image from the storage as well
            Storage::delete($post->image);
            $post->forceDelete();

        }
        else{
            $post->delete();
        }
        
        return redirect(route('posts.index'))->with('status','Post deleted succesfully');

    }
    public function trash()
    {
        /**
         * We can not use compact('trashed') below because we have used $posts in view
         * Post::withTrashed() show all items along with trashed items
         */
        // $trashed = Post::withTrashed()->get();
        $trashed = Post::onlyTrashed()->get();

        
         // return view('posts.index')->withPosts($trashed);

        /**
         * above one is similar to the following
         */
        return view('posts.index')->with('posts', $trashed);



    }
}
