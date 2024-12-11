<!DOCTYPE html>
<html>

<head>
    <title>{{ $subject }}</title>
</head>

<body>
    <h1>{{ $subject }}</h1>
    <p>{{ $body }}</p>

    @if (isset($qrCode))
        <p>Silakan scan QR code berikut:</p>
        <img src="{{ $qrCode }}" alt="QR Code">
    @endif
</body>

</html>
