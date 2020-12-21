<?php

namespace App\Http\Controllers;

use App\Helpers\AjaxResponse;
use App\EmagTicketApi\GenerateItinerary;

class TicketController extends Controller
{
    /**
     * @var AjaxResponse
     */
    private $ajaxResponse;

    /**
     * @param AjaxResponse $ajaxResponse
     */
    public function __construct(AjaxResponse $ajaxResponse)
    {
        $this->ajaxResponse = $ajaxResponse;
    }

    /**
     * Load home view blade
     */
    public function view()
    {
        return view("home");
    }

    /**
     * Return an array of each step from itinerary
     * 
     * @return string
     */
    public function getItinerary(): string
    {
        return $this->ajaxResponse
            ->setLocation('/')
            ->setData((new GenerateItinerary($this->getDefaultInput()))->generate())
            ->setSuccess(true)
            ->setMessage("Itinerary generated!")
            ->toJson();
    }

    /**
     * This will be the payload that could come from any source, for this demo let's make the assumption that will be like this
     * 
     * @return array
     */
    private function getDefaultInput(): array
    {
        $input = [
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
            ],
            [
                "type" => "train",
                "number" => "ICN 35780",
                "from" => "Venice Airport", //"Gara Venetia Santa Lucia",
                "to" => "Bologna San Ruffillo",
                "seat" => "13F",
                "location" => "Platform 1"
            ],
            [
                "type" => "bus",
                "number" => "airport",
                "from" => "Bologna San Ruffillo",
                "to" => "Bologna Guglielmo Marconi Airport"
            ],
            [
                "type" => "airport",
                "number" => "AF1229",
                "from" => "Bologna Guglielmo Marconi Airport",
                "to" => "Paris CDG Airport",
                "seat" => "10A",
                "location" => "22",
                "observation" => "Self-checkin luggage at counter"
            ],
            [
                "type" => "airport",
                "number" => "AF136",
                "from" => "Paris CDG Airport",
                "to" => "Chicago O'Hare",
                "seat" => "10A",
                "location" => "32",
                "observation" => "Luggage will transfer automatically from the last flight"
            ]
        ];

        // randomize the array
        shuffle($input);

        return $input;
    }
}
