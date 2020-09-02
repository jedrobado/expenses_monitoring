<?php include("includes/header.php");?>
<?php
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
$page_title="Expenses Monitoring";
if (isset($_POST['add_item'])) {
	manage("INSERT INTO items(item_name,item_price,item_quantity,date_added,date_encoded) VALUES(?,?,?,?,?)",array($_POST['items'],$_POST['price'],$_POST['quantity'],$_POST['date_added'],date("Y-m-d h:i:s")));
	echo "<script>
		alert('Added an item');
	</script>";
}
if (isset($_POST['update_item'])) {
	manage("UPDATE items SET item_name=?, item_price=?, item_quantity=?, date_added=? WHERE id=?",
		array($_POST['edit_item_name'],$_POST['edit_item_price'],$_POST['edit_item_quantity'],$_POST['edit_item_date_added'],$_POST['edit_item_id']));
	echo "<script>
		alert('Updated an item');
	</script>";
}
if (isset($_POST['delete_item'])) {
	manage("DELETE FROM items WHERE id=?",array($_POST['delete_item_id']));
	echo "<script>
		alert('Deleted an item');
	</script>";
}

if (isset($_POST['download_expenses'])) {
	$get_expenses = retrieve("SELECT * FROM items");
	$expenses=array();
	foreach ($expenses_row as $get_expenses) {
		$expenses[] = $expenses_row;
	}

	header('Content-Type: text/csv; charset=utf-8');
	header('Content-Disposition: attachment; filename=expenses_'.date("Y-m-d").'.csv');
	$output = fopen('php://output', 'w');
	fputcsv($output,array("Item Name","Item Quantity","Item Price","Total","Date Added","Date Encoded"));

	if (COUNT($expenses) > 0) {
		foreach ($expenses as $expenses_row) {
			fputcsv($output, $expenses_row);
		}
	}
}
?>
<!--Navbar-->
<nav class="navbar navbar-dark elegant-color">
	<a class="navbar-brand text-white"><img src="image/coin.png" height="40"> <?php echo $page_title; ?></a>
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#basicExampleNav"
	aria-controls="basicExampleNav" aria-expanded="false" aria-label="Toggle navigation">
		<span class="navbar-toggler-icon"></span>
	</button>
