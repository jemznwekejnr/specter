<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PDF;

use DB;
use QrCode;

class PdfController extends Controller
{
    //


    public function viewPDF()
    {
        $users = DB::table('users')->get();

        $image = base64_encode(file_get_contents(public_path('/assets/images/RELIA-ENERGY-Logo-2020 (1).png')));

        $pdf = PDF::loadView('pdftest', array('users' =>  $users, 'image' => $image))
        ->setPaper('a4', 'portrait');

        return $pdf->stream();

    }


    public function invoicepdf(Request $request){

        $invoices = DB::table('invoice')->where([['id', $request->invoice],['status', 'Unpaid']])->get();

        if($invoices[0]->invoicetype == "Sheet 1"){

            $invoicesheets = DB::table('invoicesheet1')->where('pvid', $invoices[0]->id)->get();

        }else if($invoices[0]->invoicetype == "Sheet 2"){

            $invoicesheets = DB::table('invoicesheet2')->where('pvid', $invoices[0]->id)->get();

        }else if($invoices[0]->invoicetype == "Sheet 3"){

            $invoicesheets = DB::table('invoicesheet3')->where('pvid', $invoices[0]->id)->get();

        }else if($invoices[0]->invoicetype == "Sheet 4"){

            $invoicesheets = DB::table('invoicesheet4')->where('pvid', $invoices[0]->id)->get();

        }


        $office = DB::table('companyinfo')->where('id', $invoices[0]->office)->get();

        $image = base64_encode(file_get_contents(public_path($office[0]->logo)));

        $pdf = PDF::loadView('pdf.invoice', array('invoices' =>  $invoices, 'image' => $image, 'vsheets' => $invoicesheets, 'office' => $office))
        ->setPaper('a4', 'portrait');

        return $pdf->stream();
    }



    public function receiptpdf(Request $request){

        $invoices = DB::table('invoice')->where([['id', $request->invoice],['status', 'Paid']])->get();

        if($invoices[0]->invoicetype == "Sheet 1"){

            $invoicesheets = DB::table('invoicesheet1')->where('pvid', $invoices[0]->id)->get();

        }else if($invoices[0]->invoicetype == "Sheet 2"){

            $invoicesheets = DB::table('invoicesheet2')->where('pvid', $invoices[0]->id)->get();

        }else if($invoices[0]->invoicetype == "Sheet 3"){

            $invoicesheets = DB::table('invoicesheet3')->where('pvid', $invoices[0]->id)->get();

        }else if($invoices[0]->invoicetype == "Sheet 4"){

            $invoicesheets = DB::table('invoicesheet4')->where('pvid', $invoices[0]->id)->get();

        }

        $office = DB::table('companyinfo')->where('id', $invoices[0]->office)->get();

        $image = base64_encode(file_get_contents(public_path($office[0]->logo)));

        $pdf = PDF::loadView('pdf.receipt', array('invoices' =>  $invoices, 'image' => $image, 'vsheets' => $invoicesheets, 'office' => $office))
        ->setPaper('a4', 'portrait');

        return $pdf->stream();
    }

    

    public function qrcode(){

        return view('qrcode');
    }
}
