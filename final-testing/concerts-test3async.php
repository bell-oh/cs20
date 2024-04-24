<!-- Displays events on page and also writes their data to hidden form fields -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Concerts</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <style>
        .event {
            border: 1px solid #000000;
        }
    </style>
</head>
<body>
    <script>
        // For each artist
        // Do an attraction search to get attractionId
        // Do an events search with attractionId

        // attractionSearch
        // Searches for an attraction
        // RETURNS: promise to a string that contains the attraction ID
        // Note: doesn't check if the attraction ID is a direct match;
        // ex. searching with 'Nirvana' would yield a different artist because
        // Nirvana is not actually touring (R.I.P.)
        async function attractionSearch(url, num) {
            console.log("attraction search");

            try {
                const res = await fetch(url);
                const data = await res.text();
                parsedData = JSON.parse(data);

                eventString = ``;
                // Get attractionId
                id = parsedData._embedded.attractions[0].id;
                eventSearchURL = `https://app.ticketmaster.com/discovery/v2/events.json?attractionId=${id}&apikey=1IiUV6YIvdbcA2xr6D9bBGrKOIao6VGb&size=1`;
                // Do event search to get html for each event
                const htmlString = await eventSearch(eventSearchURL, num);
                console.log("STRING: " + htmlString);
                eventString += htmlString;
                console.log("eventString " + eventString);
                if (eventString == undefined) {
                    console.log("UNDEFINED from attractionSearch");
                    eventString = ``;
                }
                return eventString;

            } catch (error) {
                console.log(error);
            }
        }
           
        // eventSearch
        // searches for an event given an attractionID
        // RETURNS: string of HTML containing event data, plus event data written
        // to a hidden form field
        function eventSearch(url, num) {
            
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
                        eventName = event.name; 
                        artistName = event._embedded.attractions[0].name;          
                        venue = event._embedded.venues[0].name; 
                        date = event.dates.start.localDate; 
                        localTime = event.dates.start.localTime; 
                        city = event._embedded.venues[0].city.name; 
                        state = event._embedded.venues[0].state.name; 
                        country = event._embedded.venues[0].country.name;  
                        url = event.url; 

                        inputName = "event" + num;

                        // HTML for each event
                        htmlString += `<div class='event'><label for='checkbox'>Add to my list</label><input type='checkbox' name='addToList[]' value=${inputName}><p>${eventName}</p><p>${artistName}</p><p>${venue}</p><p>${date}</p><p>${localTime}</p><p>${city}</p><p>${state}</p><p>${country}</p><p>${url}</p></div>`;
                        // Put data into comma separated values string
                        csvString = `${eventName},${artistName},${venue},${date},${localTime},${city},${state},${country},${url}`;
                        // Put csv into hidden form field
                        htmlString += `<input type='hidden' name='${inputName}' value='${csvString}'>`;
                    })
                    // Return HTML, including hidden form field
                    return htmlString;
                })
            .catch (error => console.log(error))
        }

        // fetchData
        // given an artist array, performs an attraction search then an 
        // event search and writes data to div on page
        async function fetchData(artists) {
            // String to build up HTML
            let allEvents = `<form method='POST' action='process_events.php'>`;
            // Ensures that the hidden form fields are named with a pattern, "event" + i
            let i = 0;
            for (const artist of artists) {
                attractionSearchURL = `https://app.ticketmaster.com/discovery/v2/attractions.json?keyword=${artist}&apikey=1IiUV6YIvdbcA2xr6D9bBGrKOIao6VGb&size=1`
                // Do attraction search to get attractionId  
                try {              
                    let eventString = await attractionSearch(attractionSearchURL, i);
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
                await new Promise(resolve => setTimeout(resolve, 500));
                // Increment i
                i++;
            }
            allEvents += `<input type='hidden' name='numEvents' value='${i}'>`;
            allEvents += `<input type='submit' value='Submit'>`;
            allEvents += `</form>`;
            console.log(allEvents);
    
            // Set HTML
            document.getElementById('mydiv').innerHTML = allEvents;

        }

        // Hardcoded artist arrays for testing
        // const artists = ["Pink Pantheress", "Psychedelic Porn Crumpets", "Adele", "Maggie Rogers", "Death Cab for Cutie"];
        const artists = ["Pink Pantheress", "asdfkjh", "Psychedelic Porn Crumpets", "Adele", "Nirvana"];
        // const artists = ["adele", "asdkfj", "Pink Pantheress"];
        // const artists = ["adele", "Pink Pantheress"];

        // Get data from Ticketmaster
        console.log("NEW FETCH!!!!!!!!!");
        fetchData(artists);
        
    </script>
    <?php
        echo "<div id='mydiv'></div>"
    ?>

</body>
</html>