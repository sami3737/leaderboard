<?php
include_once(__DIR__ ."/api/mysql/Db.class.php");
if(isset($_POST['server']))
{
	$Query = new DB($_POST['server']);
}else
	$Query = new DB( );
$rank = array();

try
{
	$rank = json_encode($Query->query("Select * FROM playerdata ORDER BY PVPKills DESC",(Array('limit' => 0))));
	$fullrank = $rank;

	$Query->CloseConnection();
}
catch( Exception $e )
{
	echo $e->getMessage( );
}
?>
<script type="text/javascript">
	var arr = <?php echo $fullrank; ?>;
	$(document).ready(function(){
		showResults();
		
		$('#ranks').DataTable();

		function showResults () {
			var html = '';
			for (var e in arr) {
				html += '<tr>'
					+'<td><span title="Click to view profil"><a target="_blank" href="http://steamcommunity.com/profiles/'+arr[e].UserID+'">'+arr[e].Name+'</a></span></td>'
					+'<td>'+arr[e].PVPKills+'</td>'
					+'<td>'+arr[e].PVEKills+'</td>'
					+'<td>'+arr[e].Deaths+'</td>'
					+'<td>'+arr[e].Suicides+'</td>'
					+'<td>'+arr[e].TimesHealed+'</td>'
					+'<td>'+arr[e].TimesWounded+'</td>'
					+'<td>'+arr[e].BulletsFired+'</td>'
					+'<td>'+arr[e].HeliKills+'</td>'
					+'<td>'+arr[e].PVEDistance+'</td>'
					+'<td>'+arr[e].PVPDistance+'</td>'
					+'<td>'+arr[e].SleepersKilled+'</td>'
				+'</tr>';
			}
			$('#results').html(html);
		}
	});
</script>
<style>
table {
    margin: 3px;
}
table th {
    font-weight: bold;
    cursor: pointer;
}
table th, table td {
    padding: 3px;
    border: 1px solid #000;
}
</style>
<center>
	<table id="ranks" class="tablesorter">
		<thead id="headings">
			<tr>
                <th id="playerName" style="width:50px;">Name</th>
                <th id="kills">PVP Kills</th>
                <th id="players">PVE Kills</th>
                <th id="suicides">Deaths</th>
                <th id="suicides">Suicides</th>
                <th id="suicides">Times Healed</th>
                <th id="suicides">Times Wounded</th>
                <th id="suicides">Bullets Fired</th>
                <th id="suicides">Heli Kills</th>
                <th id="suicides">Longest PVE Kill Distance</th>
                <th id="suicides">Longest PVP Kill Distance</th>
                <th id="suicides">Sleepers Killed</th>
            </tr>
		</thead>
		<tbody id="results">
			<!-- this will be auto-populated -->
		</tbody>
	</table>
</center>