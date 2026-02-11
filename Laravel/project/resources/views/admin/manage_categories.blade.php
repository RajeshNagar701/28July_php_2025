@extends('admin.layout.structure')
@section('content')
	  
	  
      <div class="body-wrapper-inner">
        <div class="container-fluid">
          <div class="card">
           
				<div class="card-body">
				  <h5 class="card-title fw-semibold mb-4">Manage Categories</h5>
				  <div class="table-responsive mt-4">
					<table class="table mb-0 text-nowrap varient-table align-middle fs-3">
					  <thead>
						<tr>
						  <th scope="col" class="px-0 text-muted">Id</th>
						  <th scope="col" class="px-0 text-muted">Categories Name</th>
						  <th scope="col" class="px-0 text-muted">Categories Image</th>
						  <th scope="col" class="px-0 text-muted">Action</th>
						</tr>
					  </thead>
					  
					  <tbody>
					  
					  <?php
					  foreach($cate_arr as $value)
					  {
					  ?>
					  
						<tr>
						  <td scope="col" class="px-0"><?php echo $value->cate_id?></td>
						  <td scope="col" class="px-0">
							<?php echo $value->cate_name?>
						  </td>
						  <td scope="col" class="px-0">
							<img width="100px" src="assets/images/categories/<?php echo $value->cate_image?>" />
						  </td>
	
						  <td class="px-0">
							<a href="" class="btn btn-primary">Edit</a>
							<a href="delete?del_cate=<?php echo $value->cate_id?>" class="btn btn-danger">Delete</a>
						  </td>
						</tr>
					<?php
					  }
					?>	
					  </tbody>
					</table>
				  </div>
				</div>
          </div>
        </div>
      </div>
	  
	  
	  
	  
	  
    </div>
  </div>

@endsection