/* Q1: Write a basic Hello World HTTP webserver that just echos back Hi there */
/* Q1.2: Now return the user-agent back to the browser */
/* Q1.3: Now echo back to the browser all the http request headers */

var http = require('http');
http.createServer( function (req, res) {
    res.writeHead(200, {'Content-Type': 'text/plain'});
    
    res.write ("hi back\n");

    res.write("user-agent" + req.headers['user-agent'] + "\n");

    for (var key in req.headers) {
	res.write(key + " = " + req.headers[key]);
	res.write("\n");
    }
    res.end();
    console.log(req);
}
).listen(3001);



