<!DOCTYPE html>
<html lang="lt">
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: Arial, sans-serif; color: #333; line-height: 1.6; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background: #4f46e5; color: white; padding: 20px; border-radius: 8px 8px 0 0; }
        .content { background: #f9fafb; padding: 20px; border: 1px solid #e5e7eb; border-radius: 0 0 8px 8px; }
        .badge { display: inline-block; padding: 4px 12px; border-radius: 9999px; font-size: 14px; font-weight: bold; }
        .badge-new      { background: #dbeafe; color: #1d4ed8; }
        .badge-progress { background: #fef3c7; color: #d97706; }
        .badge-done     { background: #dcfce7; color: #16a34a; }
        .footer { color: #9ca3af; font-size: 12px; margin-top: 20px; }
    </style>
</head>
<body>
<div class="container">
    <div class="header">
        <h2 style="margin:0;">🔔 Problemos būsena pasikeitė</h2>
    </div>
    <div class="content">
        <p>Sveiki, <strong>{{ $ticket->user->name }}</strong>!</p>
        <p>Jūsų problemos <strong>„{{ $ticket->title }}"</strong> būsena pasikeitė:</p>
        <p>
            <span class="badge badge-new">{{ $oldStatus }}</span>
            &nbsp;→&nbsp;
            <span class="badge {{ $ticket->status === 'Vykdomas' ? 'badge-progress' : ($ticket->status === 'Užbaigtas' ? 'badge-done' : 'badge-new') }}">
                {{ $ticket->status }}
            </span>
        </p>
        <p><strong>Kategorija:</strong> {{ $ticket->category->name }}</p>
        <p><strong>Aprašymas:</strong><br>{{ Str::limit($ticket->description, 200) }}</p>
        <p class="footer">Šis laiškas išsiųstas automatiškai. Neatsakinėkite į jį.</p>
    </div>
</div>
</body>
</html>