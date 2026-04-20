@extends('layout.main')

@section('content')
@include('sweetalert::alert')
<div class="container mt-5">
  <div class="row">

    <div class="container mt-3">
      <h2> Dashboard</h2>
      <table class="table">
        <thead>
          <tr>
            <th>name</th>
            <th>price</th>
            <th>short_description</th>
            <th>long_description</th>
            <th>image</th>
            <th>action</th>
          </tr>
        </thead>
        <tbody>
          @foreach($prod_arr as $value)
          <tr>
            <td>{{ $value->name}}</td>
            <td>{{ $value->price}}</td>
            <td>{{ $value->short_description}}</td>
            <td>{{ $value->long_description}}</td>
            <td><img src="{{url('upload/'.$value->image)}}" alt="" width="100px"></td>
            <td><a href="{{url('/edit_product/'.$value->id)}}" class="btn btn-primary">Edit</a>
                <a href="{{url('/delete_product/'.$value->id)}}" class="btn btn-danger">delete</a>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection