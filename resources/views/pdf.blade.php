<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: 'Arial', sans-serif;
        }

        .invoice {
            width: 100%;
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ccc;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .invoice-number {
            font-size: 20px;
            color: #333;
        }

        .details {
            margin-top: 20px;
            margin-bottom: 30px;
        }

        .item-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .item-table th, .item-table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        .total {
            margin-top: 20px;
            text-align: right;
            font-weight: bold;
        }
    </style>
</head>
<body>

    <div class="invoice">
        <div class="header">
            <h2>Lyan cosmetics</h2>
            <p class="invoice-number">Numero facture: 4131</p>
        </div>

        <div class="details">
            <p><strong>Customer:</strong> hoho</p>
            <p><strong>Date:</strong> {{ \Carbon\Carbon::now()->format('Y-m-d') }}</p>
        </div>

        <table class="item-table">
            <thead>
                <tr>
                    <th>Description</th>
                    <th>Price</th>
                </tr>
            </thead>
            <tbody>
                    <tr>
                        <td>test name</td>
                        <td>45</td>
                    </tr>
                    <tr>
                        <td>TEst name 2</td>
                        <td>45</td>
                    </tr>
                    <tr>
                        <td>Test name</td>
                        <td>23</td>
                    </tr>
            </tbody>
        </table>

        <p class="total">Total: 12</p>
    </div>

</body>
</html>
