<?php

namespace Pvguerra\LaravelTrakt\Traits;

use Pvguerra\LaravelTrakt\TraktCalendar;
use Pvguerra\LaravelTrakt\TraktCertification;
use Pvguerra\LaravelTrakt\TraktCheckIn;
use Pvguerra\LaravelTrakt\TraktCountry;
use Pvguerra\LaravelTrakt\TraktEpisode;
use Pvguerra\LaravelTrakt\TraktGenre;
use Pvguerra\LaravelTrakt\TraktLanguage;
use Pvguerra\LaravelTrakt\TraktList;
use Pvguerra\LaravelTrakt\TraktMovie;
use Pvguerra\LaravelTrakt\TraktNetwork;
use Pvguerra\LaravelTrakt\TraktPerson;
use Pvguerra\LaravelTrakt\TraktRecommendation;
use Pvguerra\LaravelTrakt\TraktSearch;
use Pvguerra\LaravelTrakt\TraktSeason;
use Pvguerra\LaravelTrakt\TraktShow;
use Pvguerra\LaravelTrakt\TraktSync;
use Pvguerra\LaravelTrakt\TraktUser;

trait ProvidesTraktResources
{
    /**
     * Get the calendar instance.
     *
     * @return \Pvguerra\LaravelTrakt\TraktCalendar
     */
    public function calendar(): TraktCalendar
    {
        return new TraktCalendar($this);
    }

    /**
     * Get the certification instance.
     *
     * @return \Pvguerra\LaravelTrakt\TraktCertification
     */
    public function certification(): TraktCertification
    {
        return new TraktCertification($this);
    }

    /**
     * Get the check-in instance.
     *
     * @return \Pvguerra\LaravelTrakt\TraktCheckIn
     */
    public function checkIn(): TraktCheckIn
    {
        return new TraktCheckIn($this);
    }

    /**
     * Get the country instance.
     *
     * @return \Pvguerra\LaravelTrakt\TraktCountry
     */
    public function country(): TraktCountry
    {
        return new TraktCountry($this);
    }

    /**
     * Get the episode instance.
     *
     * @return \Pvguerra\LaravelTrakt\TraktEpisode
     */
    public function episode(): TraktEpisode
    {
        return new TraktEpisode($this);
    }

     /**
     * Get the genre instance.
     *
     * @return \Pvguerra\LaravelTrakt\TraktGenre
     */
    public function genre(): TraktGenre
    {
        return new TraktGenre($this);
    }
    
    /**
     * Get the language instance.
     *
     * @return \Pvguerra\LaravelTrakt\TraktLanguage
     */
    public function language(): TraktLanguage
    {
        return new TraktLanguage($this);
    }
    
    /**
     * Get the list instance.
     *
     * @return \Pvguerra\LaravelTrakt\TraktList
     */
    public function list(): TraktList
    {
        return new TraktList($this);
    }
    
    /**
     * Get the movie instance.
     *
     * @return \Pvguerra\LaravelTrakt\TraktMovie
     */
    public function movie(): TraktMovie
    {
        return new TraktMovie($this);
    }
    
    /**
     * Get the network instance.
     *
     * @return \Pvguerra\LaravelTrakt\TraktNetwork
     */
    public function network(): TraktNetwork
    {
        return new TraktNetwork($this);
    }
    
    /**
     * Get the person instance.
     *
     * @return \Pvguerra\LaravelTrakt\TraktPerson
     */
    public function person(): TraktPerson
    {
        return new TraktPerson($this);
    }
    
    /**
     * Get the recommendation instance.
     *
     * @return \Pvguerra\LaravelTrakt\TraktRecommendation
     */
    public function recommendation(): TraktRecommendation
    {
        return new TraktRecommendation($this);
    }

    /**
     * Get the search instance.
     *
     * @return \Pvguerra\LaravelTrakt\TraktSearch
     */
    public function search(): TraktSearch
    {
        return new TraktSearch($this);
    }

    /**
     * Get the season instance.
     *
     * @return \Pvguerra\LaravelTrakt\TraktSeason
     */
    public function season(): TraktSeason
    {
        return new TraktSeason($this);
    }

    /**
     * Get the show instance.
     *
     * @return \Pvguerra\LaravelTrakt\TraktShow
     */
    public function show(): TraktShow
    {
        return new TraktShow($this);
    }
    
    /**
     * Get the sync instance.
     *
     * @return \Pvguerra\LaravelTrakt\TraktSync
     */
    public function sync(): TraktSync
    {
        return new TraktSync($this);
    }
    
    /**
     * Get the user instance.
     *
     * @return \Pvguerra\LaravelTrakt\TraktUser
     */
    public function user(): TraktUser
    {
        return new TraktUser($this);
    }
}