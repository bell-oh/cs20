<!-- Having await problems -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Concerts</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bungee&family=Inter:wght@100..900&family=Lexend:wght@100..900&display=swap" rel="stylesheet">
    <style>
    </style>
</head>
<body>
    <script>
        // For each artist
        // Do an attraction search to get attractionId
        // Do an events search with attractionId

        // Find and return attractioID
        function attractionSearch(url) {
            fetch(url)
            .then (res => res.text())
            .then (data =>
            {
                console.log("got attraction data")
                data = JSON.parse(data);
                // If artist is found, proceed
                if (data.page.totalElements > 0) {
                    // Get attractionId
                    id = data._embedded.attractions[0].id;
                    console.log("artist " + id);
                    // return id;
                    const response = eventSearch(eventSearchURL); 
                    
                } else {
                    console.log("No artist found");
                    // return "";
                }
                
            })
            .catch (error => console.log(error))
        }

        function eventSearch(url) {
            fetch(eventSearchURL)
            .then (eventRes => eventRes.text())
            .then (eventData => 
                {
                    eventData = JSON.parse(eventData);
                    event = eventData._embedded.events;
                    console.log(event);
                    return event;
                    // events.forEach((event) => {

                    //     console.log("inside for loop");
                    //     newEvent.push(event.name); 
                    //     newEvent.push(event._embedded.attractions[0].name);          
                    //     newEvent.push(event._embedded.venues[0].name); 
                    //     newEvent.push(event.dates.start.localDate); 
                    //     newEvent.push(event.dates.start.localTime); 
                    //     newEvent.push(event._embedded.venues[0].city.name); 
                    //     newEvent.push(event._embedded.venues[0].state.name); 
                    //     newEvent.push(event._embedded.venues[0].country.name);  
                    //     newEvent.push(event.url);
                        
                    //     console.log("NEW EVENT")
                    //     console.log(newEvent);

                    //     // eventsArray.push(newEvent);
                    //     // console.log("EVENTSSARRAY")
                    //     // console.log(eventsArray);

                    //     // Fill hidden form fields with data
                    //     // document.forms["event"]["eventName"].value = eventName;
                    //     // document.forms["event"]["artistName"].value = artistName; 
                    //     // document.forms["event"]["venue"].value = venue; 
                    //     // document.forms["event"]["date"].value = date; 
                    //     // document.forms["event"]["localTime"].value = localTime; 
                    //     // document.forms["event"]["city"].value = city; 
                    //     // document.forms["event"]["state"].value = state; 
                    //     // document.forms["event"]["country"].value = country; 
                    //     // document.forms["event"]["url"].value = url; 

                        
                    // })  
                    // console.log(eventsArray);
                    // document.forms["events"]["allEvents"].value = eventsArray;
                    // document.forms["events"].submit();
                })
            .catch (error => console.log(error))

            // Auto submit form to pass data to PHP
            
        }

        async function fetchData() {
            // const artists = ["Pink Pantheress", "Psychedelic Porn Crumpets", "Adele", "Maggie Rogers", "Death Cab for Cutie", "Nirvana"];
            // const artists = ["Pink Pantheress", "asdfkjh", "Psychedelic Porn Crumpets", "Adele"];
            const artists = ["adele", "asdkfj"];
            const events = [];
            for (const artist of artists) {
                attractionSearchURL = `https://app.ticketmaster.com/discovery/v2/attractions.json?keyword=${artist}&apikey=1IiUV6YIvdbcA2xr6D9bBGrKOIao6VGb&size=1`
                // Do attraction search to get attractionId
                // !! Function is not waiting for attraction ID ??
                attractionSearch(attractionSearchURL)
                .then(attractionID => 
                    {
                        console.log("ID: " + attractionID);
                        if (attractionID != "") {
                            console.log("searching with attraction ID " + attractionID);
                            eventSearchURL = `https://app.ticketmaster.com/discovery/v2/events.json?attractionId=${attractionID}&apikey=1IiUV6YIvdbcA2xr6D9bBGrKOIao6VGb&size=1`;
                            // Do event search
                            const newEvent = eventSearch(eventSearchURL); 
                            events.push(newEvent)
                        }
                    }
                    
                );

                

                // Delay to satisfy rate limit (max 5 requests per second)
                await new Promise(resolve => setTimeout(resolve, 500));
            }
            console.log(events);
        }

        // Get data from Ticketmaster
        fetchData();
        
    </script>
    <?php
        echo "<form id='eventForm' name='events' method='get' action='process_event.php'>";
        echo "<input type='hidden' name='allEvents'>";
        echo "<input type='hidden' name='eventName'>";
        echo "<input type='hidden' name='artistName'>";
        echo "<input type='hidden' name='venue'>";
        echo "<input type='hidden' name='date'>";
        echo "<input type='hidden' name='localTime'>";
        echo "<input type='hidden' name='city'>";
        echo "<input type='hidden' name='state'>";
        echo "<input type='hidden' name='country'>";
        echo "<input type='hidden' name='url'>";
        echo "</form>"

    ?>

</body>
</html>