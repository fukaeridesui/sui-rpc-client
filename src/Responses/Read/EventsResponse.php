<?php

namespace Fukaeridesui\SuiRpcClient\Responses\Read;

/**
 * Events response.
 */
class EventsResponse
{
    private array $events = [];

    /**
     * @param array $response API response
     */
    public function __construct(array $response)
    {
        $events = [];
        foreach ($response as $eventData) {
            $events[] = new EventResponse($eventData);
        }
        $this->events = $events;
    }

    /**
     * Get events.
     *
     * @return EventResponse[] Events
     */
    public function getData(): array
    {
        return $this->events;
    }
} 