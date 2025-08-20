<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Capa do Relatório</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f6f9;
        }

        .container {
            text-align: center;
            padding: 30px;
            margin-top: 100px;
        }

        .logo {
            width: 150px; /* Ajuste conforme o tamanho do logo */
            margin-bottom: 20px;
        }

        .titulo {
            font-size: 40px;
            font-weight: bold;
            color: #2c3e50;
            margin-bottom: 10px;
        }

        .subtitulo {
            font-size: 22px;
            font-weight: normal;
            color: #7f8c8d;
            margin-bottom: 30px;
        }

        .detalhes {
            font-size: 18px;
            color: #34495e;
            margin-bottom: 15px;
        }

        .data {
            font-size: 14px;
            color: #95a5a6;
        }

        .linha {
            margin: 20px 0;
            height: 2px;
            background-color: #3498db;
            width: 60%;
            margin-left: auto;
            margin-right: auto;
        }
        
        .footer {
            margin-top: 50px;
            font-size: 12px;
            color: #95a5a6;
        }

    </style>
</head>
<body>
    <div class="container">
        <!-- Logo da Empresa -->
        {{-- <img src="{{ asset('images/logo.png') }}" alt="Logo da Empresa" class="logo"> --}}
        <img src="{{ public_path('images/logo.png') }}" alt="Logo da Empresa" class="logo">

        <!-- Título do Relatório -->
        <div class="titulo">Relatório Geral</div>

        <!-- Subtítulo com período -->
        <div class="subtitulo">Período: {{ \Carbon\Carbon::parse($startDate)->format('d/m/Y') }} a {{ \Carbon\Carbon::parse($endDate)->format('d/m/Y') }}</div>

        <!-- Detalhes da Empresa -->
        <div class="detalhes">
            <strong>Empresa: </strong> {{ $empresa->razao_social }}
        </div>

        <!-- Linha decorativa -->
        <div class="linha"></div>

        <!-- Data de emissão -->
        <div class="data">Emitido em: {{ \Carbon\Carbon::now()->format('d/m/Y H:i:s') }}</div>

        {{-- <!-- Rodapé opcional -->
        <div class="footer" >
            <p>Relatório gerado automaticamente para fins contábeis e financeiros.</p>
        </div> --}}
    </div>
</body>
</html>