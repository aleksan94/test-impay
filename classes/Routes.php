<?php

namespace Aleks\TestImpay;

class Routes
{
    /** @var array<Flight>*/
    private array $flights = [];

    private ?array $routes = null;

    public function __construct(array $flights = []) {
        $flights = array_map(fn(array $data) => Flight::fromArray($data), $flights);
        usort($flights, fn(Flight $a, Flight $b) => $a->depart->getTimestamp() < $b->depart->getTimestamp() ? -1 : 1);
        $this->flights = $flights;
    }

    public function list(): array
    {
        if($this->routes === null) {
            $this->routes = $this->prepareRoutes($this->flights);
        }
        return $this->routes;
    }

    public function getLongestRoute(): Route
    {
        $routes = $this->list();
        usort($routes, fn(Route $a, Route $b) => $a->duration() > $b->duration() ? -1 : 1);
        return reset($routes);
    }

    private function prepareRoutes(): array 
    {
        $routes = [];
        foreach($this->flights as $flight) {
            $routes[] = new Route($this->prepareRoute($flight));
        }
        return $routes;
    }


    private function prepareRoute(Flight $flight, array &$route = [])
    {
        $route[] = $flight;

        $afterFlightList = array_filter(
            $this->flights, 
            fn(Flight $f) => $f->from === $flight->to && $f->depart->getTimestamp() >= $flight->arrival->getTimestamp()
        );

        if(count($afterFlightList) > 0) {
            foreach($afterFlightList as $f) {
                $this->prepareRoute($f, $route);
            }
        }

        return $route;
    }
}