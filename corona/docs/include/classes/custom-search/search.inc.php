<?php
error_reporting(E_ALL);
ini_set('display_errors', 'On');

include($_SERVER['DOCUMENT_ROOT'] . '/include/classes/custom-search/google.php');

if(isset($_POST['q']) || isset($_GET['q'])) {
    $searchTerms = isset($_POST['q']) ? $_POST['q'] : $_GET['q'];
} else {
    $searchTerms = false;
}
if(!empty($_POST['scope']) || !empty($_GET['scope'])) {
    $scope = (isset($_GET['scope']) && !empty($_GET['scope'])) ? $_GET['scope'] : $_POST['scope'];
} else {
    $scope = '';
}

if(isset($_POST['start']) || isset($_GET['start'])) {
    $start = (isset($_GET['start']) && !empty($_GET['start'])) ? $_GET['start'] : $_POST['start'];
    $start = $start + 0;
} else {
    $start = 0;
}


$cs = new googleCustomSearch($searchTerms, $scope, $start);

$titleSearch = array('Mobile Application Development |');

//$cs = new googleCustomSearch($searchTerms, $scope, $start);

$cs->filterTitle($titleSearch, array(''));
//$cs->setDomainScope();
$cs->doSearch();

if(!empty($_GET['debug'])) {
    $cs->debug();
}

//Render our Search Box
$cs->renderBootstrapSearchBox();

    //write the suggestion (if there is one - this check is done in the function itself)
    $cs->writeSuggestion();

if($cs->hasResults()) {


    $cs->writeResultCount();
    //write search results
    $cs->writeSearchResults();

    //write the pagination
    $cs->writePagination();

} else {
    $cs->writeNoResults();
}
