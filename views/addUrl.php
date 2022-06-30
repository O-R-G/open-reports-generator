<?
$sql = 'SELECT name1, id FROM objects';
$res = $db->query($sql);
$items = array();
while ($obj = $res->fetch_assoc())
	$items[] = $obj;
$res->close();

foreach($items as $item)
{
	if($item['url'] == 'NULL')
	{
		$sql = 'UPDATE objects SET url = "'.slug($item['name1']).'" WHERE id = '.$item['id'];
		echo $sql . '<br>';
		$res = $db->query($sql);
	}
}

?>