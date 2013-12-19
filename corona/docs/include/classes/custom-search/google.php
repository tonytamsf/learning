<?php

class googleCustomSearch {

    static $searchTerm = false;
    static $escapedTerm = false;
    public $xmlResult = false;
    static $parsedResults = array();
    static $nosResults = false;
    private $cseNumber = '009283852522218786394:g40gqt2m6rq'; //the unique identifier for this Google Custom Search
    static $resultSize = 20;
    static $startNumber = 0;
    static $pageTotal = 0;
    static $searchScope = '';
    static $suggestion = false;
    public $titleSearch = false;
    public $titleReplace = array('');
    static $lastRequest = false;
    public $googleEndPoint = 'http://www.google.com/search';
    public $searchQueries = false;
    static $searchVar = 'q';
    static $searchScriptLocation = '';
    static $scopeEndpoints = array(
            '/' => 'Everything',
            'docs.coronalabs.com/' => 'Documentation',
            'www.coronalabs.com/' => 'Website',
            'developer.anscamobile.com/forum/' => 'Forums',
            'developer.anscamobile.com/code/' => 'Code Exchange'
        );


    function __construct($searchTerm = false, $scope = '', $start = 0, $autoConfigure = true) {
        if($searchTerm) {
            $this->setSearch($searchTerm);
            $this->setScope($scope);
            $this->setStartNumber($start);
        }
        if($autoConfigure) {
            $thisUrl = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
            $thisUrl = explode('?', $thisUrl);
            self::$searchScriptLocation = $thisUrl[0];
            //self::$searchScriptLocation
            //$searchUrlBits = parse_url($searchUrl);
        }
    }

    function doSearch() {
        if(self::$searchTerm) {
            $this->getXml();
        }
    }


    function debug() {
        echo '<div class="well">';
        echo '<dl>';
        echo '<dt>SearchTerm: </dt><dd>' . self::$searchTerm . '</dd>';
        //echo '<hr>';
        echo '<dt>Search Query: </dt><dd>' . $this->searchQueries . '</dd>';
        //echo '<hr>';
        echo '<dt>Total Results: </dt><dd>' . $this->getTotalResults() . '</dd>';
        //echo '<hr>';
        echo '<dt>Search Scope: </dt><dd>' . self::$searchScope . '</dd>';
        echo '<dt>Start Number: </dt><dd>' . self::$startNumber . '</dd>';
        echo '<dt>Number of Pages: </dt><dd>' . $this->getPages() . '</dd>';
        echo '<dt>Page Number: </dt><dd>' . $this->getPageNumber() . '</dd>';

        //echo '<hr>';getPagesgetPageNumber
        echo '</dl>';
        echo '</div>';
    }

    function setScope($scope) {
        self::$searchScope = urldecode($scope);
    }


    function getPages() {
        return 0 + floor(self::$nosResults / self::$resultSize);
    }

    function setDomainScope($domain = false) {
        if(!$domain) {
            $domain = $_SERVER["SERVER_NAME"];
        }
        $this->setScope($domain);
    }

    function setSearch($searchTerm = false) {
        if($searchTerm) {
            self::$searchTerm = $searchTerm;
            self::$escapedTerm = $this->cleanInput($searchTerm);
        }
    }

    function setStartNumber($start = 0) {
        self::$startNumber = $start;
    }

    function hasResults() {
        return 0 + self::$pageTotal;
    }

    function filterTitle($search = false, $replace = false) {
        if($search) {
            $this->titleSearch = $search;
        }
        if($replace) {
            $this->titleReplace = $replace;
        }
    }

