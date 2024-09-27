<!-- Displays events on page and also writes their data to hidden form fields -->
<!-- Only does event search by keyword -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="./images/favicon.ico">

    <title>vibeCheck | Concerts</title>

    <!-- Google Fonts: Lexend and Inter -->
	<link rel="icon" type="image/x-icon" href="./images/favicon.ico">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&family=Lexend:wght@100..900&display=swap" rel="stylesheet">
    <!-- -->
    <style>
        #event-container {
            display: flex;
            flex-direction: row;
            justify-content: center;
            gap: 30px;
            padding-bottom: 100px;
        }
        #events-form {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }
        #events-form-div {
            display: flex;
            flex-direction: row;
            justify-content: center;
            align-items: center;
            flex-wrap: wrap;
            gap: 30px;
            padding-bottom: 2%;
        }
        .event {
            /* min-width: 300px;
            max-width: 400px; */
            width: 400px;
            height: 450px;
            overflow: hidden;
            background-color: #D2F2E8;
            border-radius: 20px;
            border: 2px solid #092119;
            filter: drop-shadow(1px 2px 4px #0921196f);
            overflow: scroll;
        }
        .event-image {
            height: 250px;
            width: 100%;
            background-repeat: no-repeat;
            background-size: cover;
        }
        .event-content {
            padding: 1rem;
            display: flex;
            flex-direction: column;
            gap: .5rem;
            font-family: 'Inter', Verdana, Geneva, Tahoma, sans-serif;
        }
        .date-time-checkbox {
            display: flex;
            flex-direction: row;
            justify-content: space-between;
        }
        .date-time, .location-venue {
            display: flex;
            flex-direction: row;
            gap: .5rem;
            align-items: center;
        }
        .city-state {
            max-width: max-content;
            min-width: min-content;
            flex: none;
        }
        .event-name a {
            font-size: 24px;
            text-decoration: none;
            font-weight: bold;
            color: #092119;
            transition-duration: 300ms;
            font-family: 'Lexend', Verdana, Geneva, Tahoma, sans-serif;
        }
        .event-name a:hover {
            color: #F54375;
        }
        input[type="checkbox"] {
            accent-color: #F54375;
        }
        .concert-form-submit {

        }

        .button {
            border-radius: 30px; 
            padding: 15px; 
            font-family: Verdana, Geneva, Tahoma, sans-serif;
            font-size: 20px;
            text-align: center;
            background-color: #F54375;
            color: #c9e5dd;
            border-width: 5px;
        }

        .button:hover{ 
        background-color: #F2C1D9; 
        color: #092119; 
        }


    </style>
</head>
<body>
    <?php include 'header.php';?>

    <h1 style = "text-align: center; font-style: italic; color: #F2C1D9; font-family: 'Lexend', Verdana, Geneva, Tahoma, sans-serif; font-size: 50px; margin-bottom: 0px; font-weight: bold;">Your Concerts</h1>
    <p style = "margin-top: 10px; color: #F2C1D9;">Select concerts to add to your list</p>
    <div id='event-container'></div>

    <script>

        function handleSubmit() {
            sessionStorage.setItem("show-profile", true);

            document.forms['events-form']['username'].value = sessionStorage.getItem('username');

        }
        
        window.onload = function() {

            if (sessionStorage.getItem('show-profile') == null) {
                console.log("IT IS NULL");
                document.getElementById("profile").style.display = "none";

            }

        };
        

        // For each artist
        // Do an events search with keyword
        let allEventData = [];
        // eventSearch
        // searches for an event given a keyword
        // RETURNS: string of HTML containing event data, plus event data written
        // to a hidden form field
        function saveChecks(){
            
        }
        function eventSearchARTISTDUMP(url, num, keyword) {
            console.log("EVENTSEARCH");
            return fetch(eventSearchURL)
            .then (eventRes => eventRes.text())
            .then (eventData => 
                {
                    eventData = JSON.parse(eventData);
                    events = eventData._embedded.events;

                    htmlString = ``;

                    // This is a little misleading, we actually are going to
                    // only get one event, so the loop will only run once. 
                    // But if we ever wanted to get multiple 
                    // events we could use this loop.
                    events.forEach((event, index) => {
                        console.log("Event:");
                        console.log(event);

                        // added by Kelly
                        allEventData.push(event);
                        // ^ added by Kelly

                        eventName = event.name; 
                        artistName = event._embedded.attractions[0].name;
                        
                        // Get name of attraction and check if it matches the keyword given
                        attractions = event._embedded.attractions;
                        // console.log(attractions);
                        attractionsArray = [];
                        attractions.forEach((attraction) => {
                            name = attraction.name;
                            attractionsArray.push(name);
                        })
                        if (attractionsArray.includes(keyword)) {
                            console.log("match for " + keyword);
                            // If we have a match, continue to build htmlString
                            venue = event._embedded.venues[0].name; 
                            date = event.dates.start.localDate; 
                            localTime = event.dates.start.localTime; 
                            if (localTime == undefined) {
                                localTime = `TBA`;
                            };
                            city = event._embedded.venues[0].city.name;  
                            country = event._embedded.venues[0].country.countryCode;  
                            url = event.url; 
                            imageURL = event.images[0].url;

                            inputName = "event" + num;

                            // HTML for each event
                            htmlString += `<div class="event"><div class="event-image" style="background-image: url(${imageURL});"></div><div class="event-content"><div class="date-time-checkbox"><div class="date-time"><span>${date}</span><span>•</span><span>${localTime}</span></div><input type='checkbox' name='addToList[]' value=${inputName}></div><span class="event-name"><a href='${url}'>${eventName}</a></span><span>${artistName}</span><div class="location-venue"><span>${city}, ${country}</span><span>•</span><span>${venue}</span></div></div></div>`;
                            // Put data into comma separated values string
                            csvString = `${eventName},${artistName},${venue},${date},${localTime},${city},${country},${url},${imageURL}`;
                            // Put csv into hidden form field
                            htmlString += `<input type='hidden' name='${inputName}' value='${csvString}'>`;     
                        } else {
                            // if attraction name doesn't match keyword, 
                            // don't return anything
                            htmlString = ``;
                        }
                        
                    })
                    // Return HTML, including hidden form field
                    return htmlString;
                })
            .catch (error => console.log(error))
        }

        function eventSearch(url, num, keyword, user_longitude, user_latitude) {
            console.log("EVENTSEARCH");
            return fetch(eventSearchURL)
            .then (eventRes => eventRes.text())
            .then (eventData => 
                {
                    eventData = JSON.parse(eventData);
                    events = eventData._embedded.events;

                    htmlString = ``;

                    // If we fetch more than one event per artist,
                    // this is where we loop through that list of events
                    events.forEach((event, index) => {
                        console.log("Event:");
                        console.log(event);

                        eventName = event.name; 
                        artistName = event._embedded.attractions[0].name;
                        
                        // Get name of attraction and check if it matches the keyword given
                        attractions = event._embedded.attractions;
                        // console.log(attractions);
                        attractionsArray = [];
                        attractions.forEach((attraction) => {
                            name = attraction.name;
                            attractionsArray.push(name);
                        })
                        if (attractionsArray.includes(keyword)) {

                            // const venueLatitude = event._embedded.venues[0].location.latitude;
                            // const venueLongitude = event._embedded.venues[0].location.longitude;
                            // console.log("longitude", venueLongitude);
                            // console.log("latitude", venueLatitude);
                            
                            // Calculate distance between user and venue using Haversine formula
                            // const distance = calculateDistance(user_latitude, user_longitude, venueLatitude, venueLongitude);

                            // Define the radius within which events are considered "close"
                            // const maxDistance = 80;

                            // only get events within 80km (50mi)
                            // if(distance <= maxDistance) {
                                console.log("match for " + keyword);
                                // If we have a match, start updating session storage
                                // sessionStorage.setItem("hasEvents", true);
                                // If we have a match, continue to build htmlString
                                venue = event._embedded.venues[0].name; 
                                date = event.dates.start.localDate; 
                                localTime = event.dates.start.localTime; 
                                if (localTime == undefined) {
                                    localTime = `TBA`;
                                };
                                city = event._embedded.venues[0].city.name; 
                                // !! Unfortunately not all venues have a state, so this will cause some events to not display
                                // state = event._embedded.venues[0].state.name; 
                                country = event._embedded.venues[0].country.countryCode;  
                                url = event.url; 
                                imageURL = event.images[0].url;

                                inputName = "event" + num;

                                // HTML for each event
                                htmlString += `<div class="event"><div class="event-image" style="background-image: url(${imageURL});"></div>`;
                                htmlString+=`<div class="event-content"><div class="date-time-checkbox"><div class="date-time"><span>${date}</span><span>•</span><span>${localTime}</span></div>`;
                                htmlString+=`<input type='checkbox' name='addToList[]' value=${inputName}></div>`;
                                htmlString+=`<span class="event-name"><a target='_blank' href='${url}'>${eventName}</a></span><span>${artistName}</span><div class="location-venue"><span>${city}, ${country}</span><span>•</span><span>${venue}</span></div></div></div>`;
                                // Put data into comma separated values string
                                csvString = `${eventName},${artistName},${venue},${date},${localTime},${city},${country},${url},${imageURL}`;
                                // Put csv into session storage
                                // sessionStorage.setItem(inputName, csvString);
                                // Put csv into hidden form field
                                htmlString += `<input type='hidden' name='${inputName}' value='${csvString}'>`;   
                        
                            // }
                        
                        
                        } else {
                            // if attraction name doesn't match keyword, 
                            // don't return anything
                            htmlString = ``;
                        }
                        
                    })
                    // Return HTML, including hidden form field
                    return htmlString;
                })
            .catch (error => console.log(error))
        }

        // fetchData
        // given an artist array, performs an attraction search then an 
        // event search and writes data to div on page
        async function fetchData(artistsArray, artists, ids, pics, terms, user_longitude, user_latitude) {
            
            // Check if event data exists in sessionStorage
            if (checkEventDataExists()) {
                renderEventsFromStorage();
                return; // If event data exists, no need to fetch again
            }
            
            let latlon = user_latitude + "," + user_longitude;
            // String to build up HTML
            let allEvents = `<form method='POST' action='process_events.php' name='events-form' id='events-form' onSubmit='return handleSubmit()'><input type='submit' value='Submit' class='button concert-form-submit'><br><div id='events-form-div'>`;
            // Ensures that the hidden form fields are named with a pattern, "event" + i
            let i = 0;
            for (const artist of artistsArray) {
                // https://app.ticketmaster.com/discovery/v2/events?apikey=NSQgfG3TncoB4QUzLeWV02Y0RX5Lo9s3&keyword=Tyla&latlong=42.360081,-71.058884&radius=50&locale=*&segmentName=music
                eventSearchURL = `https://app.ticketmaster.com/discovery/v2/events.json?keyword=${artist}&latlong=${latlon}&radius=80&apikey=9sBrAlIWnjX3IuMWmrvvkGK7XxucAGGo&size=5`
                // Do attraction search to get attractionId  
                try {              
                    let eventString = await eventSearch(eventSearchURL, i, artist, user_longitude, user_latitude);
                    // If there was a problem, and eventString comes back
                    // as undefined, then don't include it in allEvents
                    if (eventString == undefined) {
                        console.log("UNDEFINED from fetchData");
                        // Clear eventString
                        eventString = ``;
                    } 

                    allEvents += eventString;               
                } catch (error) {
                    console.log(error);
                }
                // Delay to satisfy rate limit (max 5 requests per second)
                await new Promise(resolve => setTimeout(resolve, 200));
                // Increment i
                i++;
                // allEvents += `<div id='loading'>Loading</div>`
                document.getElementById('event-container').innerHTML = allEvents;
                // document.getElementById('loading').innerHTML = ``;

            }
            allEvents += `</div>`; // End events-form div
            allEvents += `<input type='hidden' name='numEvents' value='${i}'>`;
            
            allEvents += `<input type='hidden' name='username'>`;

            // !! Here
            allEvents += `<input type='submit' value='Submit' class='button concert-form-submit'>`;

            allEvents += `</form>`; // End form
            console.log(allEvents);

            document.getElementById('event-container').innerHTML = allEvents;
    
            // Set HTML
            // document.getElementById('event-container').innerHTML = allEvents;

            // After fetching and rendering events, store the event data in sessionStorage
            sessionStorage.setItem('eventData', JSON.stringify(allEvents));
        }

        function getCloseEvents() {
            // Check if geolocation is supported
            if (navigator.geolocation) {
                // Call getCurrentPosition to retrieve the user's location
                navigator.geolocation.getCurrentPosition(
                    // Success callback function
                    function(position) {
                        const latitude = position.coords.latitude;
                        const longitude = position.coords.longitude;
                        console.log("User's latitude:", latitude);
                        console.log("User's longitude:", longitude);

                        // TODO: kelly, add the rest of the code here

                        // Get Spotify data from session storage
                        userArtists = sessionStorage.getItem('userArtists');
                        userArtistsIDs = sessionStorage.getItem('userArtistsIDs')
                        userArtistsPics = sessionStorage.getItem('userArtistsPics');
                        userArtistsTerms = sessionStorage.getItem('userArtistsTerms');
                        userArtistsArray = userArtists.split(",");

                        fetchData(userArtistsArray, userArtists, userArtistsIDs, userArtistsPics, userArtistsTerms, longitude, latitude);
                        
                    },
                    // Error callback function
                    function(error) {
                        switch(error.code) {
                            case error.PERMISSION_DENIED:
                                console.error("User denied the request for Geolocation.");
                                break;
                            case error.POSITION_UNAVAILABLE:
                                console.error("Location information is unavailable.");
                                break;
                            case error.TIMEOUT:
                                console.error("The request to get user location timed out.");
                                break;
                            case error.UNKNOWN_ERROR:
                                console.error("An unknown error occurred.");
                                break;
                        }
                    }
                );
            } else {
                console.error("Geolocation is not supported by this browser.");
            }
        }

        // Function to check if event data exists in sessionStorage
        function checkEventDataExists() {
            return sessionStorage.getItem('eventData') !== null;
        }

        // Function to render events from sessionStorage
        function renderEventsFromStorage() {
            const eventData = JSON.parse(sessionStorage.getItem('eventData'));
            if (eventData) {
                const eventContainer = document.getElementById('event-container');
                eventContainer.innerHTML = eventData; // Render events directly from stored HTML
            }
        }

        // Commented out b/c I added them to getCloseEvents()
        // // Get Spotify data from session storage
        // userArtists = sessionStorage.getItem('userArtists');
        // userArtistsIDs = sessionStorage.getItem('userArtistsIDs')
        // userArtistsPics = sessionStorage.getItem('userArtistsPics');
        // userArtistsTerms = sessionStorage.getItem('userArtistsTerms');

        // Get data from Ticketmaster
        // commented out because I call it in getUserGeolocation()
        // fetchData(userArtistsArray, userArtists, userArtistsIDs, userArtistsPics, userArtistsTerms);
        getCloseEvents();
        
    </script>

    <?php 
    // include 'header.php';
    ?>

    <!-- <h1 style = "text-align: center; font-style: italic; color: #F2C1D9; font-family: 'Lexend', Verdana, Geneva, Tahoma, sans-serif; font-size: 50px; margin-bottom: 0px; font-weight: bold;">Your Concerts</h1>
    <p style = "margin-top: 10px; color: #F2C1D9;">Select concerts to add to your list</p>
    <div id='event-container'></div> -->

</body>
</html>
