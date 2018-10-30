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
$CommunityName = "The Deathly Elite"; // Community Name, Shown In The Index Page.
$enable_ban = 1; //If a users is in a specific Server Group, he won't be permited to use The IconsSystem. Set 0 to desactivate and 1 to activate.
$ban_at_spam = 1; // If users tried to Spam and Hack The Server, He will get banned. Set 0 for disable it and 1 to enable it.
$ban_time = 60; //Set The Ban time if User tired to spam the server, Time must be with seconds . Set 0 for a permanent ban . You need to set $ban_at_spam to 1 to enable this.
$games_limit = 7; // If the user reached the max number of games th iconssystem don't work, put 0 to deactivate
////////////////////////////////////////////////////////////
$games_groups = array(67,68,69,70,71,72,73,74,75,76,77,78,79,80,81,82,83,84,85,86,87,88,89,90,91,92,93,94,95); // Games Group Ids Array. Contact Your Seller For Help
$banned_users = array(10); // Banned server groups Ids Array, You have to set $enable_ban at 1. Contact Your Seller For Help
/////////////////////////////////////////////////
//*********************//
/* Never Touch This */
//*********************//
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
function im_i_in_it($sg, $answer1, $answer2) {
	global $online_client;
	global $online_client_groups;
	if(in_array($sg, $online_client_groups)) {
		return $answer1;
	} else {
		return $answer2;
	}
}
foreach($banned_users as $banned_user) {
	if(in_array($banned_user, $online_client_groups)) { $im_banned = 1; }
}
if(isset($_POST['servergroup']) && $im_online == 1 && $im_banned !== 1) {
	if(!in_array($_POST['servergroup'], $games_groups) && $ban_at_spam == 1) { try { $online_client->ban($ban_time, 'Spam is Not Allowed :'); } catch(Exception $e) {} }
	if(in_array($_POST['servergroup'], $games_groups)) {
		try {
			if(in_array($_POST['servergroup'], $online_client_groups)) {
				$online_client->remServerGroup($_POST['servergroup']);
			} else {
				$online_client->addServerGroup($_POST['servergroup']);
			}
		}
		catch(Exception $e) {};
	}		
}