var http = require('http');
var url = require('url');

http.createServer(function (req, res) {
  res.writeHead(200, {'Content-Type': 'text/html'});
  urlObj = url.parse(req.url,true)
  path = urlObj.pathname;
  if (path == "/")
  {
    s = "<form action='/process' method='get'>"+
            "<input type='text' name='id'><br />" +
            "<input type='submit'>" +
            "</form>";
	  res.write(s);
  }
  else if (path == "/process")
  {
	  res.write ("Processing<br/>");
      id = urlObj.query.id;
      res.write ("The id is " + id);
  }
  res.end();
}).listen(8080);
