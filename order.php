<?php
include('helper.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['action'] == 'insert') {
	// prepare data to insert
	$data = [
		'order_name' => validate($_POST['order_name']),
		'user_id' 	 => validate($_POST['user_id'])
	];
	
	if (insert('orders', $data)) {
		echo 'true';
	}
}
elseif (($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['action'] == 'select') || 1) {

	$orders = selectOrders();
	if (is_array($orders)) {
		foreach ($orders as $order) { ?>
			<tr>
				<td><?=$order['order_id']?></td>
				<td><?=$order['order_name']?></td>
				<td><?=$order['owner']?></td>
				<td><?=$order['order_date']?></td>
				<td></td>
			</tr>	
		<?php } 
	} else { ?>
		<td colspan="5"><?=$orders?></td>
	<?php }
}

?>