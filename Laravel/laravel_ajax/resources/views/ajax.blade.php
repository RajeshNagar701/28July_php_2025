@extends('layout.main')
@section('content')
<div class="container mt-5">
  <div class="row">
    <div class="col-sm-12">
      <h2>Country State City Ajax</h2>
    </div>
    <form action="#" method="post" >
      @csrf
      <div class="mb-3 mt-3">
        <label for="name">name:</label>
        <input type="name" class="form-control" id="name" placeholder="Enter name" name="name">
      </div>
    
      <div class="mb-3">
        <label for="Price">Select Country:</label>
        <select  class="form-control" name="cid">
            <option>Select Country</option>
          @foreach($data as $d)
            <option value="{{$d->id}}">{{$d->cname}}</option>
          @endforeach
        </select>
      </div>
      <div class="mb-3">
        <label for="Price">Select State:</label>
        <select  class="form-control" id="sid" name="sid">
            <option>Select State</option>
        </select>
      </div>
      <div class="mb-3">
        <label for="Price">Select City:</label>
        <select  class="form-control" id="city_id" name="city_id">
            <option>Select City</option>
        </select>
      </div>
      
      <button type="submit" class="btn btn-primary" name="submit">Submit</button>
    </form>

  </div>
</div>
@endsection