<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Invoice;
use Illuminate\Http\Request;
use Spatie\LaravelPdf\Facades\Pdf;
use Spatie\Browsershot\Browsershot;
use Illuminate\Support\Facades\Storage;

class InvoicePdfController extends Controller
{
    public function __invoke(Order $order)
    {

        $invoice_configuration = Invoice::where('user_id', auth()->user()->id)->first();

        $font = $invoice_configuration->font->getLabel();
        $color = $invoice_configuration->color;
        $logo = $invoice_configuration->logo;
        $show_logo = $invoice_configuration->show_logo;

        $data = compact('font', 'color', 'logo', 'show_logo', 'order');

        $pdfPath = Storage::disk('public')->path("invoice_{$order->id}.pdf");

        Pdf::view('invoice-generator', $data)
            ->withBrowsershot(function (Browsershot $browsershot) {
                $browsershot->setNodeBinary("C:\\laragon\\bin\\nodejs\\node-v20.15.0-win-x64\\node.exe")
                    ->setNpmBinary("C:\\laragon\\bin\\nodejs\\node-v20.15.0-win-x64\\node_modules\\npm\\bin")
                    ->setNodeModulePath("C:\\laragon\\www\\filament-shop\\node_modules")
                    ->noSandbox();
            })
            ->format('a4')
            ->save($pdfPath);

        return response()->file($pdfPath, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="invoice.pdf"'
        ])->deleteFileAfterSend(true);
    }
}
