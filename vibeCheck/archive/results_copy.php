<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>User's Top Artists</title>
    <style type="text/css">
      .loadingMessages{
        width: 20%; 
        top: 50%; 
        position: absolute; 
        left: 40%; 
        overflow: hidden; 
        animation: loadText 2s linear forwards; 
      }
      .loadingMessages h2{
        display: none;
        color: #F54375;
      }
      @keyframes loadText { 
        0% { 
          width: 0px; 
          height: 0px; 
        } 
        30% { 
          width: 50px; 
          height: 0px; 
        } 
        60% { 
          width: 100px; 
          height: 80px; 
        }
      }
    </style>

</head>
<body>

 <?php
    echo "<center>";
    echo "<h1>Loading your spotify data</h1>";
    echo "<div class='loadingMessages'>";
    echo "<h2 id='topArtistsMessage'>Getting your top artists</h2>";
    echo "<h2 id='relatedArtistsMessage'>Finding artists you may like</h2>";
    echo "</div>";
    echo "</center>";
    echo "<br><br>";
    echo "<form method='POST' name='artistDataForm' action='main.php'>";
    echo "<input type='hidden' name='artistNames'></input>";
    echo "<input type='hidden' name='artistIDs'></input>";
    echo "<input type='hidden' name='artistPics'></input>";
    echo "<input type='hidden' name='artistTerms'></input>";
    echo "</form>"
 ?>
    <!-- <div class="musicNotesAnimation">
  <div class="note-1">
  &#9835; &#9833;
</div>
<div class="note-2">
  &#9833;
</div>
<div class="note-3">
  &#9839; &#9834;
</div>
<div class="note-4">
  &#9834;
