<!doctype html>
<html lang="en">
<?php require_once("config/config.php"); ?>
<head>
	<link href="img/favicon.png" rel="shortcut icon">
	<title><?php echo $CommunityName; ?> - Channels Creator</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
	<link href="css/style.css" rel="stylesheet">
</head>
<div class="container">
    <h3 class="text-center community-title"><?php echo $CommunityName; ?></h3>
    <hr>
</div>
<body class="text-center">
<div class="main-panel">
<div class="content-wrapper">
<div class="row">
<div class="col-lg-3 grid-margin stretch-card"></div>
<div class="col-lg-6 grid-margin stretch-card">
<div class="card">
<div class="card-body" style="background-color: #eaeaea;">
		<?php if($connection_error == 1) { ?>
			<div class="alert alert-fill-danger text-center" role="alert">
				<i class="fas fa-exclamation-circle mb-2"></i><br>
				Oh Shit! We Have a Probleme Connecting The Server.<br>
				If you are an Owner, Please check The Log File.
			</div>
		<?php } else { ?>
			<?php if($im_banned == 1) { ?>
			<div class="alert alert-fill-danger text-center" role="alert">
				<i class="fas fa-exclamation-circle mb-2"></i><br>
				Oh Shit! You are banned from Using IconsSystem.<br>
				Please Contact Your Admin to know MORe.
			</div>
			<?php } ?>
			<?php if($im_online !== 1) { ?>
			<div class="alert alert-fill-danger text-center" role="alert">
				<i class="fas fa-exclamation-circle mb-2"></i><br>
				Oh Shit! You are ot connected to Our Teamspeak Server.<br>
				Click <a href="ts3server://<?php echo $teamspeak3["server_ip"].':'.$teamspeak3["server_voice_port"]; ?>">Here</a> to connect.
			</div>
			<?php } else { ?>
	<form method="POST">
		<div class="form-group">
			<label for="channelname">Channel Name</label>
			<input type="text" class="form-control" id="channelname" placeholder="Channel Name" name="channel">
		</div>
		<div class="form-group">
			<label for="password">Channel Password</label>
			<input type="password" class="form-control" id="password" placeholder="Channel Password" name="password">
			<small id="emailHelp" class="form-text text-muted">Leave it blank for no password.</small>
		</div>
		<input type="submit" class="btn btn-success" value="Create">
		<?php if($created == 1) {?>
					<div class="alert alert-fill-success text-center mt-2" role="alert">
				<i class="fas fa-exclamation-circle mb-2"></i><br>
				Channel has been created.
			</div>
		<?php } else{ if(isset($_POST['channel'])) {?>
							<div class="alert alert-fill-danger text-center mt-2" role="alert">
				<i class="fas fa-exclamation-circle mb-2"></i><br>
				Error while creating channel.
			</div>
		<?php }} ?>
		<?php if($moved == 1) {?>
							<div class="alert alert-fill-success text-center mt-2" role="alert">
				<i class="fas fa-exclamation-circle mb-2"></i><br>
				You have been moved to your channel.
			</div>
		<?php } ?>
		<?php if($added == 1) {?>
							<div class="alert alert-fill-success text-center mt-2" role="alert">
				<i class="fas fa-exclamation-circle mb-2"></i><br>
				You have beed added to channel aministration.
			</div>
		<?php } ?>
	</form>
		<?php }} ?>
</div>
</div>
</div>
</div>
</div>
</div>
</body>

</html>