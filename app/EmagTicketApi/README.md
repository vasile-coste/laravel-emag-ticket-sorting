## Expected Payload: an array of objects
[
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

## Usage
(new GenerateItinerary($arrayOfTickets))->generate()

## Will return an array of strings
[
    "Ticket String"
]

