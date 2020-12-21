<?php

namespace Tests\Unit;

use App\EmagTicketApi\GenerateItinerary;
use App\EmagTicketApi\Ticket;
use PHPUnit\Framework\TestCase;

class GenerateItineraryTest extends TestCase
{
    /**
     * Expected behavior
     *
     * @return void
     */
    public function testGetItinerary()
    {
        $rawTickets = [
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
        ];
        $ticket = (new GenerateItinerary($rawTickets))->generate();
        $actual1 = 'Board train number RJX 765, Platform 3 from St. Anton am Arlberg Bahnhof to Innsbruck Hbf. Seat number 17C';
        $actual2 = 'Board the Tram number S5, from Innsbruck Hbf to Innsbruck Airport.';

        $this->assertEquals(2, count($ticket));
        $this->assertEquals($actual1, $ticket[0]);
        $this->assertEquals($actual2, $ticket[1]);
    }
}
