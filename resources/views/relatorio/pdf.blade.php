<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Relatório</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 14px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #000; padding: 8px; text-align: left; }
        th { background-color: #f4f4f4; }
    </style>
</head>
<body>
    <h1>Relatório {{ ucfirst($reportType) }}</h1>
    <p>Período: {{ $startDate }} a {{ $endDate }}</p>

    <table>
        <thead>
            <tr>
                <th>Descrição</th>
                <th>Data</th>
                <th>Tipo</th>
                <th>Valor</th>
            </tr>
        </thead>
        <tbody>
            @foreach($dados as $movimento)
                <tr>
                    <td>{{ $movimento->descricao }}</td>
                    <td>{{ $movimento->data }}</td>
                    <td>{{ $movimento->tipo }}</td>
                    <td>{{ number_format($movimento->valor, 2, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>