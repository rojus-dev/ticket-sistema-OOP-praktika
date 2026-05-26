<!DOCTYPE html>
<html lang="lt">
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: Arial, sans-serif; color: #333; line-height: 1.6; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background: #0891b2; color: white; padding: 20px; border-radius: 8px 8px 0 0; }
        .content { background: #f9fafb; padding: 20px; border: 1px solid #e5e7eb; border-radius: 0 0 8px 8px; }
        .comment-box { background: white; border-left: 4px solid #0891b2; padding: 12px 16px; margin: 15px 0; border-radius: 4px; }
        .footer { color: #9ca3af; font-size: 12px; margin-top: 20px; }
    </style>
</head>
<body>
<div class="container">
    <div class="header">
        <h2 style="margin:0;">💬 Naujas komentaras prie jūsų problemos</h2>
    </div>
    <div class="content">
        <p>Sveiki, <strong>{{ $ticket->user->name }}</strong>!</p>
        <p>Prie jūsų problemos <strong>„{{ $ticket->title }}"</strong> pridėtas naujas komentaras:</p>
        <div class="comment-box">
            <p style="margin:0;">{{ $comment->comment }}</p>
            <p style="margin: 8px 0 0; font-size: 13px; color: #6b7280;">
                Parašė: <strong>{{ $comment->user->name }}</strong>
                &bull; {{ $comment->created_at->format('Y-m-d H:i') }}
            </p>
        </div>
        <p><strong>Problemos statusas:</strong> {{ $ticket->status }}</p>
        <p class="footer">Šis laiškas išsiųstas automatiškai. Neatsakinėkite į jį.</p>
    </div>
</div>
</body>
</html>