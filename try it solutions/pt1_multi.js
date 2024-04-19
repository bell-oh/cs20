var http = require('http');

http.createServer(function (req, res) {
  res.writeHead(200, {'Content-Type': 'text/html'});
  if (req.url == "/")
  {
    s = "<form action='/process' method='get'>"+
            "<input type='text' name='id'>" +
            "<input type='submit'>" +
            "</form>";
	  res.write(s);
  }
  else if (req.url == "/process")
	  res.write ("Processing");
  res.end();
}).listen(8080);
