<?php 

	// Output CSV and exit

	if ( isset($_GET['csv']) ) {
		$sqlQuery = trim($item['body']);

    	// Run report
        $sql = $sqlQuery;
    	$result = $db->query($sql);
		$csv = "";

		while ($myrow = $result->fetch_assoc())
			$csv .= $myrow['name1'] . ",". $myrow['address1'] . "," . $myrow['city'] . "," . $myrow['state'] . "," . $myrow['zip']. "," . $myrow['country'];
		
		echo $csv;
		exit();
	}

	// Output emails and exit

	if (isset($_GET['emails'])) {
	    $sqlQuery = trim($item['body']);

    	// Run report
        $sql = $sqlQuery;
    	$result = $db->query($sql);
		$emails = "";

		while ( $myrow = $result->fetch_assoc() )
			if ($myrow['email']) $emails .= $myrow['email'] . "\n\r";
		
		echo nl2br($emails);
		exit();
	}
	
	// Generate Report

	if ( !$uu->id ) {

		// Nothing to report

		echo  "Please select a valid report to generate.<br />";
		$result = NULL;

	} else {

		// Custom report selected?
		$items = array();
		$sql = "SELECT * FROM objects, wires WHERE objects.id=$uu->id AND wires.toid=objects.id AND wires.fromid=1 AND objects.active = (SELECT id FROM objects WHERE name1 LIKE '_Reports') AND wires.active=1 LIMIT 1;";
		$result = $db->query($sql);
		// $result = MYSQL_QUERY($sql);
		$myrow = $result->fetch_assoc();
    	if ($myrow) {

			// Yes, run custom report
	
			$sqlQuery = trim($myrow["body"]);
			$sql = $sqlQuery;
			$result = $db->query($sql);
			$report = TRUE;

			if (!$result) {

				echo "Please select a valid custom report to generate.<br />";
				echo $sqlQuery;
			} 
			else
			{
				while ($obj = $result->fetch_assoc())
					$items[] = $obj;
			}

		} else {

			// No, retrieve discreet information
			$items[] = $item;
		}

		// Display table format
	
		$html  = "<table cellpadding='10' border='1' width='900px'>";
	
		// Column headers

		$html .= "<tr style='background-color:#CCCCCC;'>";
		$html .= "<td width='200px'>NAME</td>";
		$html .= "<td width='300px'>ADDRESS</td>";
		$html .= "<td width='300px'>EMAIL</td>";
		$html .= "<td width='100px'>BEGIN / END</td>";
		$html .= "</tr>";

		// Data
		$rownumber = 0;
		foreach($items as $key => $myrow){

			$html .= "<tr style='background-color:#" . (($key % 2) ? "E9E9E9" : "EFEFEF") . ";'>";
			$html .= "<td>" . $myrow['name1'] . "</td>";
			$html .= "<td>" . $myrow['address1'] . "<br />" . $myrow['city'] . " " . $myrow['state'] . " " . $myrow['zip'] . "<br />" . $myrow['country'] . "</td>";
			$html .= "<td>" . $myrow['email'] . "</td>";
			$html .= "<td>" . date("Y M j", strToTime($myrow['begin'])) . "<br />" . date("Y M j", strToTime($myrow['end'])) . "</td>";
			$html .= "</tr>";
		
			$rownumber++;
		}

		$html .= "</table>";
		$html .= "<div id='body'><div class='self-container'>".count($items)." total results found."; 
		echo $html;
	}

	echo "</div>";
	if ($result && !empty($item['body'])){
		echo "<div id='object-actions'>";
		echo "<a href='?csv=1' target='_new'>EXPORT CSV...</a>&nbsp;&nbsp;";
		echo "<a href='?emails=1' target='_new'>EXPORT EMAILS...</a>";
		echo "</div>";
	} 
	echo "</div>";
?>
