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
        <td colspan="2">
            РАХУНОК №{{ $invoice_number }}
            <br>
            від {{ $date_uk }}
        </td>
    </tr>
    <tr>
        <td colspan="4" style="height: 11px"></td>
    </tr>
    <tr style="background-color: #943634;">
        <td colspan="4" style="height: 11px"></td>
    </tr>
    <tr>
        <td colspan="2">
            <span style="font-weight: bold">From: {{ $from_en }}</span> {{ $full_name_en }}
        </td>
        <td colspan="2">
            <span style="font-weight: bold">Від: {{ $from_uk }}</span> {{ $full_name_uk }}
        </td>
    </tr>
    <tr>
        <td colspan="2">Tax Number – {{ $tax_number }}
            <br>
            Address of receiver: {{ $address_en }}
        </td>
        <td colspan="2">ІПН - {{ $tax_number }}
            <br>
            Адреса отримувача: {{ $address_uk }}
        </td>
    </tr>
    <tr style="padding-bottom: 50px">
        <td colspan="2">
            <span style="font-weight: bold">Bank details:</span>
            <br>
            {{ $bank_details_en }}
        </td>
        <td colspan="2">
            <span style="font-weight: bold">Банківські реквізити:</span>
            <br>
            {{ $bank_details_uk }}
        </td>
    </tr>
    <tr>
        <td colspan="2">
            <span style="font-weight: bold">To:</span> CLIENT Abudantia B.V.
        </td>
        <td colspan="2">
            <span style="font-weight: bold">Кому:</span> ЗАМОВНИК Abudantia B.V.
        </td>
    </tr>
    <tr>
        <td colspan="2">
            Full address: Heelsumstraat 51, E- Commerce Park, Curacao
        </td>
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
        <td>
            Предмет: {{ $invoice_subject_uk }}
        </td>
        <td>
            СУМА, ЄВРО
        </td>
    </tr>
    <tr>
        <td style="font-weight: bold">Description:</td>
        <td></td>
        <td style="font-weight: bold">Опис:</td>
        <td></td>
    </tr>
    <tr>
        <td style="font-weight: bold">{{ $invoice_description_en }}:</td>
        <td style="text-align: right">{{ $amount }}</td>
        <td style="font-weight: bold">{{ $invoice_description_uk }}:</td>
        <td style="text-align: right">{{ $amount }}</td>
    </tr>
    <tr>
        <td style="font-weight: bold">TOTAL, EUR:</td>
        <td style="text-align: right">{{ $amount }}</td>
        <td style="font-weight: bold">ВСЬОГО, ЄВРО:</td>
        <td style="text-align: right">{{ $amount }}</td>
    </tr>
    <tr>
        <td colspan="4" style="height: 11px"></td>
    </tr>
    <tr>
        <td colspan="4" style="font-size: 8px">
            Оплата згідно цього Інвойсу є підтвердженням того, що Сторони не мають взаємних претензій та не мають
            наміру направляти рекламації. Договір не передбачає штрафних санкцій.
            <br>
            The Parties shall not be liable for non-performance or improper performance of the obligations under the
            agreement
            during the term of insuperable force circumstances. / Сторони звільняються від відповідальності за
            невиконання чи
            неналежне виконання зобов’язань за договором на час дії форс-мажорних обставин.
            <br>
            Any disputes arising out of the agreement between the Parties shall be settled by the competent court at the
            location of
            a defendant. / Всі спори, що виникнуть між Сторонами по договору будуть розглядатись компетентним судом за
            місцезнаходження відповідача.
            <br>
            Payment of this invoice might be made via intermediary payment system Transferwise/Оплата даного інвойсу
            може бути здійснена за посередництвом платіжної системи Transferwise
            <br>
            <br>
            <br>
            Supplier/Виконавець: _______________________ ({{ $full_name_uk }})
        </td>
    </tr>
    </tbody>
</table>
</body>
</html>
