<!DOCTYPE html>
<html>
<head>
    <title>AI Avatar TTS</title>
</head>
<body>
    <h2>Enter Text and Image URL for AI Avatar:</h2>
    <form method="POST" action="{{ url('/avatar_tts/generate') }}">
        @csrf
        <label>Enter Text:</label><br>
        <textarea name="text" rows="4" required></textarea><br><br>

        <label>Enter Image URL:</label><br>
        <input type="url" name="image_url" placeholder="https://your-image-url.com/avatar.jpg" required><br><br>

        <button type="submit">Generate</button>
    </form>
</body>
</html>
