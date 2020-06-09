@extends('layouts.app')

@section('content')
        <div class="card card-default">
                <div class="card card-header">
                Create Post
                </div>
                <div class="card card-body">

                        @if($errors->any())
                                <div class="alert alert-danger">
                                        <ul>
                                        @foreach($errors->all() as $error)
                                                <li>{{$error}}</li>
                                        @endforeach
                                        </ul>
                                </div>
                        @endif
                
                        <form action="{{route('posts.store')}}" method="post" enctype="multipart/form-data">
                        @csrf
                        <p>
                        <label for="title">Title</label>
                        <input type="text" name="title" id="title" class="form-control">
                        
                        </p>
                        <p>
                        <label for="description">Description</label>
                        <textarea name="description" id="description" cols="5" rows="5" class="form-control"></textarea>
                        
                        </p>
                        <p>
                        
                        <label for="content">Content</label>
                        <input id="content" type="hidden" name="content">
                        <trix-editor input="content"></trix-editor>
                        </p>
                        <p>
                        <label for="image">Image</label>
                        <input type="file" name="image" id="image" class="form-control">
                        </p>
                        <p>
                        <label for="published_at">Published at</label>
                        <input type="text" name="published_at" id="published_at" class="form-control">
                        
                        </p>
                        <input type="submit" value="Add" class="btn btn-success">
                        </form>
                </div>

        </div>
@endsection

@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/trix/1.2.3/trix.js"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
flatpickr('#published_at',{
        enableTime: true
})
</script>
@endsection

@section('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/trix/1.2.3/trix.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

@endsection