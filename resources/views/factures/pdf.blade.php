<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Facture #{{ $facture->id }}</title>
    <style>
        body {
            font-family: Helvetica, Arial, sans-serif;
            font-size: 12px;
            color: #333;
            margin: 40px;
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #2563eb;
            padding-bottom: 15px;
            margin-bottom: 25px;
        }
        .header h1 {
            color: #2563eb;
            margin: 0;
            font-size: 22px;
        }
        .header p {
            margin: 5px 0 0;
            color: #666;
        }
        .info-box {
            width: 100%;
            margin-bottom: 25px;
        }
        .info-box td {
            vertical-align: top;
            width: 50%;
            padding: 10px;
        }
        .info-box .label {
            font-size: 10px;
            text-transform: uppercase;
            color: #888;
            margin-bottom: 3px;
        }
        table.details {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 25px;
        }
        table.details th {
            background-color: #f3f4f6;
            text-align: left;
            padding: 8px;
            font-size: 11px;
            text-transform: uppercase;
            color: #555;
            border-bottom: 2px solid #ddd;
        }
        table.details td {
            padding: 8px;
            border-bottom: 1px solid #eee;
        }
        .total-row td {
            font-weight: bold;
            font-size: 14px;
            border-top: 2px solid #333;
        }
        .solde {
            margin-top: 15px;
            padding: 12px;
            background-color: {{ $solde > 0 ? '#fee2e2' : '#dcfce7' }};
            color: {{ $solde > 0 ? '#991b1b' : '#166534' }};
            border-radius: 4px;
            font-weight: bold;
        }
        .footer {
            margin-top: 40px;
            text-align: center;
            font-size: 10px;
            color: #999;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Facture d'Eau #{{ $facture->id }}</h1>
        <p>Gestion de la Facturation d'Eau</p>
        <p>Date d'émission : {{ $facture->created_at->format('d/m/Y') }}</p>
    </div>

    <table class="info-box">
        <tr>
            <td>
                <div class="label">Abonné</div>
                <strong>{{ $facture->client->nom }} {{ $facture->client->prenom }}</strong><br>
                {{ $facture->client->adresse }}<br>
                Tél : {{ $facture->client->telephone }}<br>
                Collectivité : {{ $facture->client->categorie ?? '-' }}
            </td>
            <td>
                <div class="label">Compteur</div>
                N° Série : {{ $facture->compteur->numero_serie }}
            </td>
        </tr>
    </table>
    <table class="details">
        <thead>
            <tr>
                <th>Description</th>
                <th>Consommation</th>
                <th>Montant</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Consommation d'eau</td>
                <td>{{ $facture->consommation }} m³</td>
                <td>{{ number_format($facture->montant, 0, ',', ' ') }} FCFA</td>
            </tr>
            <tr class="total-row">
                <td colspan="2">Total à payer</td>
                <td>{{ number_format($facture->montant, 0, ',', ' ') }} FCFA</td>
            </tr>
        </tbody>
    </table>
    <table class="details">
        <thead>
            <tr>
                <th>Date de paiement</th>
                <th>Montant payé</th>
                <th>Mode de règlement</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($facture->facturations as $paiement)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($paiement->date_paiement)->format('d/m/Y') }}</td>
                    <td>{{ number_format($paiement->mensualite, 0, ',', ' ') }} FCFA</td>
                    <td>{{ $paiement->reglement ?? '-' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="3">Aucun paiement enregistré</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    <div class="solde">
        @if ($solde > 0)
            Solde restant dû : {{ number_format($solde, 0, ',', ' ') }} FCFA
        @else
            Facture entièrement payée ✓
        @endif
    </div>
    <div class="footer">
        Document généré automatiquement — Application de Gestion de la Facturation d'Eau
    </div>
</body>
</html>