    function renderSearchBox() { ?>
        <form action="//<?= $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"] ?>" name="search-form" id="search-form" method="GET">
        <div id="search-query-container" class="search-query-container">
        <div id="search-scope-container">
            <select name="scope" id="search-scope">
                <?php
                foreach(self::$scopeEndpoints as $urlKey => $endpointName) {
                    $selectionValue = (self::$searchScope == $urlKey) ? ' selected ' : '';
                    echo '<option' . $selectionValue .' value="' . ($urlKey) . '">' . $endpointName . '</option>';
                }
                ?>
            </select>
        </div>
        <div id="search-term-container">
            <input type="text" name="q" id="search-term" value="<?= self::$searchTerm ?>" placeholder="What are you looking for?" / >
        </div>
        <div id="search-button-container">
            <button type="submit" id="search-button">Search</button>
        </div>
        </div>
        </form>
    <?php
    }


    function renderBootstrapSearchBox() { ?>
        <div class="row-fluid">
            <form action="//<?= $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"] ?>" name="search-form" id="search-form" method="GET" class="well form-search ac bootstrap">
                <select name="scope" id="search-scope" class="span2">
                    <?php
                    foreach(self::$scopeEndpoints as $urlKey => $endpointName) {
                        $selectionValue = (self::$searchScope == $urlKey) ? ' selected ' : '';
                        echo '<option' . $selectionValue .' value="' . ($urlKey) . '">' . $endpointName . '</option>';
                    }
                    ?>
                </select>
                <input type="text" name="q" id="search-term" value="<?= self::$searchTerm ?>" placeholder="What are you looking for?" class="span6" / > 
                <button type="submit" class="btn" id="search-button"><i class="icon-search"></i></button>
            </form>
        </div>
    <?php
    }

    //a handy function to clean the inputs from a search query
    function cleanInput($input) {
        $input = preg_replace('/[^a-zA-Z0-9\s]/', '', $input);
        $input = str_replace(" ","+",$input);
        $input = str_replace("++","+",$input);
        return $input;
    }

    function hasScope() {
        return (isset(self::$searchScope) && self::$searchScope != '') ? true : false;
    }


    function getXML($searchTerms = false, $start = 0) {
        if(self::$searchTerm) {
            $searchScope = $this->hasScope() ? '&as_dt=i&as_sitesearch=' . self::$searchScope : '';
            $this->searchQueries = $searchQueries = '?cx=' . $this->cseNumber . '&client=google-csbe&start=' . self::$startNumber . '&num=' . self::$resultSize . '&output=xml_no_dtd&q=' . self::$escapedTerm . $searchScope;
            $xmlfile = $this->googleEndPoint . $searchQueries;
            self::$lastRequest = $xmlfile;
            $this->xmlResult = new SimpleXMLElement($this->searchRequest($xmlfile));
            //echo '<pre>';
            //print_r($this->xmlResult);
            $searchResults = false;
            $this->getTotalResults();
            //get the number of results on this page
            $this->parseResults($this->xmlResult);
            $this->getPageTotal();
            return self::$parsedResults;
        }
    }



    function writeResultCount() {
        $displayTotal = self::$pageTotal + self::$startNumber;
        $output = array();
        $output[] = '<div id="search-result-set-count">';
        $output[] = 'Viewing results ' . (self::$startNumber + 1) . ' - ' . $displayTotal . ' out of around ' . $this->getTotalResults() . ' results.';
        $output[] = '</div>';
        echo implode("\n", $output);
    }

    function writeNoResults() {
        if(self::$searchTerm) {
            $output = array();
            $output[] = '<div id="search-no-results" class="alert alert-info">';
            $output[] = "I'm sorry, we couldn't find any results for <span class=\"search-emphasis\">" . self::$searchTerm . "</span>. ";
            if($this->hasScope()) {
                $output[] = 'Would you like to try and <a href="?' . $this->getHref(false) . '">broaden your search</a>?';
            }
            $output[] = '</div>';
            echo implode("\n", $output);
        }
    }


    function filterTitles($title) {
        return str_replace($this->titleSearch, $this->titleReplace, $title);
    }


    function parseResults($xml) {
        $searchResults = false;
        if($xml->RES) {
            $searchResults = array();
            foreach ($xml->RES->R as $key) {
                $domainInfo = parse_url($key->U);
                $pathInfo = explode('/', $domainInfo['path']);
                $pathClass = (isset($pathInfo[1])) ? $pathInfo[1] : '';
                $domainClass = implode('-', explode('.', $domainInfo['host'])) . '-' . $pathClass;
                $searchResults[] = array(
                    'url' => $key->U,
                    'title' => $this->filterTitles($key->T), //str_replace('Mobile Application Development |', '', $key->T),
                    //'s' => $key->S,
                    'description' => $key->S,
                    'class' => $domainClass . ' ' . $pathClass,
                    'scope' => self::$searchScope
                );
            }
            self::$parsedResults = array_merge(self::$parsedResults, $searchResults);
        }
    }


    //get estimated total number of results.  this is awfully inaccurate until you're on the final page
    //so it's only useful for working out whether there is a next page or not, rather than "results 1-10 of 417
    function getTotalResults($xml = false) {
        self::$nosResults = (int) $this->xmlResult->RES->M;
        return self::$nosResults;
    }


    //total number of results for this page
    function getPageTotal() {
        return self::$pageTotal = count(self::$parsedResults);
    }


    function writePreviousNextButtons() {
        if(self::$nosResults >= self::$resultSize) {   
            //if we're not at the start
            $paginationResults = array();
            $paginationResults[] = '<div id="search-pagination-container">';
            $paginationResults[] = '<div id="" class="row-fluid">';
            if(self::$startNumber != 0) {
                $paginationResults[] = '<div id="search-previous-results" class="search-pagination-controls span5 ar">';
                $paginationResults[] = '<a class="btn search-previous-results" href="?' . $this->getHref(true, -self::$resultSize) . '">&lt; Previous Page</a>';
                $paginationResults[] = '</div>';
            } else {
                //Render an Empty Div so we dont screw up the alignment
                $paginationResults[] = '<div id="search-previous-results" class="span5 ar">';
                $paginationResults[] = '<span class="btn search-previous-results disabled" >&lt; Previous Page</span>';
                $paginationResults[] = '</div>';
            }
            $paginationResults[] = '<div class="span1"></div>';
            if((self::$startNumber + 20) != $this->getTotalResults()) {
                $paginationResults[] = '<div id="search-next-results" class="search-pagination-controls span5 al">';
                $paginationResults[] = '<a class="btn search-next-results" href="?' . $this->getHref(true, self::$resultSize) . '">Next Page &gt;</a>';
                $paginationResults[] = '</div>';
            }
            $paginationResults[] = '</div>';
            $paginationResults[] = '</div>';
            echo implode("\n", $paginationResults);
        }
    }

    function hasPreviousButton() {
        //var_dump(self::$startNumber);
        if(self::$startNumber && self::$startNumber != 0) {
            return true;
        } else {
            return false;
        }
    }


    function hasNextButton() {
        if((self::$startNumber + 20) != $this->getTotalResults()) {
            return true;
        } else {
            return false;
        }
    }


    function writePreviousButton() {
        if($this->hasPreviousButton()) {
            return '<li><a href="?' . $this->getHref(true, -self::$resultSize) . '"><i class="icon-chevron-left"></i> Prev</a></li>';
        } else {
            return '<li  class="disabled"><a href="#"><i class="icon-chevron-left"></i> Prev</a></li>';
        }
    }


    function writeNextButton() {
        if($this->hasNextButton()) {
            return '<li><a href="?' . $this->getHref(true, self::$resultSize) . '">Next <i class="icon-chevron-right"></i></a></li>';
        } else {
            return '<li><a href="#" class="disabled">Next <i class="icon-chevron-right"></i></a></li>';
        }
    }


    function writeSearchResults($xml = false) {
        if(self::$parsedResults && self::$pageTotal > 0 ) {
            foreach (self::$parsedResults as $searchResult) {
                $output[] = '<div id="result-container" class="' . $searchResult['class'] . ' result-container ">';
                $output[] = '    <div id="result-page-title"><h4><a href="' . $searchResult['url'] . '">' . $searchResult['title'] . '</a></h4></div>';
                $output[] = '    <div id="result-page-url" class="result-page-url">'. $searchResult['url'] . '</div>';
                //$output[] = '    <div id="result-page-s" class="result-page-url">'. $searchResult['s'] . '</div>';
                $output[] = '    <div id="result-page-descripton">' . $searchResult['description'] . '</div>';
                $output[] = '</div>';
            }
            echo implode("\n", $output);
        }
    }


    function modifyQuery($modifications = false, $removePrivates = true) {
        $queryString = false;
        //var_dump($this->searchQueries);
        //var_dump($modifications);
        if($modifications) {
            $queryString = trim($this->searchQueries, '?');
            parse_str($queryString, $queryString);
            if($removePrivates) {
                unset($queryString['cx']);
                unset($queryString['client']);
                unset($queryString['output']);
            }
            $queryString = array_merge($queryString, $modifications);
            $queryString = http_build_query($queryString);
            //echo $queryString . '<br />';
        }
        return $queryString;
    }

    function getHref($includeScope = false, $offSet = 0, $newStart = '') {
        $params = array(
            'scope' => self::$searchScope,
            'q' => self::$searchTerm,
            'start' => (self::$startNumber + $offSet)
            );
        if($newStart != '') {
            $params['start'] = $newStart;
        }

        if(!$includeScope) {
            unset($params['scope']);
        }
        return http_build_query($params);
    }

    function getPageNumber() {
        return 0 + (self::$startNumber / self::$resultSize);
    }

