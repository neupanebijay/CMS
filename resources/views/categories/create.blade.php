@extends('layouts.app')
@section('content')

    <div class="card card-default">
        <div class="card-header">
        
         {{isset($category) ? 'Edit Category' : 'Create Category'}}  
        
        </div>
            <card class="card-body">
                
                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach($errors->all() as $error)
                                <li>{{$error}}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                

                <form action="{{isset($category) ? route('categories.update', $category->id) : route('categories.store')}}" method="post">
                @csrf
                @if(isset($category))
                @method('PUT')
                @endif
                
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" name="name" value="{{isset($category) ? $category->name : '' }}">
                            <button class="btn btn-primary mt-3">
                               {{isset($category) ? 'Update Category' : 'Add Category'}}
                                
                            </button>
                    </div>
                </form>
            </card>


    </div>
@endsection