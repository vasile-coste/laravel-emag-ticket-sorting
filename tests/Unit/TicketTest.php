<?php

namespace Tests\Unit;

use App\EmagTicketApi\Ticket;
use PHPUnit\Framework\TestCase;

class TicketTest extends TestCase
{
    /**
     * Expected behavior
     *
     * @return void
     */
    public function testTicket()
    {
        $rawTicket = [
            "type" => "train",
            "number" => "RJX 765",
            "from" => "St. Anton am Arlberg Bahnhof",
            "to" => "Innsbruck Hbf",
            "seat" => "17C",
            "location" => "Platform 3"
        ];
        $ticket = (new Ticket($rawTicket))->getTicket();
        $actual = 'Board train number RJX 765, Platform 3 from St. Anton am Arlberg Bahnhof to Innsbruck Hbf. Seat number 17C';

        $this->assertEquals($actual, $ticket);
    }

    /**
     * Ticket is not supported
     *
     * @return void
     */
    public function testTicketNotSupported()
    {
        $rawTicket = [
            "type" => "test",
            "number" => "RJX 765",
            "from" => "St. Anton am Arlberg Bahnhof",
            "to" => "Innsbruck Hbf",
            "seat" => "17C",
            "location" => "Platform 3"
        ];
        $ticket = (new Ticket($rawTicket))->getTicket();
        $actual = 'The type of transpot is not supported!';

        $this->assertEquals($actual, $ticket);
    }
}
