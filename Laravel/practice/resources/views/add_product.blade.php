@extends('layout.main')

@section('content')
<div class="container mt-5">
  <div class="row">
    <div class="col-sm-12">
      <h2>Add Product</h2>
      @if(session('Success'))
      <h3 style="color:green">{{session('Success')}}</h3>
      @endif
    </div>
    <form action="{{url('/add_product')}}" method="post" enctype="multipart/form-data">
      @csrf
      <div class="mb-3 mt-3">
        <label for="name">name:</label>
        <input type="name" class="form-control" id="name" placeholder="Enter name" name="name">
      </div>
      <div class="mb-3">
        <label for="Price">price:</label>
        <input type="text" class="form-control" id="Price" placeholder="Enter Price" name="price">
      </div>
      <div class="mb-3">
        <label for="short_description">short_description:</label>
        <input type="text" class="form-control" id="short_description" placeholder="Enter short_description" name="short_description">
      </div>

      <div class="mb-3">
        <label for="short_description">long_description:</label>
        <input type="text" class="form-control" id="long_description" placeholder="Enter long_description" name="long_description">
      </div>
      <div class="mb-3">
        <label for="image">image:</label>
        <input type="file" class="form-control" id="image" name="image">
      </div>

      <button type="submit" class="btn btn-primary" name="submit">Submit</button>
    </form>

  </div>
</div>
@endsection