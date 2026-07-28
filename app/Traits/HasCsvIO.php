<?php

namespace App\Traits;

use Illuminate\Http\UploadedFile;
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\StreamedResponse;

/**
 * Shared Import / Export helpers used by Masters controllers.
 * Supports CSV and Excel (.xlsx/.xls) for import.
 */
trait HasCsvIO
{
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
     * Read CSV or Excel into associative rows keyed by original header labels.
     *
     * @return array<int, array<string, string>>
     */
    protected function readCsv(UploadedFile $file): array
    {
        return $this->readSpreadsheet($file);
    }

    /**
     * Parse uploaded CSV / XLSX / XLS into rows keyed by header name.
     *
     * @return array<int, array<string, string>>
     *
     * @throws ValidationException
     */
    protected function readSpreadsheet(UploadedFile $file, array $requiredHeaders = []): array
    {
        $ext = strtolower($file->getClientOriginalExtension());

        try {
            if (in_array($ext, ['xlsx', 'xls'], true)) {
                $sheets = Excel::toArray(null, $file);
                if (empty($sheets) || empty($sheets[0])) {
                    throw ValidationException::withMessages([
                        'file' => 'The uploaded Excel file is empty or invalid.',
                    ]);
                }
                $raw = $sheets[0];
                $header = array_map(fn ($h) => trim((string) $h), array_shift($raw) ?: []);
                if ($header === [] || (count($header) === 1 && $header[0] === '')) {
                    throw ValidationException::withMessages([
                        'file' => 'The uploaded file has no header row. Please use a valid template.',
                    ]);
                }
                $rows = [];
                foreach ($raw as $data) {
                    // skip fully empty rows
                    if (collect($data)->filter(fn ($v) => $v !== null && $v !== '')->isEmpty()) {
                        continue;
                    }
                    // pad/truncate to header length
                    $data = array_pad(array_slice($data, 0, count($header)), count($header), null);
                    $rows[] = array_combine($header, array_map(fn ($v) => $v === null ? '' : (string) $v, $data));
                }
            } else {
                $rows = [];
                $handle = fopen($file->getRealPath(), 'r');
                if ($handle === false) {
                    throw ValidationException::withMessages([
                        'file' => 'Unable to read the uploaded file.',
                    ]);
                }
                $header = fgetcsv($handle);
                if (! $header) {
                    fclose($handle);
                    throw ValidationException::withMessages([
                        'file' => 'The uploaded file has no header row. Please use a valid template.',
                    ]);
                }
                $header = array_map(fn ($h) => trim((string) $h), $header);
                while (($data = fgetcsv($handle)) !== false) {
                    if (collect($data)->filter(fn ($v) => $v !== null && $v !== '')->isEmpty()) {
                        continue;
                    }
                    $data = array_pad(array_slice($data, 0, count($header)), count($header), '');
                    $rows[] = array_combine($header, $data);
                }
                fclose($handle);
            }
        } catch (ValidationException $e) {
            throw $e;
        } catch (\Throwable $e) {
            throw ValidationException::withMessages([
                'file' => 'Invalid file format. Please upload a valid CSV or Excel file with the correct columns.',
            ]);
        }

        if ($requiredHeaders !== []) {
            $this->assertRequiredHeaders($header ?? [], $requiredHeaders);
        }

        return $rows;
    }

    /**
     * @param  array<int, string>  $headerKeys
     * @param  array<int, string|array<int, string>>  $requiredHeaders
     */
    protected function assertRequiredHeaders(array $headerKeys, array $requiredHeaders): void
    {
        $normalized = array_map(fn ($k) => strtolower(trim((string) $k)), $headerKeys);
        $missing = [];
        foreach ($requiredHeaders as $need) {
            $found = false;
            foreach ((array) $need as $alias) {
                if (in_array(strtolower((string) $alias), $normalized, true)) {
                    $found = true;
                    break;
                }
            }
            if (! $found) {
                $missing[] = is_array($need) ? $need[0] : $need;
            }
        }

        if ($missing !== []) {
            throw ValidationException::withMessages([
                'file' => 'Invalid column names. Missing required column(s): '.implode(', ', $missing).'. Please download a sample export and use the same headers.',
            ]);
        }
    }

    protected function csvValue(array $row, string $key): ?string
    {
        foreach ($row as $k => $v) {
            if (strcasecmp((string) $k, $key) === 0) {
                $v = is_string($v) ? trim($v) : $v;
                return ($v === '' || $v === null) ? null : (string) $v;
            }
        }

        return null;
    }
}