</nav>
<div class="row mx-auto">
	<div class="col-md-3 p-2">
		<div class="row">
			<div class="col-md-12 mb-2">
				<div class="card">
					<div class="card-header p-2 bg-primary text-white">
						Add Items
					</div>
					<div class="card-body p-2">
						<form method="POST">
							<small class="form-text text-muted mb-2 mt-0">Item</small>
							<input type="text" name="items" id="items" class="form-control"  required>
							
							<small class="form-text text-muted mb-2 mt-0">Price</small>
							<input type="number" name="price" id="price" step="any" class="form-control"  required>

							<small class="form-text text-muted mb-2 mt-0">Quantity</small>
							<input type="number" name="quantity" id="quantity" class="form-control"  required>

							<small class="form-text text-muted mb-2 mt-0">Date Added</small>
							<input type="date" name="date_added" id="date_added" class="form-control"  required>

							<button type="submit" class="btn btn-primary btn-sm" name="add_item">Add</button>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="col-md-2 p-2">
		<div class="row">
			<div class="col-md-12 mb-2">
				<div class="card">
					<div class="card-header p-2 bg-primary text-white">
						Search Items
					</div>
					<div class="card-body p-2">
						<form method="POST">
							<small class="form-text text-muted mb-2 mt-0" id="label_from">Date From</small>
							<input type="date" name="date_from" id="date_from" class="form-control"  required>

							<small class="form-text text-muted mb-2 mt-0" id="label_to">Date To</small>
							<input type="date" name="date_to" id="date_to" class="form-control"  required>

							<button type="submit" class="btn btn-primary btn-sm" name="search_item">Search</button>
						</form>
					</div>
				</div>
			</div>
			<div class="col-md-12 mb-2">
				<div class="card">
					<div class="card-header p-2 bg-primary text-white">
						Top <span class="badge badge-success">5</span> Most Expensive Items You have bought
					</div>
					<div class="card-body p-2">
						<table class="table table-striped table-bordered table-sm w-100 text-center" cellspacing="0">
							<thead class="grey lighten-2">
								<tr>
									<th>Item Name</th>
									<th>Total</th>
								</tr>
							</thead>
							<tbody>
								<?php
									$get_most_expensive=retrieve("SELECT item_name, item_quantity * item_price AS most_expensive FROM items ORDER BY most_expensive DESC LIMIT 5");
									for ($i=0;$i<COUNT($get_most_expensive);$i++) { 
										echo "<tr>
												<td class='font-weight-bold'>".$get_most_expensive[$i]['item_name']."</td>
												<td class='font-weight-bold'>".($get_most_expensive[$i]['most_expensive']>0?"&#8369;":"").$get_most_expensive[$i]['most_expensive']."</td>
										</tr>";
									}
									
								?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="col-md-7 p-2">
		<div class="row">
			<div class="col-md-12 mb-2">
				<div class="card">
					<div class="card-header p-2 bg-primary text-white">
						View Expenses
					</div>
					<a class="btn btn-success col-sm-2" data-toggle="modal" data-target="#download_expenses_modal"><span class="m-1"><i class="fas fa-cloud-download hvr-pop"></i></span> Download</a>
					<div class="card-body p-2">
						<?php
							if (isset($_POST['search_item'])) {
								$date_from=$_POST['date_from'];
								$date_to=$_POST['date_to'];
								echo "<label style='width:100%;'><center>".date('F d, Y', strtotime($date_from))." to ".date('F d, Y', strtotime($date_to))."</center></label>";
								$get_items=retrieve("SELECT * FROM items WHERE date_added BETWEEN ? AND ?",
									array($_POST['date_from'], $_POST['date_from']));
								$getTotalPrice=retrieve("SELECT item_quantity, item_price FROM items WHERE date_added BETWEEN ? AND ?",
									array($_POST['date_from'],$_POST['date_to']));
							} else {
								$get_items=retrieve("SELECT * FROM items");
								$getTotalPrice=retrieve("SELECT item_quantity, item_price FROM items");
							}
						?>
						<table class="table table-striped table-bordered table-sm w-100 text-center" cellspacing="0" id="manage_items">
							<thead class="grey lighten-2">
								<tr>
									<?php
										$table_header=explode(",","Item,Price,Quantity,Total,Date Added, Date Encoded, Actions");
										foreach ($table_header as $data_header) {
											echo "<th>".$data_header."</th>";
										}
									?>
								</tr>
							</thead>
							<tbody>
								<?php
									for ($i=0; $i < COUNT($get_items); $i++) { 
										$total=$get_items[$i]['item_price'] * $get_items[$i]['item_quantity'];
										echo "<tr>";
											echo "<td>".$get_items[$i]['item_name']."</td>";
											echo "<td>".($get_items[$i]['item_price']>0?"&#8369;":"").$get_items[$i]['item_price']."</td>";
											echo "<td>".$get_items[$i]['item_quantity']."</td>";
											echo "<td> ".($total>0?"&#8369;":"").$total."</td>";
											echo "<td>".$get_items[$i]['date_added']."</td>";
											echo "<td>".$get_items[$i]['date_encoded']."</td>";
											echo "<td><span class='m-1 btn-btn-sm edit_items' title='Edit Items' data-toggle='modal' data-target='#edit_item_modal' edit_item_id='".$get_items[$i]['id']."' edit_item_name='".$get_items[$i]['item_name']."' edit_item_price='".$get_items[$i]['item_price']."' edit_item_quantity='".$get_items[$i]['item_quantity']."' edit_item_date_added='".$get_items[$i]['date_added']."'><i class='fas fa-pencil hvr-pop'></i></span>
											<span class='m-1 btn-btn-sm delete_items' title='Delete Items' data-toggle='modal' data-target='#delete_item_modal' delete_item_id='".$get_items[$i]['id']."' delete_item_name='".$get_items[$i]['item_name']."'><i class='fas fa-trash hvr-pop'></i></span></td>";
										echo "</tr>";
									}
								?>
							</tbody>
						</table>
						<table class="table table-striped table-bordered table-sm w-100 text-center" cellspacing="0">
							<thead class="grey lighten-2">
								<tr>
									<th>Total quantity</th>
									<th>Total Overall Expenses</th>
								</tr>
							</thead>
							<tbody>
								<?php
									$get_total=0;
									$get_quantity=0;
									for ($i=0;$i<COUNT($getTotalPrice);$i++) { 
										$get_total+=($getTotalPrice[$i]['item_quantity'] * $getTotalPrice[$i]['item_price']);
										$get_quantity+=($getTotalPrice[$i]['item_quantity']);
									}
									echo "<tr>
												<td class='font-weight-bold'>".$get_quantity."</td>
												<td class='font-weight-bold'>".($get_total>0?"&#8369;":"").$get_total."</td>
										</tr>";
								?>
							</tbody>
						</table>
						<!-- <div class="row">
							<div class="col-sm-12 col-md-12" id="load_here">
							</div>
						</div> -->
					</div>
				</div>
			</div>
		</div>
	</div>
