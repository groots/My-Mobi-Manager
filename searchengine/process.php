<?php

require_once 'class.search.php';

$config = array('localhost','squish7_expert','XmjujdK*I;6%','squish7_miMoby');
$table = 'mobilemanager_page';
$key = 'pageid';
$fields = array('Pagetitle','content');

$keyword = $_GET['keyword'].' '.$_GET['location'];

$found = new search_engine($config);
$found->set_table($table);
$found->set_primarykey($key);
$found->set_keyword($keyword);
$found->set_fields($fields);

$result = $found->set_result();
//print_r($result);

// Display the results
$data = join( ",", $result);
$sql = "SELECT * FROM mobilemanager_page WHERE pageid IN ($data) AND mobiSiteId = '". $_GET['mobileSiteId'] . "'";
$process = @mysql_query($sql);
echo "<h1>Search Results for '"  . $keyword . "'</h1> <pre><table border='0'>";
while ($row = mysql_fetch_object($process))
{
    echo "<tr>";
    echo "<td>".$row->pageid."</td>";
    echo "<td><a href='".$row->Seourl."'>".$row->Pagetitle."</a></td>";
    echo "</tr>";
}
echo "</table>"

?>


