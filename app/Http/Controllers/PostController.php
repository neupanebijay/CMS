<?php

namespace App\Http\Controllers;

use App\Post;
use App\Category;

use Illuminate\Http\Request;
use App\Http\Requests\Posts\CreatePostRequest;
use App\Http\Requests\Posts\UpdatePostRequest;

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
        $posts = Post::with('category')->get();
        return view('posts.index', compact('posts'));
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        return  view('posts.create')->with('categories',$categories);
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
            'category_id'=>$request->category,
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
        $categories = Category::all();
     
        return view('posts.create', compact('post'))->with('categories',$categories);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePostRequest $request, Post $post)
    {
        /**
         * if new message
         * upload
         * delete old one
         * update attriubutes with message
         * return redirect
         * in $data we could have used all() instead of only() but only is more secured
         */
        $data = $request->only(['title', 'description','content','content']);
        if ($request->hasFile('image')) {

          $image =  $request->image->store('posts');
        /**
         * the following Storage:: will be called from Post model
         */
          //   Storage::delete($post->image);
          $post->imageDelete();

          $data['image'] = $image;
        }
        $post->update($data);
        return redirect(route('posts.index'))->with('status', 'Post updated successfully');

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    }
        public function destroy($id)
        {
        $post = Post::withTrashed()->where('id',$id)->firstOrFail();
        if($post->trashed()) {
            // to delete image from the storage as well
            /**
         * the following Storage:: will be called from Post model
         */
          //   Storage::delete($post->image);
          $post->imageDelete();
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

    public function restore($id)
    {
        $post = Post::withTrashed()->where('id',$id)->firstOrFail();

        $post->restore();
        return redirect()->back()->with('status','Post restored succesfully');
    }
}
