<?php
function is_session_started()
{
    if ( php_sapi_name() !== 'cli' ) {
        if ( version_compare(phpversion(), '5.4.0', '>=') ) {
            return session_status() === PHP_SESSION_ACTIVE ? TRUE : FALSE;
        } else {
            return session_id() === '' ? FALSE : TRUE;
        }
    }
    return FALSE;
}

// Example
if ( is_session_started() === FALSE ) session_start();

require __DIR__ . '/api/SourceQuery/bootstrap.php';
use xPaw\SourceQuery\SourceQuery;
define( 'SQ_SERVER_ADDR', '127.0.0.1' );
define( 'SQ_SERVER_PORT', 28015 ); // udp
define( 'SQ_RCON_PORT', 28016 ); // tcp - only for SourceQuery::SOURCE
define( 'SQ_TIMEOUT',     2 );
define( 'SQ_ENGINE',      SourceQuery::SOURCE );

 $Source = new SourceQuery( );
$serverinfo = null;
$playercount = 0;
try
{
	 $Source->Connect( SQ_SERVER_ADDR, SQ_SERVER_PORT, SQ_RCON_PORT, SQ_TIMEOUT, SQ_ENGINE );
	 $Source->SetRconPassword('g8P3mUH9uqBdqDgR');
	 $serverinfo = $Source->GetRules();
	 $playercount = $Source->GetPlayers();
}
catch( Exception $e )
{
	echo $e->getMessage( );
}
 $Source->Disconnect( );

?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content=" - ">
		<meta name="keywords" content="rust, webshop, evolution, donate, experimental">
		<title>stats - Rust</title>
		<link rel="stylesheet" href="css/style.css" type="text/css">
		<script type="text/javascript" src="http://code.jquery.com/jquery-latest.js"></script>
		<script src="js/jquery.animateNumber.min.js"></script>
		<link rel="stylesheet" type="text/css" href="css/datatables.min.css"/>
		<script type="text/javascript" src="js/datatables.min.js"></script>
		<script src="js/underscore-min.js"></script>
        <link rel="shortcut icon" href="./img/favicon.ico" type="image/x-icon">
		<script type="text/javascript" src="js/jquery.tablesorter.js"></script>
		<script type="text/javascript">
			
            {
				if (screen.width >= 1920)
				document.write ('<style>body {zoom: 150%; -moz-transform: scale(150%); -moz-transform-origin: 0 0; -o-transform: scale(150%); -o-transform-origin: 0 0;-webkit-transform: scale(150%); -webkit-transform-origin: 0 0; transform: scale(150%); transform-origin: 0 0; }</style>');

				else if (screen.width >= 1600)
				document.write ('<style>body {zoom: 130%; -moz-transform: scale(130%); -moz-transform-origin: 0 0; -o-transform: scale(130%); -o-transform-origin: 0 0;-webkit-transform: scale(130%); -webkit-transform-origin: 0 0; transform: scale(130%); transform-origin: 0 0; }</style>');

				else if (screen.width >= 1440)
				document.write ('<style>body {zoom: 125%; -moz-transform: scale(125%); -moz-transform-origin: 0 0; -o-transform: scale(125%); -o-transform-origin: 0 0;-webkit-transform: scale(125%); -webkit-transform-origin: 0 0; transform: scale(125%); transform-origin: 0 0; }</style>');
			}
			
			function loadRank(serverID)
			{
				$(".wrap").html("<img src='img/Loading.gif'/>");
				var posting = $.post("rank.php", { server: serverID });
				posting.done(function( data ) {
					$(".wrap").html(data);
				});
			}
		</script>
	</head>
	<body>
	<div class="serverinfo">
		<fieldset>
		<?php
		if($serverinfo == null)
		{
			echo 'Please set correctly your settings from the header.php file.';
		}
		else
		{
			echo '<p>Fps: '.$serverinfo['fps'].'</p>';
			echo '<p>Server '.($serverinfo['pve'] ? 'PVE' : 'PVP').'</p>';
			echo '<p>Server seed: '.$serverinfo['world.seed'].'</p>';
			echo '<p>Map size: '.$serverinfo['world.size'].'</p>';
			echo '<p>Entity count: '.$serverinfo['ent_cnt'].'</p>';
			echo '<p>Player Count: '.count($playercount).'<p>';
		}
		?>
		</fieldset>
	</div>
<script type="text/javascript">

$(window).load(function() {
	$.ajax({
		url : "./chat.log",
		dataType: "text",
		success : function (data) {
			var lines = data.split("\n");
			var i = lines.length;
			while (i--) {
				$("#chat").append(lines[i]+"<br />");
			}
		}
	});
	setInterval(function(){
		$.ajax({
			url : "./chat.log",
			dataType: "text",
			success : function (data) {
				$("#chat").html("");
			var lines = data.split("\n");
			var i = lines.length;
				while (i--) {
					$("#chat").append(lines[i]+"<br />");
				}
			}
		});
	}
	, 3000);
}); 
</script>

<div id="chat">

</div>	<br />
	<br />
	<br />
	<div class="menu">
		<center>
			<table id="menu">
				<thead>
					<tr>
						<th id="playerName" style="width:50px;">Leaderboard</th>
					</tr>
				</thead>
			</table>
		</center>
		<div class="warning">
			<p>
			<font color="orange">	These Stats Reset Every Server Wipe! Try your best to be at the top!</font>
			</p>
		</div>
	</div>
		<div class="wrap">
