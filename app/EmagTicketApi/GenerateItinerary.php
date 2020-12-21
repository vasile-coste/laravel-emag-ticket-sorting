<?php

namespace App\EmagTicketApi;

class GenerateItinerary
{

    /**
     * @var Ticket[]
     */
    private $tickets;

    public function __construct(array $rawTickets)
    {
        foreach ($rawTickets as $rawTicket) {
            $this->tickets[] = new Ticket($rawTicket);
        }
    }

    /**
     * @param Ticket[] $tickets
     * 
     * @return Ticket[]
     */
    private function sortTickets(array $tickets): array
    {
        // map tickets with start destination
        $mapFromTickets = [];
        foreach ($tickets as $ticket) {
            $mapFromTickets[$ticket->getFrom()] = $ticket;
        }

        // get final destination from each ticket
        $mapToKeys = [];
        foreach ($tickets as $ticket) {
            $mapToKeys[] = $ticket->getTo();
        }

        // get the start ticket
        $firstTicket = $this->getStart($mapFromTickets, $mapToKeys);

        // arrange all the tickets based on the first ticket
        $sortedTickets = $this->arrangeTickets($firstTicket, $mapFromTickets);

        return $sortedTickets;
    }

    /**
     * @param Ticket $ticket
     * @param array $mapFromTickets
     * 
     * @return Ticket[]
     */
    private function arrangeTickets(Ticket $ticket, array $mapFromTickets): array
    {
        $tickets = [
            $ticket
        ];

        // remove the first ticket
        unset($mapFromTickets[$ticket->getFrom()]);

        // iterate the rest of the tickets
        while(count($mapFromTickets) > 0){
            /** Ticket $currentTicket */
            $currentTicket = end($tickets);
            $tickets[] = $mapFromTickets[$currentTicket->getTo()];
            unset($mapFromTickets[$currentTicket->getTo()]);
        }

        return $tickets;
    }

    /**
     * Get the journey start
     * 
     * @param array $mapFromTickets | Ticket mapped with 'from' key
     * @param array $toKeys | keys 'to' from Ticket obj 
     * 
     * @return Ticket
     */
    private function getStart(array $mapFromTickets, array $toKeys): Ticket
    {
        foreach ($mapFromTickets as $from => $ticket) {
            if (!in_array($from, $toKeys)) {
                return $ticket;
            }
        }
    }

    /**
     * @return string[]
     */
    public function generate(): array
    {
        $itinerary = [];

        foreach($this->sortTickets($this->tickets) as $ticket){
            $itinerary[] = $ticket->getTicket();
        }

        return $itinerary;
    }
}
