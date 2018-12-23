<?php
include('helper.php'); 
if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['user_id'] != '') {
 	$editUser = selectRowFrom('user', 'user_id', $_POST['user_id']);

?>
<div class="half-row user-form edit-form">
	<div class="row-header"> 
		<h4 class="title">Edit User</h4>
	</div>
	<form action="user.php" method="post" accept-charset="utf-8" id="ajax-edit-form">
		<input type="hidden" name="action" value="edit">
		<input type="hidden" name="user_id" value="<?=$editUser['user_id']?>">
		<div class="form-item">
			<label for="edit_username">Username</label>
			<input id="edit_username" type="text" name="username" value="<?=$editUser['username']?>" required>
		</div>
		<div class="form-item">
			<label for="edit_fullname">Full Name</label>
			<input id="edit_fullname" type="text" name="full_name" value="<?=$editUser['full_name']?>" required>
		</div>
		<div class="form-item">
			<label for="edit_email">Email</label>
			<input id="edit_email" type="email" name="email" value="<?=$editUser['email']?>" required>
		</div>
		<div class="form-item">
			<label for="edit_password">Password</label>
			<input id="edit_password" type="password" name="password" >
		</div>
		<div class="form-item">
			<input type="submit" name="submit" value="Edit User">
		</div>
	</form>
</div>
<?php 	}
?>