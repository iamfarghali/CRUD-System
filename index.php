<?php
include('helper.php'); 
$usersData = selectDataFrom('user');
?>

<!DOCTYPE html>
<html>
<head>
	<title>CRUD System</title>
	<link rel="stylesheet" type="text/css" href="style.css">
	<script src="jquery-3.3.1.min.js" type="text/javascript" charset="utf-8"></script>
	<link href="https://fonts.googleapis.com/css?family=Raleway" rel="stylesheet">
</head>
<body>
	<div class="container">

		<!-- Show User and Order Forms -->
		<div class="row">
			<div class="row-header">
				<h4 class="title">Data Insertion </h4>
			</div>
			<div class="half-row user-form">
				<div class="row-header">
					<h4 class="title">User Form</h4>
				</div>
				<form action="user.php" method="post" accept-charset="utf-8" autocomplete="off">
					<input type="hidden" name="action" value="insert">
					<div class="form-item">
						<label for="username">Username</label>
						<input id="username" type="text" name="username" placeholder="muhammed11" required>
					</div>
					<div class="form-item">
						<label for="fullname">Full Name</label>
						<input id="fullname" type="text" name="full_name" placeholder="muhammed ahmed" required>
					</div>
					<div class="form-item">
						<label for="email">Email</label>
						<input id="email" type="email" name="email" placeholder="user@example.com" required>
					</div>
					<div class="form-item">
						<label for="password">Password</label>
						<input id="password" type="password" name="password" required>
					</div>
					<div class="form-item">
						<input type="submit" name="submit" value="Add User">
					</div>
				</form>
			</div>
			<div class="half-row order-form">
				<div class="row-header">
					<h4 class="title">Order Form</h4>
				</div>
				<div class="message"></div>
				<form action="order.php" method="post" accept-charset="utf-8" id="order-form">
					<input type="hidden" name="action" value="insert">
					<div class="form-item">
						<label for="order_name">Order Name</label>
						<input id="order_name" type="text" name="order_name" required>
					</div>
					<div class="form-item">
						<label for="order-owner">Name</label>
						<select name="user_id" id="order-owner">
							<?php 
							foreach ($usersData as $user) { ?>
								<option value="<?=$user['user_id']?>"><?=$user['full_name']?></option>
							<?php } ?>
						</select>
					</div>
					<div class="form-item">
						<input type="submit" name="order_submit" value="Add Order">
					</div>
				</form>
			</div>
		</div>

		<!-- Show User Data -->
		<div class="row">
			<div class="row-header">
				<h4 class="title">Users Data </h4>
			</div>
			<div class="default-table">
				<!-- Show Messages if Exist -->
				<div class="message"></div>

				<table>
					<thead>
						<tr>
							<th>ID</th>
							<th>Username</th>
							<th>Full Name</th>
							<th>Actions</th>
						</tr>
					</thead>
					<tbody>
						<?php 
							if (is_array($usersData)) {
								foreach ($usersData as $user) { ?>
									<tr>
										<td><?=$user['user_id']?></td>
										<td><?=$user['username']?></td>
										<td><?=$user['full_name']?></td>
										<td>
											<a href="#" class="show-edit-form" id="<?=$user['user_id']?>">
											 Edit </a> |
											<a href="user.php?action=delete&user_id=<?=$user['user_id']?>">Delete</a>
										</td>
									</tr>	
								<?php }
							} else { ?>
								<td colspan="4"><?=$usersData?></td>
							<?php }
						?>
					</tbody>
				</table>
			</div>
		</div>

		<!-- Show Order Data -->
		<div class="row">
			<div class="row-header">
				<h4 class="title">Orders Data </h4>
			</div>
			<div class="default-table order-table">
				<!-- Show Messages if Exist -->
				<div class="message"></div>
				<table id="order-data-table">
					<thead>
						<tr>
							<th>ID</th>
							<th>Order Name</th>
							<th>Owner</th>
							<th>Date</th>
							<th>Actions</th>
						</tr>
					</thead>
					<tbody>

					</tbody>
				</table>
			</div>
		</div>
	</div>

	<!-- Edit Form -->
		<div class="edit-form-container">

		</div>

	<!--------------->

	<script>
		$(function() {	
			// User 		
			$('.show-edit-form').click(function(event) {
				event.preventDefault();
				$('.edit-form-container').empty();

				var user_id = $(this).attr('id');
				$.ajax({
					type:'post',
					url:'edit_form.php',
					data:{'user_id':user_id},
					success: function(data) {
						// console.log(data);
						$('.edit-form-container').fadeIn(300, function() {
							$(this).prepend(data);
							$('.edit-form').click(function(event) {
								event.stopPropagation();
							});

							$(this).click(function() {
								$(this).fadeOut(300);
							});

							// Edit User AJAX
							var form = $('#ajax-edit-form');
							$(form).submit(function(e) {
								e.preventDefault();
								var formData = $(form).serialize();
								$.ajax({
									type:'post',
									url:$(form).attr('action'),
									data:formData,
									success: function(data) {
										$('.edit-form-container').fadeOut(300);
										$(".message").addClass('show').html("<p>User Edit Successfully.</p>").delay(2000).fadeOut(350, function() {
											window.location.reload();
										});	
									},
									error: function() {

									}
								});
							});
						});
					},
					error: function() {
						console.log('something wrong!');
					}
				});
			});

			// Order
			$(window).on('load', function() {
				$.ajax({
					type:'get',
					url:'order.php',
					data:'',
					success: function(data) {
						$('.order-table tbody').prepend(data);
					}
				});
			});


			var orderForm = $('#order-form');
			$(orderForm).submit(function(e) {
				e.preventDefault();
				var orderFormData = $(orderForm).serialize();
				$.ajax({
					type:'post',
					url:$(orderForm).attr('action'),
					data:orderFormData,
					success: function(data) {
						if ( data == 'true') {
							$(".order-form .message").addClass('show').html("<p>Order Added Successfully.</p>").delay(1500).fadeOut(500);
							$.ajax({
								type:'post',
								url:'order.php',
								data:{'action':'select'},
								success: function(data) {
									$('.order-table tbody').empty();
									$('.order-table tbody').prepend(data);
								}
							});
						}
					},
					error: function () {

					}
				});
			})
		});
	</script>
</body>
</html>