<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta http-equiv="Content-Style-Type" content="text/css" />
  <meta name="generator" content="pandoc" />
  <title>Corona Docs: API </title>
  <meta name="revised" content="28-Jun-2012" />
  <meta name="description" content="Whether you're new to Corona or want to take your app to the next level, we've got a wealth of resources for you including extensive documentation, API reference, sample code, and videos.  API " />
  <link rel="stylesheet" href="//coronalabs.stagingcode.com/wp-content/themes/wordpress-bootstrap-v2.1/css/simple-bootstrap.css" type="text/css" />

  <link rel="stylesheet" href="../css/style.css" type="text/css" />

<script src="//www.coronalabs.com/wp-content/themes/corona-labs/js/docs.js"></script> 
 </head>
<body>
<div class="header"></div>
<div class="title">
	<span class="titleimg" onclick="window.location='http://docs.coronalabs.com/api/index.html'"></span>
	<div id="nav">
		<ul>
<li><a href="index.html">APIs</a></li>
<li><a href="../native/index.html">Native Coding</a></li>
<li><a href="../guide/index.html">Guides</a></li>
<li><a href="http://www.coronalabs.com/blog/topics/tutorials/">Tutorials</a></li>
</ul>


		<div id="resources-link"><a href="http://www.coronalabs.com/resources/">Corona Resources</a> &#9657;</div>
	</div>
</div>
<div class="TOCheader"></div>



<div id="TOC">
<!--sidebar-->
</div>
<div id="breadcrumb">
<a href="http://docs.coronalabs.com">Corona Docs</a>  ?  <a href="index.html">API</a>
</div>
<div class="section level1" id="corona-api-reference">
<h1><a href="/search/">Search The Corona API Reference</a></h1>


<?php
//error_reporting(E_ALL);
//ini_set('display_errors', 'On');

include('/home/91435/domains/coronalabs.com/html/include/classes/custom-search/google.php');

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

if(!isset($_GET['scope']) || $_GET['scope'] == '') {
    $cs->setDomainScope();
}

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

?>




</div>
</body>
</html>