var http = require('http');
var server = http.createServer(function(req, res) {
	res.writeHead(200, {'Content-Type': 'text/plain'});
	res.end('Hello World\n');
    });
server.listen(1337);
console.log("listening at http://127.0.0.1:1337");
