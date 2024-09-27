
<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="icon" type="image/x-icon" href="./images/favicon.ico">
<link rel="stylesheet" href="style.css">
<!-- Google Fonts: Lexend and Inter -->
<link rel="icon" type="image/x-icon" href="./images/favicon.ico">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&family=Lexend:wght@100..900&display=swap" rel="stylesheet">
    <!-- -->
<style>
    * {
        box-sizing: border-box;
        color: #092119;
    }
    .loginBlurb {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 1rem;

    }
    #loginForm {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 1rem;
        background-color: #F2C1D9;
        width: max-content;
        border-radius: 20px;
        padding: 4rem;
        filter: drop-shadow(1px 2px 4px #0921196f);
    }
    #loginForm input {
        border-radius: 10px;
        padding: 10px 5px;
        border: 1px solid #092119;
        color: #092119;
        font-size: 24px;
    }
    #loginForm input:focus {
        border: 2px solid #F54375;
        outline: none;
    }

/*SLIDESHOW*/
* {
  box-sizing: border-box;
}

img {
  vertical-align: middle;
}

/* Position the image container (needed to position the left and right arrows) */
.container {
  position: relative;
}

/* Hide the images by default */
.mySlides {
  display: none;
}

/* Add a pointer when hovering over the thumbnail images */
.cursor {
  cursor: pointer;
}

/* Next & previous buttons */
.prev,
.next {
  cursor: pointer;
  position: absolute;
  top: 40%;
  width: auto;
  padding: 16px;
  margin-top: -50px;
  color: white;
  font-weight: bold;
  font-size: 50px;
  border-radius: 0 3px 3px 0;
  user-select: none;
  -webkit-user-select: none;
}

/* Position the "next button" to the right */
.next {
  right: 0;
  border-radius: 3px 0 0 3px;
}

/* On hover, add a black background color with a little bit see-through */
.prev:hover,
.next:hover {
  background-color: rgba(0, 0, 0, 0.8);
}

/* Number text (1/3 etc) */
.numbertext {
  color: #f2f2f2;
  font-size: 12px;
  padding: 8px 12px;
  position: absolute;
  top: 0;
}

/* Container for image text */
.caption-container {
  text-align: center;
  background-color: #F54375;
  padding: 2px 16px;
  color: white;
}

.row:after {
  content: "";
  display: table;
  clear: both;
}

/* Six columns side by side */
.column {
  float: left;
  width: 16.66%;
}

/* Add a transparency effect for thumnbail images */
.demo {
  opacity: 0.6;
}

.active,
.demo:hover {
  opacity: 1;
}
#topArtists {
        display: flex;
        justify-content: center;
        align-items: center; 
    }

</style>
</head>


<body>
  <?php include "header.php" ?>
  <br><br>
  <div id="loginBlurb">
    <center>
      <h1>Find concerts near you!</h1>
      <button id="loginButton">Login with Spotify</button>
      <br><br><br><br><br>
    </center>
    <form name='spotifyLogin'>
        <input type='hidden' name='login'>
    </form>
  </div>
<div id = 'bigDog'>
  <div class="caption-container">
      <p style = "margin: 45px; background-color: #F54375"></p>
    </div>
  <div class="container"  style = "background-color: #F54375">
    <center>
    <div class="mySlides">
      <div class="numbertext">1 / 6</div>
      <img src="images/cage.png" style="width:70%; height: 520px; object-fit: cover; border-radius: 40px;">
    </div>
  </center>
  <center>
    <div class="mySlides">
      <div class="numbertext">2 / 6</div>
      <img src="images/taylorswift.png" style="width:70%; height: 520px; object-fit: cover; border-radius: 40px;">
    </div>
  </center>
  <center>
    <div class="mySlides">
      <div class="numbertext">3 / 6</div>
      <img src="images/kiss.png" style="width:70%; height: 520px; object-fit: cover; border-radius: 40px;">
    </div>
  </center> 
  <center>
    <div class="mySlides">
      <div class="numbertext">4 / 6</div>
      <img src="images/olivia.png" style="width:70%; height: 520px; object-fit: cover; border-radius: 40px;">
    </div>
  </center>
  <center>
    <div class="mySlides">
      <div class="numbertext">5 / 6</div>
      <img src="images/post.png" style="width:70%; height: 520px; object-fit: cover; border-radius: 40px;">
    </div>
  </center>
  <center>   
    <div class="mySlides">
      <div class="numbertext">6 / 6</div>
      <img src="images/rolling.png" style="width:70%; height: 520px; object-fit: cover; border-radius: 40px;">
    </div>
  </center>

  <a class="prev" onclick="plusSlides(-1)">❮</a>
  <a class="next" onclick="plusSlides(1)">❯</a>
  
