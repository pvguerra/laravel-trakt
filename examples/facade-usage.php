<?php

use Pvguerra\LaravelTrakt\Facades\Trakt;

// Get a movie by ID or slug
$movie = Trakt::movie()->get('the-batman-2022');

// Get popular movies
$popularMovies = Trakt::movie()->popular();

// Get trending shows
$trendingShows = Trakt::show()->trending();

// Search for content
$searchResults = Trakt::search()->query('batman', 'movie');

// With authentication
Trakt::setToken('your-access-token');

// Get user history
$history = Trakt::user()->history('me', 'movies');

// Get calendar
$calendar = Trakt::calendar()->myShows();
