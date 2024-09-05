<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Invoice;
use Illuminate\Http\Request;
use Spatie\LaravelPdf\Facades\Pdf;
use Spatie\Browsershot\Browsershot;

class InvoicePdfController extends Controller
{

    public function __invoke(Order $invoice_data)
    {
        $invoice_configuration = Invoice::where('user_id', auth()->user()->id)->first();

        $font = $invoice_configuration->font->getLabel();
        $color = $invoice_configuration->color;
        $logo = $invoice_configuration->logo;
        $show_logo = $invoice_configuration->show_logo;

        $data = compact('font', 'color', 'logo', 'show_logo', 'invoice_data');

        Pdf::view('invoice-generator', $data)
            ->withBrowsershot(function (Browsershot $browsershot) {
                $browsershot->setNodeBinary("C:\\laragon\\bin\\nodejs\\node-v20.15.0-win-x64\\node.exe")
                    ->setNpmBinary("C:\\laragon\\bin\\nodejs\\node-v20.15.0-win-x64\\node_modules\\npm\\bin")
                    ->setNodeModulePath("C:\\laragon\\www\\filament-shop\\node_modules");
            })
            ->format('a4')
            ->save('invoice.pdf');
    }
}
