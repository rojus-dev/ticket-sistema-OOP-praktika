<!DOCTYPE html>
<html lang="lt">
<head>
    <meta charset="UTF-8">
    <title>Aktyvių problemų ataskaita</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
        }

        h1 {
            text-align: center;
            margin-bottom: 25px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            border: 1px solid #000;
            padding: 6px;
        }

        th {
            background-color: #eeeeee;
        }
    </style>
</head>
<body>
    <h1>Aktyvių problemų ataskaita</h1>

    <p><strong>Ataskaitos data:</strong> {{ date('Y-m-d H:i') }}</p>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Pavadinimas</th>
                <th>Kategorija</th>
                <th>Statusas</th>
                <th>Sukūrė</th>
                <th>Sukurta</th>
            </tr>
        </thead>
        <tbody>
            @forelse($tickets as $ticket)
                <tr>
                    <td>{{ $ticket->id }}</td>
                    <td>{{ $ticket->title }}</td>
                    <td>{{ $ticket->category->name }}</td>
                    <td>{{ $ticket->status }}</td>
                    <td>{{ $ticket->user->name }}</td>
                    <td>{{ $ticket->created_at->format('Y-m-d H:i') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6">Aktyvių problemų nėra.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>