<div class="caption-container">
      <p id="caption" style = "color: white; margin: 10px;"></p>
    </div>
  
    <div class="row">
      <div class="column">
        <img class="demo cursor" src="images/cage.png" style="width:100%; height: 140px;" onclick="currentSlide(1)" alt="Cage the Elephant">
      </div>
      <div class="column">
        <img class="demo cursor" src="images/taylorswift.png" style="width:100%; height: 140px;" onclick="currentSlide(2)" alt="Taylor Swift">
      </div>
      <div class="column">
        <img class="demo cursor" src="images/kiss.png" style="width:100%; height: 140px;" onclick="currentSlide(3)" alt="Jo jo Siwa">
      </div>
      <div class="column">
        <img class="demo cursor" src="images/olivia.png" style="width:100%; height: 140px;" onclick="currentSlide(4)" alt="Olivia Rodrigo">
      </div>
      <div class="column">
        <img class="demo cursor" src="images/post.png" style="width:100%; height: 140px;" onclick="currentSlide(5)" alt="Post Malone">
      </div>    
      <div class="column">
        <img class="demo cursor" src="images/rolling.png" style="width:100%; height: 140px;" onclick="currentSlide(6)" alt="Rolling Stones">
      </div>
    </div>
</div>
</div>

<div id = 'break'><br><br><br><br><br></div>

<div id = 'anothahHeadah' style = "text-align: center; font-style: italic; color: #F2C1D9; font-family: 'Lexend', Verdana, Geneva, Tahoma, sans-serif; font-size: 50px; margin-bottom: 20px; font-weight: bold;">Your Top Artists</div>

<div style = "display: flex; flex-direction: column; margin-bottom: 50px; margin-top: 0px; font-family: 'Lexend', Verdana, Geneva, Tahoma, sans-serif; padding: 20px 80px;" id = "text3">
<div style = "color: white; padding: 10px; font-size: 20px; font-style: italic; margin-left: 90px;" id = "text2">Filter your artists by listening time!</div>

<div id="cont" style = "display: flex; justify-content: space-between; margin-left: 90px;">
  <div id="termSelection">
    <input type="radio" id="short" name="termPick" value="short" onclick="showArtists();">
      <label for="short" style = "color: white;">Short Term</label><br>
    <input type="radio" id="medium" name="termPick" value="medium" onclick="showArtists();">
      <label for="medium" style = "color: white;">Medium Term</label><br>
    <input type="radio" id="long" name="termPick" value="long" onclick="showArtists();">
      <label for="long" style = "color: white;">Long Term</label>
  </div>

<a href="concerts.php">
  <button id ="concertsButton" style = "margin-right: 90px">Concerts!</button>
</a>
</div>

<br><br><br>

<div id='topArtists'>
  </div>

<script>

let slideIndex = 1;
showSlides(slideIndex);

function plusSlides(n) {
  showSlides(slideIndex += n);
}

function currentSlide(n) {
  showSlides(slideIndex = n);
}

