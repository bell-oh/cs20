var http = require('http');
http.createServer(function (req, res) {
    res.writeHead(200, {'Content-Type': 'text/html'});
    if (req.url == "/") {
	    res.write("Home page");
	} else if (req.url == "/about") {
		   res.write("About page");
    }
    res.end();
}).listen(8080);