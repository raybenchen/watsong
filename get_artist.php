<!DOCTYPE HTML>
<html>
<head>
	<link rel="stylesheet" href="theme.css" />
	<title>WatSong - Mood Based Music Recommendations</title>
	<script src="js/jquery-1.11.3.min.js"></script>
</head>
<body>
			<?php 
			
			//Connect to database
			require_once("connect_db.php");
			require_once("algorithm.php");

			//Pull trait information from database
			$songname = $_POST["name"];
			$sql = "SELECT * FROM \"USER04893\" . \"Songs\" WHERE \"title\" = LCASE('".$songname."')";
			$stmt = db2_exec($conn4, $sql);
			$losongs;
			$row;
			
			//Fetches the list of similar songs
			if (!$stmt) {
				echo "SQL Statement Failed" . db2_stmt_errormsg() . "";
				return;
			}
			else {
				$row = db2_fetch_array($stmt);
	 			$top = getSongs($row);
     			$losongs = $top;
			}
			
			?>
	<br>
	<center><img src="images/logo.png" height="300px" width="300px" /></center>
	<table>

		<tr>
			<td colspan="3">The song you searched for is: <?php echo ucwords($row[0]); ?> by <?php echo ucwords($row[1]); ?></td>
		</tr>
		
    <tr>
		<td>
			</td>
				<br> 
			<td>
		</td>
	</tr>
	
    <tr>
		<td colspan="3"><br>Below are the top 5 most similar entries: </td>
	</tr>
	
    <tr>
		<td></td><br> 
		<td></td>
	</tr>
					
							
		<?php 
							
		//These tags are for the youtube link formatting
			$tagstart = "<iframe width=\"420\" height=\"315\" src=\"";
			$tagend = "\" frameborder=\"0\" allowfullscreen></iframe>";
								
		// The following prints out the table	
			echo "<tr> <th> Title </th> <th> Artist </th> <th> Link </th> </tr>";
			for ($i=0; $i<5; $i++) {
				echo "<tr><td>" . ucwords($losongs[$i][0]) . "</td><td>" . ucwords($losongs[$i][2]) . "</td><td>" . '<ul class="list"> <li> <a>'."Youtube Link".'</a> <ul> <li>' . $tagstart . $losongs[$i][3] . $tagend .'</li> </ul> </li> </ul>' . "</td></tr>";
			}
			echo "</table>";
		
		?>
		<?php
		db2_close($conn4);
		?>
		
		
<script type="text/javascript">
function downloadJSAtOnload() {
var element = document.createElement("script");
element.src = "js/scripts.js";
document.body.appendChild(element);
}
if (window.addEventListener)
window.addEventListener("load", downloadJSAtOnload, false);
else if (window.attachEvent)
window.attachEvent("onload", downloadJSAtOnload);
else window.onload = downloadJSAtOnload;
</script>

</body>
</html>
