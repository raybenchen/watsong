<?php
function getHighest($a){
	$high = $a[0][1];
	$index = 0;
	for($j =1; $j < 5; $j++){
		if ($a[$j][1] > $high){
			$high = $a[$j][1];
			$index = $j;
		} 
	}
	return $index;
}

function getSongs($primSong){
	//First step is to retrieve the personality values of the user

	//Connect to database
	include("connect_db.php");
	if (!$conn4) {
	    echo "Connection failed.";
	    print db2_conn_errormsg() . "<br>";
	    return;
	}
	
	
	//Run SQL Command to retrieve full database of songs
	$sql = "SELECT * FROM \"USER04893\" . \"Songs\" WHERE \"title\" != LCASE('" . $primSong[0] . "')";
	$stmt = db2_exec($conn4, $sql);
	if (!$stmt) {
		print "SQL Statement Failed <br>";
		$msg = db2_st_errormsg();
		print db2_stmt_errormsg();
		print "Error Messsage:";
		print $msg . "<br>";
		return;
	}

	/*Retrieve a song's personality values from the database
	 
		
		Pull as a singular record
		
		song   |   artist 	|	trait 1	|	trait 2	|	trait 3	| .....
	
	*/ 
	
	
	//print $primSong[2];
	$arrayLength = 7; //Number of elements in the array
	 
	//Beginning of looping to find most compatible song
	$top = array();
	$greatest = 0;
	$index =0;
	$aSize = 0;
	while($song = db2_fetch_array($stmt))
	{
		$difference = 0;

		for($j = 2; $j < $arrayLength; $j++)
		{	
		//Now we compare the user's personality values to the song's personality values, here we want the absolute difference
				$difference += abs($primSong[$j] - $song[$j]);
		}

		//Look into top array and see if it should be recommended 
		if($aSize >= 5 && $difference < $greatest)
		{	//Continue the search, but with the higher value now
				$top[$index][0] = $song[0];
				$top[$index][1] = $difference;
				$top[$index][2] = $song[1];
				$top[$index][3] = $song[7];
				$index = getHighest($top);
				$greatest = $top[$index][1];
		}elseif($aSize < 5){
			$top[$aSize][0] = $song[0];
			$top[$aSize][1] = $difference;
			$top[$aSize][2] = $song[1];
			$top[$aSize][3] = $song[7];			
			if($difference > $greatest) {
				$greatest = $difference;
				$index = $aSize;
			}
			$aSize++;
		}
		
		
	}
	return $top;
	
}



?>