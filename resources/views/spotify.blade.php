<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Spotify Profile</title>

    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .profile-container {
            max-width: 800px; /* Increased max width for better layout */
            margin: 50px auto;
            padding: 20px;
            border: 1px solid #dee2e6;
            border-radius: 5px;
            background-color: #fff;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        .profile-image {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            object-fit: cover;
            margin-bottom: 20px;
        }
        h1 {
            color: #1db954; 
        }
        .track-image {
            width: 100px; /* Increased size for better visibility */
            height: 100px;
            border-radius: 5px;
            margin-bottom: 10px; /* Space between image and text */
        }
        .track-item {
            text-align: center; /* Center align text */
            margin-bottom: 20px; /* Space between track items */
        }
        .track-name {
            font-weight: bold; /* Make track name bold */
        }
        .section-title {
            margin-top: 30px; /* Space above section titles */
            margin-bottom: 15px; /* Space below section titles */
        }
    </style>
</head>
<body>
    <div class="profile-container text-center">
        <h1>Spotify User Profile</h1>
        @if (!empty($user['images']) && count($user['images']) > 0)
            <img src="{{ $user['images'][0]['url'] }}" alt="Profile Picture" class="profile-image">
        @else
            <img src="https://via.placeholder.com/150" alt="Default Profile Picture" class="profile-image">
        @endif
        <p><strong>Name:</strong> {{ $user['display_name'] }}</p>
        <p><strong>Email:</strong> {{ $user['email'] }}</p>
        <p><strong>Country:</strong> {{ $user['country'] }}</p>
        <p><strong>Followers:</strong> {{ $user['followers']['total'] ?? 'N/A' }}</p>
        <p><strong>Product:</strong> {{ $user['product'] }}</p>

        <div class="row mt-4">
            <div class="col-md-6">
                <h2 class="section-title">Top Tracks</h2>
                <ul class="list-unstyled">
                    @foreach ($tracks['items'] as $track)
                        <li class="track-item">
                            <img src="{{ $track['album']['images'][0]['url'] }}" alt="Album Cover" class="track-image">
                            <div class="track-info">
                                <span class="track-name">{{ $track['name'] }}</span> by {{ $track['artists'][0]['name'] }}<br>
                                <small>Album: {{ $track['album']['name'] }}</small>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
            <div class="col-md-6">
                <h2 class="section-title">Top Artists</h2>
                <ul class="list-unstyled">
                    @foreach ($artists['items'] as $artist)
                        <li class="track-item">
                            <img src="{{ $artist['images'][0]['url'] }}" alt="{{ $artist['name'] }}" style="width: 50px; height: 50px; border-radius: 50%;"><br>
                            <strong>{{ $artist['name'] }}</strong>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
