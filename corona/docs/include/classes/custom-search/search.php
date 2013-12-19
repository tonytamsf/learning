<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Search</title>
<style>
    #search-query-container {
        padding: 5px;
        padding-top: 8px;
        margin: 5px;
        height:38px;
        border: 0px solid silver;
        width: 90%;
        margin: 0 auto;
        background-color: #ECECEC;
    }
    #search-term, #search-scope, #search-button {
        padding:0px;margin:0px;outline-width: 0px;
        height: 30px;
        border: 1px solid black;
    }
    #search-term {
        margin-top:1px;
        outline:0px;
        margin-right: 5px;
        margin-bottom: -1px;
        width:99%;
        border:1px solid silver;
        margin-right:5px;
        margin-left:5px;
    }

    #search-scope {
        /*height: 39px;*/
        height:33px;
        margin-right:5px;
        width: 100%;
        border:0px;
    }
    #search-button {
        height:33px;
        /*height: 39px;*/
        width: 100%;
        border:0px solid white;
        -webkit-appearance:button;
        -moz-appearance:button; /* Firefox */
        appearance:button;
        
    }
    #search-scope-container {
        width: 20%;
        display: inline-block;
        float: left;
        padding-top:1px;
    }
    
    #search-term-container {
        width:70%;
        display: inline-block;
        float: left;
    }
    
    #search-button-container {
        width: 10%;
        display: inline-block;
        float: left;
        padding-top:1px;
    }
    .result-page-url {
        color: gray;
        font-style: italic;
    }
</style>
</head>

<body>

<?php include 'search.inc.php'; ?>

</body>
</html>
