<?php 
include('helper.php');

if ( isset($_POST['submit']) && $_POST['action'] == 'insert' ) {
	// prepare data to insert
	$data = [
		'username' 		=> validate($_POST['username']),
		'full_name' 	=> validate($_POST['full_name']),
		'email' 		=> validate($_POST['email']),
		'password'   	=> password_hash($_POST['password'], PASSWORD_DEFAULT)
	];
	
	if (insert('user', $data)) {
		header('Location:index.php');
	}
}

if (isset($_POST['action']) && $_POST['action'] == 'edit' && $_POST['user_id'] != '') 
{
	$user_id =  $_POST['user_id'] ;

	$data = [
		'username' 		=> validate($_POST['username']),
		'full_name' 	=> validate($_POST['full_name']),
		'email' 		=> validate($_POST['email'])
	];

	if ($_POST['password'] !== "") 
	{
		$data['password'] = password_hash($_POST['password'], PASSWORD_DEFAULT);
	}
	update('user', $data, $user_id);
} 
elseif (isset($_GET['action']) && $_GET['action'] == 'delete' && $_GET['user_id'] != '') 
{
	if (deleteRow('user', 'user_id',  $_GET['user_id'])) {
		header('Location:index.php');
	} else {
		echo 'User does\'nt delete'; 
	}
} 
else 
{
	header('Location:index.php');
}
?>