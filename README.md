# Laravel project that sorts tickets
The module is located in app/EmagTicketApi along side with the exercise pdf. The app also has a simple UI to display the results.

I've also created a controller called TickedController that handles the input

This project was use for eMag interview!


## Expected Payload: an array of objects
```
[
    [
        "type" => "train",
        "number" => "RJX 765",
        "from" => "St. Anton am Arlberg Bahnhof",
        "to" => "Innsbruck Hbf",
        "seat" => "17C",
        "location" => "Platform 3"
    ],
    [
        "type" => "tram",
        "number" => "S5",
        "from" => "Innsbruck Hbf",
        "to" => "Innsbruck Airport"
    ],
    [
        "type" => "airport",
        "number" => "AA904",
        "from" => "Innsbruck Airport",
        "to" => "Venice Airport",
        "seat" => "18B",
        "location" => "10",
        "observation" => "Self-checkin luggage at counter"
    ]
]
```
## Usage
(new GenerateItinerary($arrayOfTickets))->generate()

## Will return an array of strings
```
[
    "Ticket String"
]
```