</div>
</div> -->

    <script>
      
        // Function to get authorization code from url
        function getCodeFromUrl() {
            var urlParams = new URLSearchParams(window.location.search);
            var hash =window.location.hash;
            console.log(hash);
            start=hash.indexOf('=')+1;
            hash=hash.substring(start, hash.indexOf('&'));
            console.log(hash);
            return hash;
        }
  
        authCode=getCodeFromUrl();
        authCode= 'Bearer '+authCode; //formatting so it can be used for later calls
        sessionStorage.setItem('authCode', authCode);//setting this so it can be used elsewhere in the site
        var myArtists=[];
        var myArtistsIDs=[];
        var myArtistsPics=[];

        var myArtistsData=[];
        var relatedArtistsData=[];

        //gets all of the user's top artists (short-term, medium term, and long-term) and adds them to myArtists and myArtistsIDs
        async function getTopArtists(){
          terms=['long_term','medium_term','short_term'];
          //gets all of the top artists for all of the terms offered
          for(let i = 0; i < terms.length; i++){
            artist_url='https://api.spotify.com/v1/me/top/artists?time_range='+terms[i]+'&limit=50';
            const response= await fetch(artist_url,{
            method: 'GET',
            headers: {
              'Authorization' : authCode
              }});  
              const data = await response.json();
              myData=data.items;
              //looping through each artist
              for(let q=0; q<myData.length; q++){
                curName=myData[q].name;
                curID= myData[q].id;
                //if the artist isn't already in the list add them to list
                if(!myArtistsIDs.includes(curID)){

                  newAdd=[{name : curName},{ID : curID},{genres : myData[q].genres},{images : myData[q].images}];
                  myArtistsData.push(newAdd);
                  if (myData[q].images.length<1) {
                    myArtistsPics.push('images/blankArtists.png')
                  }else{myArtistsPics.push(myData[q].images[0].url);}

                  getRelatedArtists(curID, 3);//gets artists related to current artist
                  myArtists.push(curName);
                  myArtistsIDs.push(curID);
                }
              }
          }
          return myArtists;
        }


        //gets all the artists from the users top tracks and adds them to the myArtists array
        async function getTopTrackArtists(){
          terms=['long_term','medium_term','short_term'];

          //gets all of the artists for the top tracks for all of the terms offered
          for(let i = 0; i < terms.length; i++){
            url='https://api.spotify.com/v1/me/top/tracks?time_range='+terms[i]+'&limit=50';
            const response= await fetch(url,{
            method: 'GET',
            headers: {
              'Authorization' : authCode
              }}); 
              const data = await response.json();
              myData=data.items;
              //looping through all the songs
              for(let h=0; h< myData.length; h++){
                song_artists=myData[h].artists;
                //looping through each songs artists
                for(let q=0; q < song_artists.length; q++){
                  curID=song_artists[q].id;
                  curName=song_artists[q].name;
                  if(!myArtistsIDs.includes(curID)){
                    newAdd=[{name : curName},{ID : curID},{genres : myData[q].genres},{images : myData[q].images}];
                    console.log(curName);
                    curPics=myData[q].images
                    if (curPics== undefined) {
                    myArtistsPics.push('images/blankArtists.png')
                  }else{myArtistsPics.push(myData[q].images[0].url);}

                    myArtistsData.push(newAdd);

                    getRelatedArtists(curID, 2);//gets artists related to current artist
                    myArtists.push(curName);
                    myArtistsIDs.push(curID);      

                  }
                }
              }
          }
          //document.getElementById('allArtists').innerHTML=myArtists;
          return myArtists;
        }

        var relatedArtists=[];
        var relatedArtistsIDs=[];
        var loopLater=false;

        //get artists related to myArtists
        //numRelated= how many related artists per artists in myArtists should be added to relatedArtists
        async function getRelatedArtists(id, numRelated){
          if(!loopLater){
             url='https://api.spotify.com/v1/artists/'+id+'/related-artists';
             const response= await fetch(url,{
               method: 'GET',
               headers: {
              'Authorization' : authCode
              }}); 
              const data = await response.json();
              if (!response.ok) {
                loopLater= true;
                console.log("ERROR LOOPING LATER")
                throw new Error(`HTTP error! status: ${response.status}`);
              }
              
              cur_related_artists=data.artists;//list of related artists
              //loop through list of related artists
              curNumRelated=0;
                for(let h=0; h<cur_related_artists.length;h++){

                  //if we haven't hit the max_number of related artists
                 if(curNumRelated<=numRelated){
                 curID=cur_related_artists[h].id;
                 //if the artist isn't already in the related list 
                 if(!(myArtistsIDs.includes(curID))&&!(relatedArtistsIDs.includes(curID))){
                   curNumRelated++;
                   relatedArtists.push(cur_related_artists[h].name);
                   relatedArtistsIDs.push(curID);
                  }
                 }

                }}
                return relatedArtists;
          }


          function getArtistArray(){
            arr=[myArtists,myArtistsIDs,relatedArtists,relatedArtistsIDs];
            return arr;
          }
          async function loopingLater(){
            if(loopLater){
              for(i=0;i<myArtists;i++){
                id= myArtistsIDs[i];
                url='https://api.spotify.com/v1/artists/'+id+'/related-artists';
                 const response= await fetch(url,{
               method: 'GET',
               headers: {
              'Authorization' : authCode
              }}); 
              const data = await response.json();
              cur_related_artists=data.artists;
              for(q=0;q<3;q++){
                relatedArtists.push(cur_related_artists[q].name);
                relatedArtistsIDs.push(cur_related_artists[q].id);
              }


              }
            }
          }

        //gets topTracksArtists and TopArtists and displays them on the page
        //uses await to make sure that 
        async function getMyArtists() {
          document.getElementById("topArtistsMessage").style.display="block";
          await getTopArtists();//wait to get top artists
          document.getElementById("topArtistsMessage").style.display="none";
           document.getElementById("relatedArtistsMessage").style.display="block";
          await getTopTrackArtists();
          document.getElementById("relatedArtistsMessage").style.display="none";
          loopingLater();
          let myPromise = new Promise(function(resolve) {
            t=getArtistArray();//returns array with myArtists,myArtistsIDs,relatedArtists,relatedArtistsIDs
            resolve(t);
            
            console.log("got my Artists");
            console.log(t)
           
            });
            // myPromise.then((value) => {
            //   //displays stuff on page
            //   //document.getElementById("allArtists").innerHTML=value[0];
            //   // myForm.elements["formArtists"].value=value[0];
            //   // myForm.elements["formArtistsID"].value=value[1];

            //   //document.getElementById("similar").innerHTML=value[2];
            //   // myForm.elements["formRelatedArtists"].value=value[2];
            //   // myForm.elements["formRelatedArtistsID"].value=value[3];
            //   });
          }

          async function sendMyData(){
            if(sessionStorage.getItem('userArtists')==null){
              await getMyArtists();
              //send my shit
              dataArr=getArtistArray();
              //OLIVER ADD UR SHIT TO PUT dataArr IN THE DATABASE<3 
            
              console.log("data array");
              console.log(dataArr);

              //const jsonObject = JSON.stringify(dataArr);
              sessionStorage.setItem('userArtists', dataArr[0]);
              sessionStorage.setItem('userArtistsIDs', dataArr[1])
              sessionStorage.setItem('userArtistsPics', myArtistsPics);
              sessionStorage.setItem('relatedArtists',dataArr[2]);
              sessionStorage.setItem('relatedArtistsIDs',dataArr[3]);
              sessionStorage.setItem('artistData',myArtistsData);

              document.forms["artistDataForm"]["artistNames"].value = dataArr[0];
              document.forms["artistDataForm"]["artistIDs"].value = dataArr[1];
              document.forms["artistDataForm"]["artistPics"].value = myArtistsPics;
              // Terms ?
              // document.forms["artistDataForm"]["artistTerms"].value = dataArr[0];
              

              // Instead of redirecting to main.php, just submit the form,
              // which redirects to main.php
              document.forms["artistDataForm"].submit();
              
              // window.location.href='main.php';
            }else{
              dataArr=sessionStorage.getItem('array');
              dataArrParsed= JSON.parse(dataArr);
              console.log(dataArrParsed);
              window.location.href='main.php';
            }
          }


          sendMyData();

     
    </script>
</body>
</html>