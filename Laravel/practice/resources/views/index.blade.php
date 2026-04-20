<!DOCTYPE html>
<html lang="en">

<head>
  <title>Bootstrap 5 Website Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</head>

<body>
  @include('sweetalert::alert')
  <div class="p-5 bg-primary text-white text-center">
    <h1>Admin Login</h1>
  </div>

  <nav class="navbar navbar-expand-sm bg-dark navbar-dark">
    <div class="container-fluid">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link active" href="/">Admin Login</a>
        </li>
      </ul>
    </div>
  </nav>


  <div class="container mt-5">
    <div class="row">
      <div class="col-sm-12">
        <h2>Admin Login</h2>

      </div>
    </div>


    <div class="container mt-3">

      <form action="{{url('/admin_auth')}}" method="post">
        @csrf
        <div class="mb-3 mt-3">
          <label for="email">Email:</label>
          <input type="email" class="form-control" id="email" placeholder="Enter email" name="email">
          @error('email')
          <div class="alert alert-danger">{{ $message }}</div>
          @enderror
        </div>
        <div class="mb-3">
          <label for="pwd">Password:</label>
          <input type="password" class="form-control" id="pwd" placeholder="Enter password" name="password">
          @error('password')
          <div class="alert alert-danger">{{ $message }}</div>
          @enderror

        </div>
        <div class="form-check mb-3">
          <label class="form-check-label">
            <input class="form-check-input" type="checkbox" name="remember"> Remember me
          </label>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
      </form>
    </div>



    <div class="mt-5 p-4 bg-dark text-white text-center">
      <p>Footer</p>
    </div>

</body>

</html>