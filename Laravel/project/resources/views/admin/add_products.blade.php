@extends('admin.layout.structure')
@section('content')

<div class="body-wrapper-inner">
  <div class="container-fluid">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title fw-semibold mb-4">Add Products</h5>
        <div class="card">
          <div class="card-body">

            <form action="{{url('/add_products')}}" method="post" enctype="multipart/form-data">
              @csrf
              <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Select Categories</label>

                <select name="cate_id" class="form-control">
                  <?php
                  foreach ($cate_arr as $data) {
                  ?>
                    <option value="<?php echo $data->id; ?>">
                      <?php echo $data->name; ?>
                    </option>
                  <?php
                  }
                  ?>
                </select>

              </div>
              <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Package Titke</label>
                <input type="text" name="name" class="form-control">
              </div>
              <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Package Price</label>
                <input type="number" name="price" class="form-control">
              </div>
              <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Package Description</label>
                <textarea name="description" class="form-control"></textarea>
              </div>
              <div class="mb-3">
                <label for="exampleInputPassword1" class="form-label">Package Image</label>
                <input type="file" name="image" class="form-control">
              </div>

              <button type="submit" name="submit" class="btn btn-primary">Submit</button>
            </form>


          </div>
        </div>

      </div>
    </div>
  </div>
</div>
</div>
</div>

@endsection