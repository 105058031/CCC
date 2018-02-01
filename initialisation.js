var express = require('express'); // Web Framework
var app = express();
var sql = require('mssql'); // MS Sql Server client
var port_l = process.env.PORT || 8001;
// Connection string parameters.
var sqlConfig = {
    server: 'DX48Q02\\SQLEXPRESS',
    database: 'Searing_Dragon_Hell_Fire',
	user: 'FBR',
    password: 'Pa55word',
	port: 57675
};

// Start server and listen on http://localhost:8081/
//var server = app.listen(port_l, function () {
var server = app.listen(port_l, function () {
    var host = server.address().address
	console.log("host" + host)
    var port = server.address().port

    console.log("app listening at http://%s:%s", host, port)
});

app.get('/', (request, response) => {  
  response.send('Hello from Express!')
})

app.get('/tables', function (req, res) {
    sql.connect(sqlConfig, function() {
        var request = new sql.Request();
        request.query('SELECT [Table] FROM [RunningLog];', function(err, recordset) {
            if(err) console.log(err);
            res.end(JSON.stringify(recordset)); // Result in JSON format
			//console.log(res);
			sql.close();
        });
    });
})

app.get('/nrs', function (req, res) {
    sql.connect(sqlConfig, function() {
        var request = new sql.Request();
        request.query('SELECT TOP 10 [Qty in Un# of Entry] FROM [Searing_Dragon_Hell_Fire].[dbo].[MB51];', function(err, recordset) {
            if(err) console.log(err);
            res.end(JSON.stringify(recordset)); // Result in JSON format
			//console.log(res);
			sql.close();
        });
    });
})
