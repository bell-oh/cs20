var http = require('http');
var url = require('url');

http.createServer(function (req, res) {
  res.writeHead(200, {'Content-Type': 'text/html'});
  var path = url.parse(req.url,true).pathname;
  if (path == "/")
  {
    s = "<form action='/process' method='get'>"+
            "<input type='text' name='id'>" +
            "<input type='submit'>" +
            "</form>";
	  res.write(s);
  }
  else if (path == "/process")
	  res.write ("Processing");
  res.end();
}).listen(8080);
