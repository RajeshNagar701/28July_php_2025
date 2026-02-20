@extends('admin.layout.structure')
@section('content')
	  
      <div class="body-wrapper-inner">
        <div class="container-fluid">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title fw-semibold mb-4">Add Categories</h5>
              <div class="card">
                <div class="card-body">
                  
				  <form action="{{url('/add_categories')}}" method="post" enctype="multipart/form-data"> 
            @csrf
                    <div class="mb-3">
                      <label for="exampleInputEmail1" class="form-label">Categories Name</label>
                      <input type="text" name="name" class="form-control" >
                    </div>
					
                    <div class="mb-3">
                      <label for="exampleInputPassword1" class="form-label">Categories Image</label>
                      <input type="file" name="image" class="form-control" >
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