/*
    Q1:     Fetch A remote file and pipe it to a local file
    Q2:     Read a file, pipe to gzip and write
*/

var http = require('http');
var fs = require('fs');

http.get({
    hostname : 'www.yahoo.com',
    path : '/favicon.ico',
    }, function(res) {
	res.pipe(fs.createWriteStream('./favicon.ico'));
	console.log('wrote to file ./favicon.ico');
    });


