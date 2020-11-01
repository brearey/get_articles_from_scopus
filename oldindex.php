<?php
require_once 'vendor/autoload.php';

$pages = 25;

$scopusSearch = new \Scopus\ScopusSearch('c951122905774b2a212c42fbb722659a');
//$affiliationSearch = new \Scopus\AffiliationSearch('c951122905774b2a212c42fbb722659a');

$results = $scopusSearch
         ->query('Yakutsk')
         ->start(0)
         ->count(25) //itemsPerPage
         ->search();

/*
$resultsAff = $affiliationSearch
         ->query('AFFIL(North Eastern Federal University)')
         ->count(25)
         ->search();
*/
//var_dump($results);
//echo (gettype($results));
$data = json_decode($results, true);
//$dataAff = json_decode($resultsAff, true);

$countOfPubs = intval($data['search-results']['opensearch:totalResults']); // Количество публикаций
echo "<pre>";
//echo (gettype($data));
//echo($data['search-results']['entry'][0]['dc:identifier']);
//echo($data['search-results']['entry'][0]['affiliation'][0]['affilname']);
//var_dump($data['search-results']);
//var_dump($dataAff);
//echo ('<hr>');

$countOfResults = 1;

for ($j = 0; $j < $countOfPubs; $j = $j + $pages) {
	$results = $scopusSearch
         ->query('Yakutsk')
         ->start($j)
         ->count(25) //itemsPerPage
         ->search();
    $data = json_decode($results, true);
    for ($i = 0; $i < count($data['search-results']['entry']); $i++) {
		if (strval($data['search-results']['entry'][$i]['affiliation'][0]['affilname']) == "North-Eastern Federal University") {
			echo ('Номер ' . $countOfResults);
			echo "<br>";
			echo($data['search-results']['entry'][$i]['dc:identifier']);
			echo "<br>";
			echo('<b>ISSN: </b>' . $data['search-results']['entry'][$i]['prism:issn']);
			echo "<br>";
			echo('<b>ФИО автора: </b>' . $data['search-results']['entry'][$i]['dc:creator']);
			echo "<br>";
			echo('<b>Название публикации: </b>' . $data['search-results']['entry'][$i]['dc:title']);
			echo "<br>";
			echo('<b>Ссылка на публикацию: </b>' . $data['search-results']['entry'][$i]['prism:url']);
			echo "<br>";
			echo('<b>Университет: </b>' . $data['search-results']['entry'][$i]['affiliation'][0]['affilname']);
			echo "<br>";
			echo "<hr>";
			$countOfResults++;
		}
	}
}
?>