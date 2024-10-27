<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alasan Penolakan</title>
</head>
<body>
    <h1>Alasan Penolakan Kedatangan Tamu</h1>
    <form action="{{ route('kedatangan.submit-penolakan', ['id' => $id, 'token' => $token]) }}" method="POST">
        @csrf
        <label for="alasan">Alasan Penolakan:</label><br>
        <textarea name="alasan" id="alasan" rows="4" cols="50" required></textarea><br>
        <button type="submit">Kirim Alasan Penolakan</button>
    </form>
</body>
</html>