function showSlides(n) {
  let i;
  let slides = document.getElementsByClassName("mySlides");
  let dots = document.getElementsByClassName("demo");
  let captionText = document.getElementById("caption");
  if (n > slides.length) {slideIndex = 1}
  if (n < 1) {slideIndex = slides.length}
  for (i = 0; i < slides.length; i++) {
    slides[i].style.display = "none";
  }
  for (i = 0; i < dots.length; i++) {
    dots[i].className = dots[i].className.replace(" active", "");
  }
  slides[slideIndex-1].style.display = "block";
  dots[slideIndex-1].className += " active";
  captionText.innerHTML = dots[slideIndex-1].alt;
}
</script>


<script type="text/javascript">

    userArtists=sessionStorage.getItem('userArtists');
    userArtistsTerms = sessionStorage.getItem('userArtistsTerms');
    userArtistsPics=sessionStorage.getItem('userArtistsPics');

    console.log(userArtists);
    console.log(userArtistsTerms);
    user_S_Artists=[];
    user_M_Artists=[];
    user_L_Artists=[];

    //if its not logged into spotify don't show concerts or term selection

  if (userArtists==null) {
    document.getElementById("concerts").style.display="none";
    document.getElementById("termSelection").style.display="none";
    document.getElementById("loginBlurb").style.display="inline";
    document.getElementById("topArtists").style.display="none";
    document.getElementById("text2").style.display="none"; 
    document.getElementById("text3").style.display="none"; 
    document.getElementById("profile").style.display="none"; 
    document.getElementById("concertsButton").style.display="none"; 
    document.getElementById("anothahHeadah").style.display="none"; 
    // document.getElementById("music").style.display="inline"; 
  }

  //if it is logged into spotify
  else{

    document.getElementById("loginBlurb").style.display="none";
    document.getElementById("termSelection").style.display="inline";
    document.getElementById("topArtists").style.display="flex";
    
    document.getElementById("profile").style.display="inline"; 
    document.getElementById("bigDog").style.display = "none"; 
    document.getElementById("break").style.display= "none"; 
    //automatically checks short term
    document.getElementById("short").checked=true;
    doArtists();
    showArtists();
    d=sessionStorage.getItem('userPic');
    console.log(d);

  }

  async function doArtists(){
     //userArtists=sessionStorage.getItem('userArtists');
     userArtists=userArtists.split(",");
     //.userArtistsTerms = sessionStorage.getItem('userArtistsTerms');
     userArtistsTerms=userArtistsTerms.split(",");
     //userArtistsPics=sessionStorage.getItem('userArtistsPics');
     userArtistsPics=userArtistsPics.split(",");
     for(i=0;i<userArtists.length;i++){
        if(userArtistsTerms[i]=='l'){
            curArtistData=[userArtists[i],userArtistsPics[i]];
            user_L_Artists.push(curArtistData);
        }
        if(userArtistsTerms[i]=='m'){
            curArtistData=[userArtists[i],userArtistsPics[i]];
            user_M_Artists.push(curArtistData);
        }
        if(userArtistsTerms[i]=='s'){
            curArtistData=[userArtists[i],userArtistsPics[i]];
            user_S_Artists.push(curArtistData);
        }
    }
  }
  async function showArtists(){
    arr=[];
    if(document.getElementById("long").checked){arr=user_L_Artists;}
    if(document.getElementById("medium").checked){arr=user_M_Artists;}
    if(document.getElementById("short").checked){arr=user_S_Artists;}
    
    stringCode="";
    for (var i =0;i<arr.length;i++) {
      stringCode+="<div class='artistBlurb'>";
      stringCode+="<img src='"+arr[i][1]+"'>"
      stringCode+="<h2>"+ arr[i][0]+"</h2>"

      stringCode+="</div>";
    }
     document.getElementById('topArtists').innerHTML=stringCode;

  }
