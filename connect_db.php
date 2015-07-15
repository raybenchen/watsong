<?php
				if( getenv("VCAP_SERVICES") ) {
				    $json = getenv("VCAP_SERVICES");
				} 
				# No DB credentials
				else {
				    echo "No vcap services available.<br>";
				    return;
				}
				
				# Decode JSON and gather DB Info
				$services_json = json_decode($json,true);
				$blu = $services_json["sqldb"];
				if (empty($blu)) {
				    echo "No SQLDB service instance is bound. Please bind a SQLDB service instance<br>";
				    return;
				}
				
				//echo "Found sqldb env variables.<br> <br>";
				
				$bludb_config = $services_json["sqldb"][0]["credentials"];
				
				// create DB connect string
				$conn_strin = "DRIVER={IBM DB2 ODBC DRIVER};DATABASE=".
				   $bludb_config["db"].
				   ";HOSTNAME=".
				   $bludb_config["host"].
				   ";PORT=".
				   $bludb_config["port"].
				   ";PROTOCOL=TCPIP;UID=".
				   $bludb_config["username"].
				   ";PWD=".
				   $bludb_config["password"].
				   ";";
				   
				  //echo "Printing out ENVIRONMENT VARIABLES: <br>";
				  //echo "db = " . $bludb_config["db"]. "<br>";
				  //echo "host = " . $bludb_config["host"] . "<br>";
				  //echo "port = " . $bludb_config["port"] . "<br>";
				  //echo "username = " . $bludb_config["username"] . "<br>";
				  //echo "passwd = " . $bludb_config["passwd"] . "<br>";
				  
				  
				
				// connect SQLDB
				$conn4 = db2_connect($conn_strin, '', '');
				
				if (!$conn4) {
				    echo "Connection failed.";
				    print db2_conn_errormsg() . "<br>";
				    return;
				}
?>