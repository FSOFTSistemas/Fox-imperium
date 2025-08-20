<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Relatório de Despesas</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            color: #333;
        }

        .header,
        .footer {
            text-align: center;
            padding: 10px;
            background-color: #f8f9fa;
        }

        .header h1 {
            margin: 0;
            font-size: 24px;
        }

        .footer {
            font-size: 10px;
            color: #666;
        }

        .container {
            width: 100%;
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .table th,
        .table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        .table th {
            background-color: #007bff;
            color: #fff;
        }

        .table td {
            text-align: right;
            font-family: Arial, Helvetica, sans-serif;
            font-size: 10px;
        }

        .table td:first-child {
            text-align: left;
        }

        .date {
            margin-top: 20px;
            font-size: 8px;
            color: #555;
        }
    </style>
</head>

<body>

    <!-- Cabeçalho -->
    <div class="header">
        <h1>Relatório de Despesas</h1>
        <p style="text-align: right; font-size: 8px;">Período: {{ $startDate }} a {{ $endDate }}</p>
    </div>

    <!-- Conteúdo -->
        <table class="table">
            <thead>
                <tr>
                    <th>Descrição</th>
                    <th>Data</th>
                    <th>Valor</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $totalDespesas = 0; // Inicializa o total
                @endphp

                @foreach ($dados as $despesa)
                    <tr>
                        <td>{{ $despesa->descricao }}</td>
                        <td>{{ \Carbon\Carbon::parse($despesa->data)->format('d/m/Y') }}</td>
                        <td>R$ {{ number_format($despesa->valor, 2, ',', '.') }}</td>
                    </tr>
                    @php
                        $totalDespesas += $despesa->valor; // Soma o valor da despesa ao total
                    @endphp
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="2" style="text-align: right; font-weight: bold;">Total de Despesas:</td>
                    <td style="font-weight: bold;">R$ {{ number_format($totalDespesas, 2, ',', '.') }}</td>
                </tr>
            </tfoot>
        </table>

        <div class="date" style="text-align: right">
            <p>Emitido em: {{ \Carbon\Carbon::now()->format('d/m/Y H:i:s') }}</p>
        </div>

    <!-- Rodapé -->
    <div class="footer">
        <p>&copy; {{ date('Y') }} - Sistema Contábil - FSOFT SISTEMAS</p>
    </div>

</body>

</html>
