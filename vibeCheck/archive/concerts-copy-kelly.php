<!-- Displays events on page and also writes their data to hidden form fields -->
<!-- Only does event search by keyword -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="./images/favicon.ico">

    <title>Concerts</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <style>
        #event-container {
            display: flex;
            flex-direction: row;
            justify-content: center;
            gap: 30px;
        }
        #events-form {
            display: flex;
            flex-direction: row;
            justify-content: center;
            align-items: center;
            flex-wrap: wrap;
            gap: 30px;
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
        }
        .event-name a:hover {
            color: #F54375;
        }
        input[type="checkbox"] {
            accent-color: #F54375;
        }


    </style>
</head>
<body>
    <script>
        // added by kelly
        // Declare an array to hold all event data
        let allEventData = [];
        let allEventDataJSON;
        // ^ added by kelly


        // For each artist
        // Do an events search with keyword
           
        // eventSearch
        // searches for an event given a keyword
        // RETURNS: string of HTML containing event data, plus event data written
        // to a hidden form field
        function eventSearch(url, num, keyword) {
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

                            // added by Kelly
                            allEventData.push(event);
                            // ^ added by Kelly


                            console.log("match for " + keyword);
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

        // fetchData
        // given an artist array, performs an attraction search then an 
        // event search and writes data to div on page
        async function fetchData(artistsArray, artists, ids, pics, terms) {

            // String to build up HTML
            let allEvents = `<form method='POST' action='process_events.php'><div id='events-form'>`;
            // Ensures that the hidden form fields are named with a pattern, "event" + i
            let i = 0;
            for (const artist of artistsArray) {
                eventSearchURL = `https://app.ticketmaster.com/discovery/v2/events.json?keyword=${artist}&apikey=1IiUV6YIvdbcA2xr6D9bBGrKOIao6VGb&size=1`
                // Do attraction search to get attractionId  
                try {              
                    let eventString = await eventSearch(eventSearchURL, i, artist);
                    // If there was a problem, and eventString comes back
                    // as undefined, then don't include it in allEvents
                    if (eventString == undefined) {
                        console.log("UNDEFINED from fetchData");
                        // Clear eventString
                        eventString = ``;
                    } 
                    allEvents += eventString;    
                    console.log("EVENT STRING");
                    console.log(eventString);          
                } catch (error) {
                    console.log(error);
                }
                // Delay to satisfy rate limit (max 5 requests per second)
                await new Promise(resolve => setTimeout(resolve, 500));
                // Increment i
                i++;
                // allEvents += `<div id='loading'>Loading</div>`
                document.getElementById('event-container').innerHTML = allEvents;
                // document.getElementById('loading').innerHTML = ``;

            }
            allEvents += `</div>`; // End events-form div
            allEvents += `<input type='hidden' name='numEvents' value='${i}'>`;
            
            // Currently trying to have these four lines in results.php instead
            allEvents += `<input type='hidden' name='artists' value='${artists}'>`;
            allEvents += `<input type='hidden' name='ids' value='${ids}'>`;
            allEvents += `<input type='hidden' name='pics' value='${pics}'>`;
            allEvents += `<input type='hidden' name='terms' value='${terms}'>`;
            
            allEvents += `<input type='submit' value='Submit'>`;
            allEvents += `</form>`; // End form
            console.log(allEvents);

            document.getElementById('event-container').innerHTML = allEvents;


    
            // Set HTML
            // document.getElementById('event-container').innerHTML = allEvents;

            // ADDED by Kelly
            // Serialize the array into a JSON string
            allEventDataJSON = JSON.stringify(allEventData);

            // Store the JSON string in session storage
            console.log("CREATING THHHHHHEEEEE JSONNNNNN");
            sessionStorage.setItem('allEventData', allEventDataJSON);
            // ^ ADDED by Kelly

        }

        // Get Spotify data from session storage
        userArtists = sessionStorage.getItem('userArtists');
        userArtistsIDs = sessionStorage.getItem('userArtistsIDs')
        userArtistsPics = sessionStorage.getItem('userArtistsPics');
        userArtistsTerms = sessionStorage.getItem('userArtistsTerms');
    
        userArtistsArray = userArtists.split(",");

        // Get data from Ticketmaster
        console.log("NEW FETCH!!!!!!!!!");
        fetchData(userArtistsArray, userArtists, userArtistsIDs, userArtistsPics, userArtistsTerms);


        // ADDED BY KELLY
        // Function to get events close to user
        function getEventsCloseToUser() {
            // Check if geolocation is supported
            if (navigator.geolocation) {
                // Call getCurrentPosition to retrieve the user's location
                navigator.geolocation.getCurrentPosition((position) => {
                    const userLatitude = position.coords.latitude;
                    const userLongitude = position.coords.longitude;

                    console.log("User Latitude:", userLatitude);
                    console.log("User Longitude:", userLongitude);

                    // Parse the JSON string from session storage
                    const allEventDataJSON = sessionStorage.getItem('allEventData');
                    const allEventData = JSON.parse(allEventDataJSON);

                    // Filter events based on proximity to user's location
                    const filteredEvents = allEventData.filter(event => {
                        console.log("WHAT'S YOUR NAME");
                        console.log(event.name);
                        const venueLatitude = event._embedded.venues[0].location.latitude;
                        const venueLongitude = event._embedded.venues[0].location.longitude;

                        // Calculate distance between user and venue using Haversine formula
                        const distance = calculateDistance(userLatitude, userLongitude, venueLatitude, venueLongitude);

                        // Define the radius within which events are considered "close"
                        const maxDistance = 15;

                        return distance <= maxDistance;
                    });

                    console.log("Filtered Events:", filteredEvents);

                    // Display filtered events
                    displayFilteredEvents(filteredEvents);
                }, showError);
            } else {
                alert("Geolocation is not supported by this browser.");
            }
        }

        // Function to calculate distance between two points using Haversine formula
        function calculateDistance(lat1, lon1, lat2, lon2) {
            const R = 6371; // Radius of the Earth in kilometers
            const dLat = deg2rad(lat2 - lat1);
            const dLon = deg2rad(lon2 - lon1);
            const a =
                Math.sin(dLat / 2) * Math.sin(dLat / 2) +
                Math.cos(deg2rad(lat1)) * Math.cos(deg2rad(lat2)) *
                Math.sin(dLon / 2) * Math.sin(dLon / 2);
            const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
            const d = R * c; // Distance in kilometers
            return d;
        }

        function deg2rad(deg) {
            return deg * (Math.PI / 180);
        }

        // Function to handle errors in retrieving user's location
        function showError(error) {
            switch (error.code) {
                case error.PERMISSION_DENIED:
                    alert("User denied the request for Geolocation.");
                    break;
                case error.POSITION_UNAVAILABLE:
                    alert("Location information is unavailable.");
                    break;
                case error.TIMEOUT:
                    alert("The request to get user location timed out.");
                    break;
                case error.UNKNOWN_ERROR:
                    alert("An unknown error occurred.");
                    break;
            }
        }

        // Function to display filtered events
        function displayFilteredEvents(filteredEvents) {
            console.log("NEW EVENTS NEW EVENTS NEW EVENTS NEW EVENTS NEW EVENTS")
            console.log(filteredEvents);
            // Clear existing event container
            document.getElementById('event-container').innerHTML = '';

            // Iterate through filtered events and display them
            // Iterate through filtered events and display them
            filteredEvents.forEach(event => {
                // Retrieve event data
                const eventName = event.name;
                const artistName = event._embedded.attractions[0].name;
                const venueName = event._embedded.venues[0].name;
                const date = event.dates.start.localDate;
                const localTime = event.dates.start.localTime || 'TBA'; // Default value if localTime is undefined
                const city = event._embedded.venues[0].city.name;
                const country = event._embedded.venues[0].country.countryCode;
                const url = event.url;
                const imageURL = event.images[0].url;

                // Generate HTML for the event
                const eventHTML = `
                    <div class="event">
                        <div class="event-image" style="background-image: url(${imageURL});"></div>
                        <div class="event-content">
                            <div class="date-time-checkbox">
                                <div class="date-time">
                                    <span>${date}</span>
                                    <span>•</span>
                                    <span>${localTime}</span>
                                </div>
                                <input type='checkbox' name='addToList[]' value='${eventName}'>
                            </div>
                            <span class="event-name"><a href='${url}'>${eventName}</a></span>
                            <span>${artistName}</span>
                            <div class="location-venue">
                                <span>${city}, ${country}</span>
                                <span>•</span>
                                <span>${venueName}</span>
                            </div>
                        </div>
                    </div>
                `;

                // Append event HTML to event container
                document.getElementById('event-container').insertAdjacentHTML('beforeend', eventHTML);
            });

        }



        // ^ADDED BY KELLY

        
    </script>

    <?php include 'header.php';?>

    <h1>Concerts for you</h1>
    <p>Select concerts to add to your list</p>
    <button onclick="getEventsCloseToUser()">Get events close to you</button>
    <div id='event-container'></div>

</body>
</html>