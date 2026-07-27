<?php

namespace App\Traits;

use Illuminate\Http\UploadedFile;
use Symfony\Component\HttpFoundation\StreamedResponse;

/**
 * Dependency-free "Import Excel / Export Excel" support used by every Masters
 * controller. Works with plain .csv (which Excel opens natively) so no extra
 * composer package is required.
 */
trait HasCsvIO
{
    /**
     * Stream a CSV file to the browser as a download.
     *
     * @param  string          $filename
     * @param  array           $headers   column headers, e.g. ['ID','Name','Code']
     * @param  iterable<array> $rows      each row is a plain array matching $headers
     */
    protected function streamCsv(string $filename, array $headers, iterable $rows): StreamedResponse
    {
        return response()->streamDownload(function () use ($headers, $rows) {
            $out = fopen('php://output', 'w');
            fputcsv($out, $headers);
            foreach ($rows as $row) {
                fputcsv($out, $row);
            }
            fclose($out);
        }, $filename, [
            'Content-Type' => 'text/csv; charset=UTF-8',
        ]);
    }

    /**
     * Parse an uploaded CSV into an array of associative rows keyed by header name.
     *
     * @return array<int, array<string, string>>
     */
    protected function readCsv(UploadedFile $file): array
    {
        $rows = [];
        $handle = fopen($file->getRealPath(), 'r');
        $header = fgetcsv($handle);

        if ($header) {
            // normalise header names: trim + collapse case so "Name" / "name" both work
            $header = array_map(fn ($h) => trim((string) $h), $header);

            while (($data = fgetcsv($handle)) !== false) {
                if (count($data) !== count($header)) {
                    continue; // skip malformed rows rather than fail the whole import
                }
                $rows[] = array_combine($header, $data);
            }
        }

        fclose($handle);

        return $rows;
    }

    /**
     * Case-insensitive lookup of a value from a parsed CSV row.
     */
    protected function csvValue(array $row, string $key): ?string
    {
        foreach ($row as $k => $v) {
            if (strcasecmp($k, $key) === 0) {
                return $v !== '' ? $v : null;
            }
        }

        return null;
    }
}
