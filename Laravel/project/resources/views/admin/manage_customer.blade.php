@extends('admin.layout.structure')
@section('content') 
      <div class="body-wrapper-inner">
        <div class="container-fluid">
          <div class="card">
           
				<div class="card-body">
				  <h5 class="card-title fw-semibold mb-4">Manage Customer</h5>
				  <div class="table-responsive mt-4">
					<table class="table mb-0 text-nowrap varient-table align-middle fs-3">
					  <thead>
						<tr>
						  <th scope="col" class="px-0 text-muted">Profile</th>
						  <th scope="col" class="px-0 text-muted">Id</th>
						  <th scope="col" class="px-0 text-muted">Name</th>
						  <th scope="col" class="px-0 text-muted">email</th>
						  <th scope="col" class="px-0 text-muted">Gender</th>
						  <th scope="col" class="px-0 text-muted">Hobby</th>
						  <th scope="col" class="px-0 text-muted text-center">Action</th>
						</tr>
					  </thead>
					  
					  <tbody>
					  <?php
					  foreach($cust_arr as $value)
					  {
					  ?>
						<tr>
						   <td class="px-0"><img src="upload/customer/<?php echo $value->image?>" width="50px" height="50px"/></td>
						  <td class="px-0"><?php echo $value->id?></td>
						  <td class="px-0"><?php echo $value->name?></td>
						  <td class="px-0"><?php echo $value->email?></td>
						  <td class="px-0"><?php echo $value->gender?></td>
						  <td class="px-0"><?php echo $value->hobby?></td>
						  <td class="px-0 text-center">
							<a href="" class="btn btn-primary">Edit</a>
							<a href="{{url('/delete_customer/'.$value->id)}}" class="btn btn-danger">Delete</a>
							<a href="admin_status?status_customer=<?php echo $value->id?>" class="btn btn-success">
								<?php echo $value->status?>
							</a>
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