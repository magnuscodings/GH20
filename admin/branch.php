<?php include 'components/header.php'?>
<?php 
$pageTitle ='Branch';
?>

	<div class="main-container">
		<div class="pd-ltr-20 xs-pd-20-10">
			<div class="min-height-200px">
				<div class="page-header">
					<div class="row">
						<div class="col-md-6 col-sm-12">
							<div class="title">
								<h4>Manage <?=$pageTitle?></h4>
							</div>
							<nav aria-label="breadcrumb" role="navigation">
								<ol class="breadcrumb">
									<li class="breadcrumb-item"><a href="index.html">Home</a></li>
									<li class="breadcrumb-item active" aria-current="page"><?=$pageTitle?></li>
								</ol>
							</nav>
						</div>
					</div>
				</div>
				<!-- Simple Datatable start -->
				<div class="card-box mb-30">
					<div class="pd-20">
						<button class="btn btn-primary addBtn" data-toggle="modal" data-target="#exampleModal">Add <?=$pageTitle?></button>
					</div>
					<div class="pb-20">
						<table id="example" class="data-table table  hover nowrap">
							<thead>
								<tr>
									<th class="table-plus datatable-nosort">Branch Name</th>
									<th>Email</th>
									<th class="datatable-nosort">Action</th>
								</tr>
							</thead>
							<tbody>

							<?php 
								$sql =$db->getAllRowsFromTable('user');
								$i=0;
								foreach ($sql as $row) {
									$id = $row['id'];
									$name = ucwords(strtolower($row['name']));
									$email = (strtolower($row['email']));
									$i++;
									echo '<tr>
											<td class="table-plus">'.ucwords($name).'</td>
											<td class="table-plus">'.strtolower($email).'</td>
											<td>
												<div class="dropdown">
													<a class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle" href="#" role="button" data-toggle="dropdown">
														<i class="dw dw-more"></i>
													</a>
													<div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
														<a class="dropdown-item editBtn" data-id="'.$id.'" href="#"><i class="dw dw-edit2 " ></i> Edit</a>
														<a class="dropdown-item deleteBtn" href="#" data-toggle="modal" data-target="#deleteModal" data-id="'.$id.'"><i class="dw dw-delete-3 "></i> Delete</a>
													</div>
												</div>
											</td>
										</tr>';
								
								}
									
							?>
								
							</tbody>
						</table>
					</div>
				</div>
				<!-- Simple Datatable End -->
			</div>
		</div>
	</div>





	<!-- Modal -->

	<!-- Modal -->
	<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title fs-5" id="exampleModalLabel">Add <?=$pageTitle?></h1>
			</div>
			<div class="modal-body">
				<div class="container">
					<div class="row justify-content-center">
						<form id="formAdd">
							<input type="text" name="type" id="type" value="add" hidden>
							<input type="text" id="id" name="id" hidden>
						<div class="col-md-12 mb-3">
							<input type="text" name="name" id="name" placeholder="<?=$pageTitle?> Name" required class="form-control">
						</div>
						<div class="col-md-12 mb-3">
							<input type="email" name="email" id="email" placeholder="Email" required class="form-control">
						</div>
						<div class="col-md-12 mb-3">
							<input type="password" name="password" id="password" placeholder="Password" required class="form-control">
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				<button type="submit" class="btn btn-primary">Save</button>
			</div>
			</form>
			</div>
		</div>
	</div>
	<!-- Modal -->

	<!-- Delete Modal -->
		<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title fs-5" id="deleteModalLabel">Delete User</h1>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<div class="container">
					<div class="row">
				<form id="formDelete">
						<input type="text" name="type" value="delete" hidden>
						<input type="text" name="id" id="deleteID" hidden>
						<h5 class="h5">Are you sure you want to delete?</h3>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
				<button type="submit" class="btn btn-primary">Confirm</button>
			</div>
			</form>
			</div>
		</div>
		</div>
	<!-- Delete Modal -->
	<?php include 'components/footer.php'?>
		<!-- js -->

	<script src="src/plugins/datatables/js/jquery.dataTables.min.js"></script>
	<script src="src/plugins/datatables/js/dataTables.bootstrap4.min.js"></script>
	<script src="vendors/scripts/datatable-setting.js"></script></body>

	<script src="js/manage-branch.js"></script>

