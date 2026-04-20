<!DOCTYPE html>
<html lang="en">
<head>
  <title>Bootstrap 5 Website Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <style>
  .fakeimg {
    height: 200px;
    background: #aaa;
  }
  </style>
</head>
<body>
@include('sweetalert::alert')
<div class="p-5 bg-primary text-white text-center">
  <h1>Admin Pannel</h1>
  <h3>Hi ... {{session()->get('admin_email')}}</h3>
</div>

<nav class="navbar navbar-expand-sm bg-dark navbar-dark">
  <div class="container-fluid">
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link active" href="/dashboard">Dashboard</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="/add_product">Add Product</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="/ajax">Laravel Ajax</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="/admin_logout">Logout</a>
      </li>
    </ul>
  </div>
</nav>