</div>


<!-- content -->
<div class="modal fade" id="edit_items_modal" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-md" role="document">
		<div class="modal-content">
			<div class="modal-header primary-color text-white">
				<h6 class="modal-title w-100">Edit Items</h6>
				<button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="p-1">
					<form method="POST">
						<input type="text" name="edit_item_id" id="edit_item_id" class="form-control" required hidden>

						<small class="form-text text-muted mb-2 mt-0">Item</small>
						<input type="text" name="edit_item_name" id="edit_item_name" class="form-control"  required>
						
						<small class="form-text text-muted mb-2 mt-0">Price</small>
						<input type="number" name="edit_item_price" id="edit_item_price" step="any" class="form-control"  required>

						<small class="form-text text-muted mb-2 mt-0">Quantity</small>
						<input type="number" name="edit_item_quantity" id="edit_item_quantity" class="form-control"  required>

						<small class="form-text text-muted mb-2 mt-0">Date Added</small>
						<input type="date" name="edit_item_date_added" id="edit_item_date_added" class="form-control"  required>

						<div class="custom-control custom-checkbox">
							<input type="checkbox" class="custom-control-input" id="proceed_action" required>
							<label class="custom-control-label" for="proceed_action">Proceed action.</label>
						</div>


						<button type="submit" class="btn btn-primary btn-sm" name="update_item">Save</button>
					</form>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-elegant btn-sm" data-dismiss="modal" title="Close">Close</button>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="delete_item_modal" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-md" role="document">
		<div class="modal-content">
			<div class="modal-header primary-color text-white">
				<h6 class="modal-title w-100">Delete Items</h6>
				<button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="p-1">
					<form method="POST">
						<center>
							<input type="text" name="delete_item_id" id="delete_item_id" hidden required>
							<h4 id="delete_item_name"></h4>
							<div class="custom-control custom-checkbox">
								<input type="checkbox" class="custom-control-input" id="action_proceed" required>
								<label class="custom-control-label" for="action_proceed">Proceed action.</label>
							</div>
							<button type="submit" class="btn btn-danger btn-sm" name="delete_item">Delete</button>
						</center>
					</form>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-elegant btn-sm" data-dismiss="modal" title="Close">Close</button>
			</div>
		</div>
	</div>
</div>


<!-- content -->
<div class="modal fade" id="download_expenses_modal" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-md" role="document">
		<div class="modal-content">
			<div class="modal-header primary-color text-white">
				<h6 class="modal-title w-100">Edit Items</h6>
				<button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="p-1 text-center">
					<h6>Are you sure you want to download this expenses?</h6>
					<form method="POST">
						<div class="custom-control custom-checkbox">
							<input type="checkbox" class="custom-control-input" id="download_proceed" required>
							<label class="custom-control-label" for="download_proceed">Proceed action.</label>
						</div>
						<button type="submit" class="btn btn-secondary btn-sm" name="download_expenses">Download</button>
					</form>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-elegant btn-sm" data-dismiss="modal" title="Close">Close</button>
			</div>
		</div>
	</div>
</div>

<!-- include footer elements/ do not touch -->
<?php include("includes/footer.php")?>
<!-- page js -->
<script type="text/javascript">
$(document).ready(function(){
	$(".edit_items").click(function(e){
		e.preventDefault();
		$("#edit_item_id").val($(this).attr("edit_item_id"));
		$("#edit_item_name").val($(this).attr("edit_item_name"));
		$("#edit_item_price").val($(this).attr("edit_item_price"));
		$("#edit_item_quantity").val($(this).attr("edit_item_quantity"));
		$("#edit_item_date_added").val($(this).attr("edit_item_date_added"));
		$("#edit_items_modal").modal("show");
	});

	$(".delete_items").click(function(e){
		e.preventDefault();
		$("#delete_item_id").val($(this).attr("delete_item_id"));
		$("#delete_item_name").text($(this).attr("delete_item_name"));
		$("#delete_item_modal").modal("show");
	});
	$("#manage_items").DataTable({
		"scrollX": true,
		"info": false,
		"order":[ 4, "desc" ]
	});
});
</script>