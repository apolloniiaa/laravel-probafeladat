<!DOCTYPE html>
<html lang="hu">
<body style="font-family: sans-serif; color: #111;">
    <h1 style="font-size: 20px;">Új üzenet érkezett</h1>

    <p>
        <strong>Név:</strong> {{ $contactMessage->name }}<br>
        <strong>E-mail:</strong> <a href="mailto:{{ $contactMessage->email }}">{{ $contactMessage->email }}</a><br>
        <strong>Beküldve:</strong> {{ $contactMessage->created_at->format('Y.m.d H:i') }}
    </p>

    <p style="white-space: pre-line;">{{ $contactMessage->message }}</p>

    <p><a href="{{ route('admin.messages.index') }}">Üzenetek megtekintése</a></p>
</body>
</html>
