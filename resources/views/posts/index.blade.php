
@extends('layouts.app')

@section('content')
    <a href="{{route('posts.create')}}" class="btn btn-success mb-2">Add Post</a>
    <div class="card card-default">
        <div class="card-header">Posts</div>

    </div>
   
    <div class="card card-body">
                @if(Session::has('status'))

                    <p class="alert alert-info">
                    {{ Session::get('status') }}</p>

                @endif
        @if($posts->count() > 0)
            <table class="table">
            <thead>
                <th>Image</th>
                <th>Title</th>
                <th>Category</th>
                <th></th>
                <th></th>
            </thead>

            <tbody>
            @foreach($posts as $post)
                <tr>
                    <td>
                    
                    <img src="storage/{{$post->image}}" alt="" width="90" height="70" class="img-fluid">
                    


                    </td>
                    <td>{{$post->title}}</td>
                    <td><a href="{{route('categories.edit',$post->category->id)}}">{{$post->category->name}}</a></td>
                        @if($post->trashed())
                            <td>
                            
                            <form action="{{route('restores',$post->id)}}" method="post">
                            @csrf
                            @method('PUT')
                            <input type="submit" value="Restore" class="btn btn-info btn-sm">
                            </form>
                            </td>
                            
                        @else
                            <td>
                            <a href="{{route('posts.edit',$post->id)}}" class="btn btn-primary btn-sm">Edit</a>
                            </td>
                        @endif
                    <td>
                    <form action="{{route('posts.destroy',$post->id)}}" 
                    onsubmit="return confirm('Are you sure to delete this post??')" method="post">
                    @csrf
                    @method('DELETE')
                        <input type="submit" class="btn btn-danger btn-sm" value="{{$post->trashed() ? 'Delete' : 'Trash' }}">
                    </form>
                    
                        
                    </td>

                </tr>
            @endforeach
            </tbody>
            </table>
        @else
        <h2>No posts to show.</h2>
    

        @endif


    </div>

@endsection