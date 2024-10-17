<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;

class SpotifyController extends Controller
{
    // Redirect the user to Spotify's authorization page
    public function login()
    {
        // Add user-top-read scope to request top tracks and artists
        $query = http_build_query([
            'client_id' => env('SPOTIFY_CLIENT_ID'),
            'response_type' => 'code',
            'redirect_uri' => env('SPOTIFY_REDIRECT_URI'),
            'scope' => 'user-read-private user-read-email user-top-read',
        ]);

        return redirect('https://accounts.spotify.com/authorize?' . $query);
    }

    // Handle callback from Spotify
    public function callback(Request $request)
    {
        $code = $request->get('code');

        // Request an access token using the authorization code
        $client = new Client();
        $response = $client->post('https://accounts.spotify.com/api/token', [
            'verify' => false,  // Remember to enable this on production
            'form_params' => [
                'grant_type' => 'authorization_code',
                'code' => $code,
                'redirect_uri' => env('SPOTIFY_REDIRECT_URI'),
                'client_id' => env('SPOTIFY_CLIENT_ID'),
                'client_secret' => env('SPOTIFY_CLIENT_SECRET'),
            ],
        ]);

        $tokenData = json_decode($response->getBody(), true);

        // You now have the access token, which you can use to interact with the Spotify API
        $accessToken = $tokenData['access_token'];

        // Fetch the user's Spotify profile
        $userResponse = $client->get('https://api.spotify.com/v1/me', [
            'headers' => [
                'Authorization' => 'Bearer ' . $accessToken,
            ],
            'verify' => false  // Remember to enable this on production
        ]);

        $user = json_decode($userResponse->getBody(), true);

        // Fetch user's top tracks
        $topTracksResponse = $client->get('https://api.spotify.com/v1/me/top/tracks', [
            'headers' => [
                'Authorization' => 'Bearer ' . $accessToken,
            ],
            'query' => [
                'limit' => 5
            ],
            'verify' => false  // Remember to enable this on production
        ]);
        $tracks = json_decode($topTracksResponse->getBody(), true);

        // Fetch user's top artists
        $topArtistsResponse = $client->get('https://api.spotify.com/v1/me/top/artists', [
            'headers' => [
                'Authorization' => 'Bearer ' . $accessToken,
            ],
            'query' => [
                'limit' => 5
            ],
            'verify' => false  // Remember to enable this on production
        ]);
        $artists = json_decode($topArtistsResponse->getBody(), true);

        // Display user data, tracks, and artists
        return view('spotify', compact('user', 'tracks', 'artists'));
    }
}
