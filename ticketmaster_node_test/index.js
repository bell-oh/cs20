// Create server-side proxy
const http = require('http');
const https = require('https');
const url = require('url');
const fetch = require('node-fetch');

const server = http.creatServer((req, res) => {
    const requestUrl = url.parse(req.url, true);
    const ticketmasterUrl = 'https://app.ticketmaster.com/discovery/v2/' + requestUrl.path;

    fetch(ticketmasterUrl)
    .then((proxyRes) => {
      res.writeHead(proxyRes.status, proxyRes.headers);
      proxyRes.body.pipe(res);
    })
    .catch((error) => {
      console.error('Proxy request error:', error);
      res.writeHead(500, {'Content-Type': 'application/json'});
      res.end(JSON.stringify({ error: 'Proxy request failed' }));
    });
    
});

server.listen(3000);