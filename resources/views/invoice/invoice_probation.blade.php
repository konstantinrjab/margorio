<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Invoice generator</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 11px;
        }
        table {
            border: 1px solid black;
            border-collapse: collapse;
        }
        td {
            padding: 5px;
            border: 1px solid black;
        }
    </style>
</head>
<body>
<table style="width: 80%; margin: 0 auto;">
    <tbody>
    <tr style="font-weight: bold; text-align: center">
        <td colspan="2">
            Invoice #{{ $invoice_number }}
            <br>
            as of {{ $date_en }}
        </td>
    </tr>
    <tr>
        <td colspan="2" style="height: 11px"></td>
    </tr>
    <tr style="background-color: #943634;">
        <td colspan="2" style="height: 11px"></td>
    </tr>
    <tr>
        <td colspan="2">
            <span style="font-weight: bold">From: {{ $from_en }}</span> {{ $full_name_en }}
        </td>
    </tr>
    <tr>
        <td colspan="2">Tax Number – {{ $tax_number }}
            <br>
            Address of receiver: {{ $address_en }}
        </td>
    </tr>
    <tr style="padding-bottom: 50px">
        <td colspan="2">
            <span style="font-weight: bold">Bank details:</span>
            <br>
            {{ $bank_details_en }}
        </td>
    </tr>
    <tr>
        <td colspan="2">
            <span style="font-weight: bold">To:</span> CLIENT Abudantia B.V.
        </td>
    </tr>
    <tr>
        <td colspan="2">
            Full address: Heelsumstraat 51, E- Commerce Park, Curacao
        </td>
    </tr>
    <tr style="font-weight: bold; text-align: center">
        <td>
            Subject matter: {{ $invoice_subject_en }}
        </td>
        <td>
            AMOUNT, EUR
        </td>
    </tr>
    <tr>
        <td style="font-weight: bold">Description:</td>
        <td></td>
    </tr>
    <tr>
        <td style="font-weight: bold">{{ $invoice_description_en }}:</td>
        <td style="text-align: right">{{ $amount }}</td>
    </tr>
    <tr>
        <td style="font-weight: bold">TOTAL, EUR:</td>
        <td style="text-align: right">{{ $amount }}</td>
    </tr>
    </tbody>
</table>
</body>
</html>