//    <li><a href="#">Prev</a></li>
//    <li class="active">
//    <li><a href="#">Next</a></li>

    function writePagination() {
        $i=0;
        $totalPages = $this->getPages();
        if($totalPages > 14) {
            $totalPages = 13;
        } else {
            if($totalPages > 4 && $totalPages < 14) {
                $totalPages = $totalPages *.8;
            }
        }
        $pagination = array();
        if($totalPages > 4) {
            //class="active"
            $pagination[] = '<div id="search-pagination">';
            $pagination[] = '<div class="pagination">';
            $pagination[] = '    <ul>';
            $pagination[] = '        ' . $this->writePreviousButton();
            while($i < $totalPages) {
                $pagination[] = '        <li';
                if($this->getPageNumber() == $i) {
                    $pagination[] = ' class="active" ';
                }
                $pagination[] = '><a href="?' . $this->getHref(true, 0, ($i * self::$resultSize)) . '">' . ($i + 1) . '</a></li>';
                $i++;
            }
            $pagination[] = '        ' . $this->writeNextButton();
            $pagination[] = '    </ul>';
            $pagination[] = '</div>';
            $pagination[] = '</div>';
        } else {
            $pagination[] = '<div id="search-pagination-just-buttons">';
            $pagination[] = '<ul class="pager">';
            $pagination[] = '    <li class="previous">';
            $pagination[] = '         <a href="?' . $this->getHref(true, -self::$resultSize) . '"><i class="icon-chevron-left"></i> Prev</a>';
            $pagination[] = '    </li>';
            $pagination[] = '    <li class="next">';
            $pagination[] = '        <a href="?' . $this->getHref(true, self::$resultSize) . '">Next <i class="icon-chevron-right"></i></a>';
            $pagination[] = '    </li>';
            $pagination[] = '</ul>';
            $pagination[] = '</div>';
        }
        echo implode("\n", $pagination);
    }


    function writeSuggestion($xml = false) {
        if(!$xml) {
            $xml = $this->xmlResult;
        }
        $searchterm = $xml->q;
        //echo '<pre>';
        //print_r($this->xmlResult);
        //die();
        self::$suggestion =  strip_tags(html_entity_decode($xml->Spelling->Suggestion));
        //echo '<hr>';
        //var_dump($xml->Spelling->Suggestion);
        //echo '<hr>';
        //echo '</pre>';
        if((self::$suggestion) && (self::$suggestion != null && self::$suggestion != "")) {
            //var_dump(self::$suggestion);
            $output = array();
            $output[] = '<div id="search-suggested-spelling"  class="alert alert-info">';
            $output[] = 'You searched for <span class="search-emphasis">' . self::$searchTerm . '</span>, did you mean <Suggestion q="' . self::$suggestion . '"><span class="search-emphasis"><a href="?q=' . urlencode(self::$suggestion) . '">' . self::$suggestion . '</a></span></Suggestion>?';
            $output[] = '</div>';
            echo implode("\n", $output);
        }
    }


    function writeItAll() {
    }


    function searchRequest($url) {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        $data = curl_exec($ch);
        curl_close($ch);
        //print_r($data);
        return $data;
    }

} //end class.