</script>

  <script>
    //login and spotify authentication script
    var client_id = '87587e4116394731a7ffbfb872d45712';//'daeea42af07e4702905904f246591317';
    var redirect_uri = 'https://oliverb.sgedu.site/vibeCheck/results.php';
    var scopes = 'user-top-read user-read-recently-played user-read-private user-read-email';
            document.getElementById('loginButton').addEventListener('click', function() {
            var authUrl = 'https://accounts.spotify.com/authorize?response_type=token&client_id='
             + client_id + '&scope=' + encodeURIComponent(scopes)+'&redirect_uri=' + encodeURIComponent(redirect_uri);
            //sessionStorage.setItem('loggedInSpotify',1);
            // document.forms['spotifyLogin']['login'].value = 1;
            
            window.location.href = authUrl;
        });

        // Function to extract code from URL after redirection
        function getCodeFromUrl() {
            var urlParams = new URLSearchParams(window.location.search);
            return urlParams.get('code');
        }
        function getAccessTokenFromURL(){
          var urlParams = new URLSearchParams(window.location.search);
         
          return  urlParams.get('access_token');
        }

        // Once the page loads, extract the code from URL and redirect to results.html
        window.onload = function() {

          // don't show the profile page as an option until they have selected some artists
          if (sessionStorage.getItem('show-profile') == null) {
              console.log("IT IS NULL");
              document.getElementById("profile").style.display = "none";

          }
          else {
            console.log("NOT NULL BABYYYYY");
          }


            var code = getCodeFromUrl();
            var code2 = getAccessTokenFromURL()
            if (code) {
                // Redirect to results.html with the code as a query parameter
                window.location.href = 'results.html?access_token='+encodeURIComponent(code2);
            }
        };


  </script>
  <?php
    // $query_string = $_SERVER['QUERY_STRING'];
    // echo $_GET["username"];
    
    // parse_url($query_string, $qs_array);
    // print_r($qs_array);
    // Insert artist data (name, ID, term, pic) into database

    // Get artist data
    $artistNames = $_POST["artistNames"];
    $artistNamesArray = explode(",", $artistNames);

    $artistIDs = $_POST["artistIDs"];
    $artistIDsArray = explode(",", $artistIDs);

    $artistPics = $_POST["artistPics"];
    $artistPicsArray = explode(",", $artistPics);

    $artistTerms = $_POST["artistTerms"];
    $artistTermsArray = explode(",", $artistTerms);
    // echo $artistTerms;
    // echo print_r($artistTermsArray);

    $numArtists = count($artistNamesArray);

    // Get username
    $username = $_POST["username"];    
    
    // Variables to set up connection
    $server = "localhost";
    $userid = "ugf8r1wb53c4a";
    $pw = "pdk3ekowisn1";
    $db = "db07ibmkhthwwd";

    // Create connection
    $conn = new mysqli($server, $userid, $pw);
    
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Select database
    $conn->select_db($db);

    // Clear table
    // $sqlDelete = "DELETE FROM `artists` WHERE `User ID` = " . $username . "'";
    // s$conn->query($sqlDelete);

    // Clear artists associated with current user
    $sqlDelete = "DELETE FROM `artists` WHERE `User ID` = ?";
    $statement = $conn->prepare($sqlDelete);
    $statement->bind_param("s", $username);
    $statement->execute();

    // $sqlUpdate = "UPDATE `users` SET `Logged In` = '1' WHERE `users`.`ID` = 14;"

    for ($i = 0; $i < $numArtists; $i++) {
        $name = $artistNamesArray[$i];
        $id = $artistIDsArray[$i];
        $term = $artistTermsArray[$i];
        $pic = $artistPicsArray[$i];
        
        // If not empty, insert into db
        if (($name != "") and ($id != "") and ($term != "") and ($pic != "")) {
            // Create and prepare query
            $sqlInsert = "INSERT INTO `artists`(`Name`, `Spotify ID`, `term`, `pic`, `User ID`) VALUES (?,?,?,?,?)";
            $statement = $conn->prepare($sqlInsert);
            // Bind parameters and execute query
            $statement->bind_param("sssss", $name, $id, $term, $pic, $username);
            $statement->execute();
        }

       
    }
?>


<br><br><br><br><br>


</body>
</html>