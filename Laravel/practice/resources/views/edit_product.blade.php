@extends('layout.main')

@section('content')
<div class="container mt-5">
  <div class="row">
    <div class="col-sm-12">
      <h2>Edit Product</h2>

    </div>
    <form action="{{url('/edit_product/'.$data->id)}}" method="post" enctype="multipart/form-data">
      @csrf
      <div class="mb-3 mt-3">
        <label for="name">name:</label>
        <input type="name" value="{{$data->name}}" class="form-control" id="name" placeholder="Enter name" name="name">
      </div>
      <div class="mb-3">
        <label for="Price">Price:</label>
        <input type="text" value="{{$data->price}}" class="form-control" id="Price" placeholder="Enter Price" name="price">
      </div>
      <div class="mb-3">
        <label for="short_description">short_description:</label>
        <input type="text" value="{{$data->short_description}}" class="form-control" id="short_description" placeholder="Enter short_description" name="short_description">
      </div>

      <div class="mb-3">
        <label for="short_description">long_description:</label>
        <input type="text" value="{{$data->long_description}}" class="form-control" id="long_description" placeholder="Enter long_description" name="long_description">
      </div>
      <div class="mb-3">
        <label for="img">img:</label>
        <input type="file" class="form-control" id="img" name="image">
        <img src="{{url('upload/'.$data->image)}}" alt="" width="100px">
      </div>

      <button type="submit" class="btn btn-primary" name="submit">Save</button>
    </form>

  </div>
</div>
@endsection