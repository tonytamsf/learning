var http_port = 8124;

var http = require ('http');
var htutil = require('./htutil');
//var JSON = require ('JSON');

var server = http.createServer(function(req, res) {
    //console.log(JSON.stringify(req, null, 4));
    //console.log(req.toString());
    
    // req.a, req.b are parsed
    htutil.loadParams(req, res, undefined);
    
    if (req.requrl.pathname == '/') {
	require('./home-node').get(req,res);
    } else if(req.requrl.pathname == 'multi') {
	require('.multi-node').get(req,res);
    } else {
	res.writeHead(404, {'Content-Type': 'text/plain'});
	res.end("bad URL " + req.url);
    }
    }).listen(http_port);
