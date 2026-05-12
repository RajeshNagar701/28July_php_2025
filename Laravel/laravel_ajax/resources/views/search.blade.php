@extends('layout.main')
@section('content')

<script>
  function getcustomer(key) {

    xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
      if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
        document.getElementById("data").innerHTML = xmlhttp.responseText;
      }
    }
    xmlhttp.open("GET", "{{ url('/getcustomer') }}/" + key, true);
    xmlhttp.send();
  
  }
</script>


<div class="container mt-5">
  <div class="row">
    <div class="col-sm-12 d-flex justify-content-between">
      <h2>Ajax Search</h2>

    </div>
    <form action="" method="POST">
      <div class="d-flex justify-content-end mt-3 mb-3 ">
        <input type="search" onkeyup="getcustomer(this.value)" name="search" id="search" class="border border-success form-control" placeholder="Search" >
      </div>
    </form>

    <table class="table table-hover table-striped shadow">
      <tbody id="data">
        <tr>
          <th>Id</th>
          <th>Name</th>
          <th>Email</th>
          <th>Password</th>
        </tr>
        @foreach($data as $d)
        <tr>
          <td>{{$d-> id}}</td>
          <td>{{$d-> name}}</td>
          <td>{{$d-> email}}</td>
          <td>{{$d-> password}}</td>
        </tr>
        @endforeach
      </tbody>
    </table>

  </div>
</div>
@endsection