<?php
require_once("TeamSpeak3/TeamSpeak3.php");
error_reporting(0);
set_time_limit(0);
session_start();
////////////////////////////////////////////
/* TeamSpeak3 Config */
$teamspeak3 = array(
"query_login_name" => "serveradmin", // Query Login Name, Default : serveradmin.
"query_login_password" => "LLwvJ8yM", // Query Login Password.
"server_voice_port" => 9987, // Server Voice Port, Default 9987.
"server_query_port" => 10011, // Server Query Port, Default 10011.
"server_ip" => "127.0.0.1" // Server Voice Ip.
);
////////////////////////////////////////////////////////
$CommunityName = "The Deathly Elite"; // Community Name, Shown In The Index Page.
$enable_ban = 1; //If a users is in a specific Server Group, he won't be permited to use The IconsSystem. Set 0 to desactivate and 1 to activate.
$banned_users = array(10); // Banned server groups Ids Array, You have to set $enable_ban at 1. Contact Your Seller For Help
/////////////////////////////////////////////////////////
/* Never touch this */
try { $ts3_VirtualServer = TeamSpeak3::factory("serverquery://".$teamspeak3["query_login_name"].":".$teamspeak3["query_login_password"]."@".$teamspeak3["server_ip"].":".$teamspeak3["server_query_port"]."/?server_port=".$teamspeak3["server_voice_port"]."&blocking=0&nickname=".urlencode("TDE | IconsSystem - ").rand(0, 100));
	foreach ($ts3_VirtualServer->clientList() as $client) {
		if ($client->getProperty('connection_client_ip') == $_SERVER["REMOTE_ADDR"]) {
			$_SESSION['uid'] = $client["client_unique_identifier"];
			$im_online = 1;
		}
	}
}
catch (Exception $e) { $connection_error = 1; }
if($im_online == 1) {
	$online_client = $ts3_VirtualServer->clientGetByUid($_SESSION['uid']);
	$online_client_groups = explode(",",$online_client["client_servergroups"]);
}
foreach($banned_users as $banned_user) {
	if(in_array($banned_user, $online_client_groups)) { $im_banned = 1; }
}
if(isset($_POST['channel']) && isset($_POST['password']) && $im_banned !== 1 && $im_online == 1) {
	try {
		$client = $ts3_VirtualServer->clientGetByUid($_SESSION['uid']);
		$created_channel = $ts3_VirtualServer->channelCreate(array(
			"channel_name" => $_POST["channel"],
			"channel_topic" => 'Created from panel',
			"channel_password" => $_POST["password"],
			"channel_codec" => TeamSpeak3::CODEC_OPUS_MUSIC,
			"channel_flag_permanent" => FALSE,
		));
		$created = 1;
		try { 
			$client->move($created_channel); 
			$moved = 1;
			try	{ 
				$client->setChannelGroup($created_channel, 9); 
				$added = 1;
			}
			catch (Exception $e){}
		}
		catch(Exception $e){ $created = 0;}
}
catch(Exception $e){}
}