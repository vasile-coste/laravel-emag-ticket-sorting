<?php

namespace App\EmagTicketApi;


class Ticket
{
    /**
     * @var string
     */
    private $type;

    /**
     * @var string
     */
    private $number;

    /**
     * @var string
     */
    private $from;

    /**
     * @var string
     */
    private $to;

    /**
     * @var string
     */
    private $seat;

    /**
     * @var string
     */
    private $location;

    /**
     * @var string
     */
    private $observation;

    /**
     * @param array $ticketData
     */
    public function __construct(array $ticketData)
    {
        $this->type = $ticketData['type'];
        $this->number = $ticketData['number'];
        $this->from = $ticketData['from'];
        $this->to = $ticketData['to'];
        if (isset($ticketData['seat'])) {
            $this->seat = $ticketData['seat'];
        }
        if (isset($ticketData['location'])) {
            $this->location = $ticketData['location'];
        }
        if (isset($ticketData['observation'])) {
            $this->observation = $ticketData['observation'];
        }
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @return string
     */
    public function getNumber(): string
    {
        return $this->number;
    }

    /**
     * @return string
     */
    public function getFrom(): string
    {
        return $this->from;
    }

    /**
     * @return string
     */
    public function getTo(): string
    {
        return $this->to;
    }

    /**
     * @return string|null
     */
    public function getSeat()
    {
        return $this->seat;
    }

    /**
     * @return string|null
     */
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * @return string|null
     */
    public function getObservation()
    {
        return $this->observation;
    }

    /**
     * @return string
     */
    public function getTicket(): string
    {
        switch ($this->getType()) {
            case "train":
                return sprintf(
                    "Board train number %s, %s from %s to %s. Seat number %s", 
                    $this->getNumber(),
                    $this->getLocation(),
                    $this->getFrom(),
                    $this->getTo(),
                    $this->getSeat()
               );
                
            case "tram":
                return sprintf(
                    "Board the Tram number %s, from %s to %s.", 
                    $this->getNumber(),
                    $this->getFrom(),
                    $this->getTo()
               );

            case "bus":
                return sprintf(
                    "Board the %s bus, from %s to %s. %s", 
                    $this->getNumber(),
                    $this->getFrom(),
                    $this->getTo(),
                    $this->getSeat() ? sprintf("Seat number %s", $this->getSeat()) : "No seat assignment"
               );

            case "airport":
                return sprintf(
                    "From %s, board the flight %s to %s from gate %s, seat %s. %s", 
                    $this->getFrom(),
                    $this->getNumber(),
                    $this->getTo(),
                    $this->getLocation(),
                    $this->getSeat(),
                    $this->getObservation()
               );
            
            default:
                return "The type of transpot is not supported!";
        }
    }
}
