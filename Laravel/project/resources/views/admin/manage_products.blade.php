@extends('admin.layout.structure')
@section('content')


<div class="body-wrapper-inner">
	<div class="container-fluid">
		<div class="card">

			<div class="card-body">
				<h5 class="card-title fw-semibold mb-4">Manage Product</h5>
				<div class="table-responsive mt-4">
					<table class="table mb-0 text-nowrap varient-table align-middle fs-3">
						<thead>
							<tr>
								<th scope="col" class="px-0 text-muted">Prod Id</th>
								<th scope="col" class="px-0 text-muted">Cate Id</th>
								<th scope="col" class="px-0 text-muted">Title</th>
								<th scope="col" class="px-0 text-muted">Price</th>
								<th scope="col" class="px-0 text-muted">Description</th>
								<th scope="col" class="px-0 text-muted">Image</th>
								<th scope="col" class="px-0 text-muted">Status</th>
								<th scope="col" class="px-0 text-muted">Action</th>
							</tr>
						</thead>

						<tbody>
							<?php
							foreach ($prod_arr as $value) {
							?>
								<tr>
									<td scope="col" class="px-0"><?php echo $value->pro_id ?></td>
									<td scope="col" class="px-0"><?php echo $value->cate_id ?></td>
									<td scope="col" class="px-0"><?php echo $value->title ?></td>
									<td scope="col" class="px-0"><?php echo $value->price ?></td>
									<td scope="col" class="px-0"><?php echo $value->description ?></td>
									<td scope="col" class="px-0">
										<img width="100px" src="assets/images/products/<?php echo $value->image ?>" />
									</td>
									<td scope="col" class="px-0"><?php echo $value->status ?></td>
									<td class="px-0">
										<a href="" class="btn btn-primary">Edit</a>
										<a href="delete?del_prod=<?php echo $value->pro_id ?>" class="btn btn-danger">Delete</a>
										<a href="admin_status?status_product=<?php echo $value->pro_id ?>" class="btn btn-success">
											<?php echo $value->status ?>
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