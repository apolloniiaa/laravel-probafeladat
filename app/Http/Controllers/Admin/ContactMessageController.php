<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ContactMessageController extends Controller
{
    public function index(): View
    {
        return view('admin.messages.index', [
            'messages' => ContactMessage::query()->newestFirst()->simplePaginate(20),
        ]);
    }

    public function export(): StreamedResponse
    {
        return response()->streamDownload(function () {
            $output = fopen('php://output', 'w');

            fwrite($output, "\xEF\xBB\xBF");
            $this->writeRow($output, ['Név', 'E-mail', 'Üzenet', 'Beküldve']);

            foreach (ContactMessage::query()->newestFirst()->cursor() as $message) {
                $this->writeRow($output, [
                    $message->name,
                    $message->email,
                    $message->message,
                    $message->created_at->format('Y.m.d H:i'),
                ]);
            }

            fclose($output);
        }, 'contact-messages.csv', ['Content-Type' => 'text/csv; charset=UTF-8']);
    }

    /**
     * Write a semicolon-separated row, neutralising values that spreadsheet apps would run as formulas.
     *
     * @param  resource  $output
     * @param  array<int, string>  $values
     */
    private function writeRow($output, array $values): void
    {
        $values = array_map(fn (string $value) => preg_match('/^[=+\-@\t\r]/', $value) ? "'".$value : $value, $values);

        fputcsv($output, $values, ';', '"', '', "\r\n");
    }
}
