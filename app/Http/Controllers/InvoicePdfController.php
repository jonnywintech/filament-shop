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
                $browsershot->setNodeBinary(env('NODE_BINARY_PATH'))
                    ->setNpmBinary(env('NPM_BINARY_PATH'))
                    ->setNodeModulePath(env('NODE_MODULES_PATH'))
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
