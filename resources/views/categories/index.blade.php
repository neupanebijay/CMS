@extends('layouts.app')
@section('content')
<a href="{{route('categories.create')}}" class="btn btn-success mb-2">Add Category</a>
    <div class="card card-default">
        <div class="card-header">Categories</div>

    </div>
       
    <div class="card card-body">
            @if(Session::has('status'))

            <p class="alert alert-info">
            {{ Session::get('status') }}</p>

            @endif

            @if($categories->count()>0)
                <table class="table">
                <thead>
                    <tr>
                        <th>Name</th>
                    </tr>
                    <tr>
                    <th></th>
                    </tr>
                </thead>
                {{--this categories here below is from create method--}}
            <tbody>
                @foreach($categories as $category)
                <tr>
                    <td>{{$category->name}}</td>
                    <td class="btn-group">
                            <a href="{{route('categories.edit', $category->id)}}" class="btn btn-primary btn-md">edit</a>
                            
                            {{-- <a href="{{route('categories.destroy', $category->id)}}" class="btn btn-danger btn-md ml-1">Delete</a> --}}
                            <button type="button" onclick="handleDelete({{$category->id}})" class="btn btn-danger ml-2">Delete</button>

                    </td>
                    
                </tr>
                
                
                @endforeach
            
            </tbody>
            
            </table>
                <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" 
                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                            <form action="" method="post" id="deleteCategory">
                            @csrf
                            @method('delete')
                                    <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Delete Category</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                                <div class="modal-body">
                                                    Do you really want to delete this category??
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">No, go back</button>
                                                    <button type="submit" class="btn btn-danger">Yes, delete.</button>
                                                </div>
                                        </div>
                            </form>
                            </div>
                
            @else
            <h2>No categories to show</h2>

            @endif
        </div>
    </div>
@endsection

@section('scripts')
    <script>
    function handleDelete(id)
    {
        var form = document.getElementById('deleteCategory')
        form.action = '/categories/' + id
        {{--here we can not use route('categories.destroy'), as we are using js--}}

        $('#deleteModal').modal('show');
    }
    
    </script>

@endsection