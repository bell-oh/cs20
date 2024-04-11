const MongoClient = require('mongodb').MongoClient;
const connStr= "mongodb+srv://obello26:<password>@cluster0.4iof1ui.mongodb.net/?retryWrites=true&w=majority&appName=Cluster0"
	  
console.log('hey')

MongoClient.connect(connStr, function(err, db) {   
    if(err) { console.log(err); }
    else {
        var db_object = db.db("library");
        var collection = db_object.collection('books');
        console.log("Success!");
        db.close();
    }
});