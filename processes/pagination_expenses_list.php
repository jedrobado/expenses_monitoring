<?php
	include("../include/connect.php");
	include("../include/url.php");
	session_start();
	if($_POST['trigger']=='load_pagination'){?>
		<table class="table table-striped table-bordered table-sm w-100 text-center" cellspacing="0" id="manage_items">
			<thead class="grey lighten-2">
				<tr>
					<th>No</th>
					<th>Item</th>
					<th>Category</th>
					<th>Price</th>
					<th>Quantity</th>
					<th>Total</th>
					<th>Date Encoded</th>
				</tr>
			</thead>
			<tbody>
				<?php
					$get_items=retrieve("SELECT items.id, items.item_name, items.item_category, items.item_price, items.item_quantity, items.date_added FROM items LIMIT ".($_POST['offset']*$_POST['limit']).",".$_POST['limit']);
					for ($i=0; $i < COUNT($get_items); $i++) { 
						$total=$get_items[$i]['item_price'] * $get_items[$i]['item_quantity'];
						echo "<tr>";
							echo "<td>".$get_items[$i]['id']."</td>";
							echo "<td>".$get_items[$i]['item_name']."</td>";
							echo "<td>".$get_items[$i]['item_category']."</td>";
							echo "<td>".$get_items[$i]['item_price']."</td>";
							echo "<td>".$get_items[$i]['item_quantity']."</td>";
							echo "<td> ".$total."</td>";
							echo "<td>".$get_items[$i]['date_added']."</td>";
							echo "<td><span class='m-0 btn-btn-sm edit_item_modal' title='Edit Items' data-toggle='modal' data-target='#edit_item_modal' edit_id='".$get_items[$i]['id']."' edit_item_name='".$get_items[$i]['item_name']."' edit_item_category='".$get_items[$i]['item_category']."' edit_item_price='".$get_items[$i]['item_price']."' edit_item_quantity='".$get_items[$i]['item_quantity']."'><i class='fas fa-pencil hvr-pop'></i></span></td>";
						echo "</tr>";
					}
				?>
			</tbody>
		</table>
		<nav class="w-100" id="pagination_nav">
			<ul class="pagination pg-blue pagination-sm">
				<?php 
					$get_total_items=retrieve("SELECT COUNT(*) AS count FROM items");
					$get_total_items=$get_total_items[0]['count']/$_POST['limit'];
					for ($i=0; $i < $get_total_items; $i++) { 
						echo "<li class='page-item ".($i==$_POST['offset']?"disabled grey lighten-2":"")."'>
							<a class='page-link move_page' url=".$_POST['url']." div_id='".$_POST['div_id']."' table_id='".$_POST['table_id']."' trigger='".$_POST['trigger']."' offset='".($i)."' limit='".$_POST['limit']."''>".($i+1)."</a>
						</li>";	
					}
				?>
			</ul>
		</nav>
	<?php }
?>