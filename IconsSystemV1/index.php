<!DOCTYPE html>
<html>
<?php require_once("config/settings.php"); ?>
<head>
	<link href="img/favicon.png" rel="shortcut icon">
	<link href="css/style.css" rel="stylesheet">
	<title><?php echo $CommunityName; ?> - IconsSystem</title>
	<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
</head>
<div class="container">
    <h3 class="text-center community-title"><?php echo $CommunityName; ?></h3>
    <hr>
</div>

<div class="container">
    <div class="row">
		<div class="col-xs-12 col-sm-6 col-md-4 col-sm-offset-3 col-md-offset-4">
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
			<?php } ?>
			<div class="panel panel-default">
				<div class="panel-heading">Choose Your Games:</div>
				<ul class="list-group">
				<?php foreach($games_groups as $game) {?>
					<li class="list-group-item">
					<?php echo $ts3_VirtualServer->serverGroupList()[$game]; ?>
						<div class="material-switch pull-right">
							<input id="<?php echo $game; ?>" type="checkbox" class="checkbox" <?php echo im_i_in_it($game, 'checked' ,''); if($im_banned == 1 || $im_online !== 1) { echo " disabled"; }?> />
							<label for="<?php echo $game; ?>" class="label-success"></label>
						</div>
					</li>
					<?php } ?>
				</ul>
				<div class="panel-heading text-right" id="Games"></div>
			</div>
		<?php } ?>
		</div>
	</div>
	<?php if($games_limit !== 0) {?>
	<script>
	$(function(){
		$("input[type=checkbox]").click(function(){
			if ($('input[type=checkbox]:checked').length <= <?php echo $games_limit;?>) {
				$('input[type=checkbox]').attr('disabled', 'true');
				var id = $(this).attr('id');
				$.ajax({
					method: "POST",
					data:{servergroup:id},
					success:function(html) {
						swal({
							title: 'Success!',
							icon: 'success',
							timer: 5000,
							button: {
								text: "Ok",
								value: true,
								visible: true,
								className: "btn btn-primary"
							}
						});
						$('input[type=checkbox]').removeAttr('disabled');
					}
				});
			}
		});
		$("input[type=checkbox]").click(function(){
			var checkedGames = $('input:checkbox:checked').length;
			var totalGames = $('input:checkbox').length;
			document.getElementById('Games').innerHTML = 'Your Games : ' + checkedGames + '/<?php echo $games_limit;?>';
		});
		var checkedGames = $('input:checkbox:checked').length;
		var totalGames = $('input:checkbox').length;
		document.getElementById('Games').innerHTML = 'Your Games : ' + checkedGames + '/<?php echo $games_limit;?>';
		$('input[type=checkbox]').on('change', function (e) {
			if ($('input[type=checkbox]:checked').length > <?php echo $games_limit;?>) {
				$(this).prop('checked', false);
				swal({
					title: 'Error!',
					text: 'Max games reached!',
					icon: 'error',
					timer: 5000,
					button: {
							text: "Ok",
							value: true,
							visible: true,
							className: "btn btn-primary"
						}
				});
			}
		});
	});
	</script>
	<?php } ?>
</div>
