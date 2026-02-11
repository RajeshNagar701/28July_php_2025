@extends('admin.layout.structure')
@section('content')

<div class="body-wrapper-inner">
	<div class="container-fluid">
		<div class="card">

			<div class="card-body">
				<h5 class="card-title fw-semibold mb-4">Manage Order</h5>
				<div class="table-responsive mt-4">
					<table class="table mb-0 text-nowrap varient-table align-middle fs-3">
						<thead>
							<tr>
								<th scope="col" class="px-0 text-muted">
									Order Details
								</th>
								<th scope="col" class="px-0 text-muted">Categories Name</th>

								<th scope="col" class="px-0 text-muted">
									Action
								</th>
							</tr>
						</thead>

						<tbody>
							<tr>
								<td class="px-0">
									<div class="d-flex align-items-center">
										<img src="./assets/images/profile/user-3.jpg" class="rounded-circle" width="40"
											alt="flexy" />
										<div class="ms-3">
											<h6 class="mb-0 fw-bolder">1</h6>
										</div>
									</div>
								</td>
								<td class="px-0">Birthday Cake</td>

								<td class="px-0">
									<a href="" class="btn btn-primary">Edit</a>
									<a href="" class="btn btn-danger">Delete</a>
								</td>
							</tr>

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