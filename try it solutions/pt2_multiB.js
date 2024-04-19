var http = require('http');
var url = require('url');
var query = require('querystring');

http.createServer(function (req, res) {
  res.writeHead(200, {'Content-Type': 'text/html'});
  urlObj = url.parse(req.url,true)
  path = urlObj.pathname;
  if (path == "/")
  {
    s = "<form action='/process' method='post'>"+
            "<input type='text' name='id'><br />" +
            "<input type='text' name='name'><br />" +
            "<input type='submit'>" +
            "</form>";
	  res.write(s);
  }
  else if (path == "/process")
  {
	res.write ("Processing<br/>");
    var body = '';
    req.on('data', chunk => { body += chunk.toString();  });
    req.on('end', () => 
        { 
        res.write ("Raw data string: " + body +"<br/>");
	      var id = query.parse(body).id;      // assumes x is post data parameter	
        res.write ("The id is " + id );
        res.end();
        });
  }
}).listen(8080);
