<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Alasan Penolakan Tamu</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; padding: 20px; }
        form { max-width: 500px; margin: 0 auto; }
        textarea { width: 100%; height: 100px; margin-bottom: 10px; }
        .submit-btn { background-color: #f44336; color: white; border: none; padding: 10px 20px; cursor: pointer; }
    </style>
</head>
<body>
    <h2>Form Alasan Penolakan Tamu</h2>
    <form action="{{ route('kedatangan.submit-penolakan', $token) }}" method="POST">
        @csrf
        <div>
            <label for="alasan">Alasan Penolakan:</label>
            <textarea id="alasan" name="alasan" required></textarea>
        </div>
        <button type="submit" class="submit-btn">Kirim Penolakan</button>
    </form>
</body>
</html>
