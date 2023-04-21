<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Details</title>

    <style>
        table {
            width: 95%;
            border-collapse: collapse;
            margin: 50px auto;
        }

        /* Zebra striping */
        tr{
            background: #fff;
        }

        th {
            background: #eee;
            color: #000;
            font-weight: bold;
        }

        td,
        th {
            padding: 5px;
            border: 1px solid #ccc;
            text-align: left;
            font-size: 14px;
        }


    </style>

</head>

<body>
    
    <div style="width: 100%; margin-top: -20px;">
        <div style="width: 40%; float:left; margin-right: 20px;">
            <img src="data:image/png;base64,{{ $image }}" width="100" alt="" /><br />
            <p>RC: {{ $office[0]->rc }}</p>
        </div>
        <div style="width: 40%; float: right;">
            <h5>{{ $office[0]->address }}<br />{{ $office[0]->city }}, {{ $office[0]->state }}
                <br />{{ $office[0]->phone }}<br />{{ $office[0]->email }}<br />{{ $office[0]->website }}</h5>
        </div>
    </div>
    <hr style="margin-top: 120px;" />
    <center><h3>INVOICE</h3></center>
    <div style="width: 100%; margin-top: -20px; padding-left: 20px;">
        <div style="width: 40%; float:left; margin-right: 20px;">
            <h4>Invoice To</h4>
            <h5>{{ $invoices[0]->clientinfo }}</h5>
        </div>
        <div style="width: 40%; float: right;">
            <h5>Invoice Date #: {{ date('d F Y') }}
            <br />Ref #: {{ $invoices[0]->refno }}
            <br />Invoice #: {{ $invoices[0]->invoiceno }}
            <br />{{ $office[0]->tin }}</h5>
        </div>
    </div>
    <table style="position: relative; top: 100px;">
        @if($invoices[0]->invoicetype == "Sheet 1")
        <thead>
            <tr>    
                <th>SN</th>
                <th>Description</th>
                <th>QTY</th>
                <th>Price ({{ $invoices[0]->currency }})</th>
                <th>Amount ({{ $invoices[0]->currency }})</th>
        </thead>
        <tbody id="sheetdata">
            @php $x=1 @endphp
            @foreach($vsheets as $vsheet)
            <tr>
                <td>{{ $x++ }}</td>
                <td>{{ $vsheet->description }}</td>
                <td>{{ $vsheet->qty }}</td>
                <td>{{ $vsheet->unitprice }}</td>
                <td>{{ $vsheet->amount }}</td>
            </tr>
            @endforeach
        </tbody>
        @elseif($invoices[0]->invoicetype == "Sheet 2")
        <thead>
            <tr>    
                <th>SN</th>
                <th>Description</th>
                <th>Period</th>
                <th>Rate ({{ $invoices[0]->currency }})</th>
                <th>Hours</b></th>
                <th>Amount ({{ $invoices[0]->currency }})</th>
        </thead>
        <tbody id="sheetdata">
            @php $x=1 @endphp
            @foreach($vsheets as $vsheet)
            <tr>
                <td>{{ $x++ }}</td>
                <td>{{ $vsheet->description }}</td>
                <td>{{ $vsheet->period }}</td>
                <td>{{ $vsheet->rate }}</td>
                <td>{{ $vsheet->hours }}</td>
                <td>{{ $vsheet->amount }}</td>
            </tr>
            @endforeach
        </tbody>
        @elseif($invoices[0]->invoicetype == "Sheet 3")
        <thead>
            <tr>    
                <th>SN</th>
                <th>Name</th>
                <th></th>
                <th>Designation</th>
                <th>Location</th>
                <th>Amount ({{ $invoices[0]->currency }})</th>
        </thead>
        <tbody id="sheetdata">
            @php $x=1 @endphp
            @foreach($vsheets as $vsheet)
            <tr>
                <td>{{ $x++ }}</td>
                <td>{{ $vsheet->name }}</td>
                <td></td>
                <td>{{ $vsheet->designation }}</td>
                <td>{{ $vsheet->location }}</td>
                <td>{{ $vsheet->amount }}</td>
            </tr>
            @endforeach
        </tbody>
        @elseif($invoices[0]->invoicetype == "Sheet 4")
        <thead>
            <tr>    
                <th>SN</th>
                <th>Description</th>
                <th></th>
                <th>Date</th>
                <th></th>
                <th>Amount ({{ $invoices[0]->currency }})</th>
        </thead>
        <tbody id="sheetdata">
            @php $x=1 @endphp
            @foreach($vsheets as $vsheet)
            <tr>
                <td>{{ $x++ }}</td>
                <td>{{ $vsheet->description }}</td>
                <td></td>
                <td>{{ $vsheet->date }}</td>
                <td></td>
                <td>{{ $vsheet->amount }}</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            
        @endif
            <tr>    
                <th></th>
                <th></th>
                <th></th>
                <th>Sub Total ({{ $invoices[0]->currency }})</th>
                <th>{{ $invoices[0]->totalprice }}</th>
                <th>{{ $invoices[0]->totalamount }}</th>
            </tr>
            @if($invoices[0]->totalvat != 0)
            <tr>    
                <th></th>
                <th></th>
                <th></th>
                <th>VAT ({{ $invoices[0]->vatp }}%)</th>
                <th></th>
                <th>{{ $invoices[0]->totalvat }}</th>
            </tr>
            @endif
            @if($invoices[0]->totalwht != 0)
            <tr>    
                <th></th>
                <th></th>
                <th></th>
                <th>WHT ({{ $invoices[0]->whtp }}%)</th>
                <th></th>
                <th>{{ $invoices[0]->totalwht }}</th>
            </tr>
            @endif
            <tr>    
                <th></th>
                <th></th>
                <th></th>
                <th>Total ({!! $invoices[0]->currency !!})</th>
                <th></th>
                <th>{{ $invoices[0]->sumamounts }}</th>
            </tr>
        </tfoot>
    </table>

    <div style="width: 100%; margin-top: 120px; padding-left: 20px;">
        <div style="width: 80%; float:left; margin-right: 20px;">
            <h5>Amount in Words: {{ $invoices[0]->amountinwords }}</h5>
        </div>
        <div style="width: 20%; float: right;">
        </div>
    </div>


    <div style="width: 100%; margin-top: 70px; padding-left: 20px;">
        <div style="width: 40%; float:left; margin-right: 20px;">
            <h3 style="margin-bottom: -3px;">Account Details:</h3>
            <h5>Account Number: {{ $invoices[0]->accountno }}<br />
            Account Name: {{ $invoices[0]->accountname }}<br />
            Bank Name: {{ $invoices[0]->bank }}<br />
            Bank Branch: {{ $invoices[0]->branch }}<br />
            Sort Code: {{ $invoices[0]->sortcode }}<br />
            IBAN Number: {{ $invoices[0]->ibanno }}</h5>
        </div>
        <div style="width: 40%; margin-top: 20px; float: right;">
            <img src="data:image/png;base64, {!! base64_encode(QrCode::size(150)->generate('https://app.reliaenergy.com/invoicedetails?id='.$invoices[0]->id)) !!} ">
        </div>
    </div>

    <div style="width: 100%; margin-top: 200px; padding-left: 20px;">
        <div style="width: 40%; float:left; margin-right: 20px;">
            <p><img src="data:image/png;base64,{{ app\Http\Controllers\Controller::staffpdfsignature($invoices[0]->sentform) }}" width="120" alt="" />
            <br /><b>{{ app\Http\Controllers\Controller::staffname($invoices[0]->sentform) }}</b><br />
            {{ app\Http\Controllers\Controller::staffdesignation($invoices[0]->sentform) }}</p>
        </div>
        <div style="width: 40%; float: right;">
            <h6>Invoice Generated on {{ date('d/m/Y') }}</h6>
        </div>
    </div>




    

</body>

</html>