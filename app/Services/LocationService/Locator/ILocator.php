<?php

namespace App\Services\LocationService\Locator;

interface ILocator
{
    /**
     * Get locality
     */
    public function getLocality(): string;

    /**
     * Get location
     * 
     * location: {lat: string, lng: string}
     */
    public function getLocation();

    /**
     * Get view port
     * 
     * viewport: {
     *  northeast: {lat: string, lng: string},
     *  southwest: {lat: string, lng: string}
     * }
     */
    public function getViewPort();
}
