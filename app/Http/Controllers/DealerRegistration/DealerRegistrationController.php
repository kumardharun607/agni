<?php

namespace App\Http\Controllers\DealerRegistration;
use App\Http\Controllers\Controller;
use App\Exports\DealerRegistrationsExport;
use App\Http\Requests\DealerRegistrationRequest;
use App\Imports\DealerRegistrationsImport;
use App\Models\Brand;
use App\Models\DealerRegistration;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Validators\ValidationException;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class DealerRegistrationController extends Controller
{
    /**
     * Static option lists shared between the create/edit form, the show
     * page, the PDF, the Form Request rules and the DataTable labels.
     */
    public static function states(): array
    {
        return [
            'TN' => 'TamilNadu',
            'KE' => 'Kerala',
            'AP' => 'Andra',
            'KA' => 'Karnataka',
        ];
    }

    public static function dealerTypes(): array
    {
        return ['Main dealer', 'sub dealer', 'Nil'];
    }

    public static function ownRentOptions(): array
    {
        return ['own shop' => 'Own Shop', 'rent shop' => 'Rental Shop'];
    }

    public static function accountTypes(): array
    {
        return ['Savings', 'Current'];
    }

    public static function firmStatuses(): array
    {
        return ['Proprietorship', 'Partnership', 'Private Ltd.Co.'];
    }

    /**
     * The "OTHERS" business checkbox group -> other_business (CSV).
     */
    public static function otherBusinessOptions(): array
    {
        return ['HARDWARE', 'ELECTRICAL', 'PAINTS', 'STRUCTURAL', 'OTHERS'];
    }

    public static function statusOptions(): array
    {
        return ['Pending', 'Approved', 'Rejected'];
    }

    public static function establishedYears(): array
    {
        $currentYear = (int) date('Y');

        return range($currentYear, $currentYear - 60);
    }

    /**
     * Directions used for the "Nearby Agni Dealers" single card, and their
     * exact DB column mapping (dealer name / dealer type / kms / ton-month).
     */
    public static function nearbyDirections(): array
    {
        return [
            ['label' => 'EAST', 'name' => 'east', 'sub' => 'sub_1', 'dist' => 'e_dist', 'ton' => 'other1'],
            ['label' => 'WEST', 'name' => 'west', 'sub' => 'sub_2', 'dist' => 'w_dist', 'ton' => 'other2'],
            ['label' => 'SOUTH', 'name' => 'south', 'sub' => 'sub_3', 'dist' => 's_dist', 'ton' => 'other3'],
            ['label' => 'NORTH', 'name' => 'north', 'sub' => 'sub_4', 'dist' => 'n_dist', 'ton' => 'other4'],
        ];
    }

    public function index(): View
    {
        abort_unless(userCan('Dealer Registration', 'view'), 403);

        return view('dealer-registrations.index');
    }

    public function create(): View
    {
        abort_unless(userCan('Dealer Registration', 'add'), 403);

        return view('dealer-registrations.form', [
            'dealer' => new DealerRegistration(),
            'brands' => Brand::orderBy('name')->pluck('name'),
        ]);
    }

    public function edit(DealerRegistration $dealerRegistration): View
    {
        abort_unless(userCan('Dealer Registration', 'edit'), 403);

        return view('dealer-registrations.form', [
            'dealer' => $dealerRegistration,
            'brands' => Brand::orderBy('name')->pluck('name'),
        ]);
    }

    /**
     * Canonical, read-only Show page. Full Agni sidebar/layout, no editable
     * inputs. Always available at /dealer-registrations/{id} regardless of
     * how it was reached (direct link, bookmark, or navigated from the list).
     */
    public function show(DealerRegistration $dealerRegistration): View
    {
        abort_unless(userCan('Dealer Registration', 'view'), 403);

        return view('dealer-registrations.show', [
            'dealer' => $dealerRegistration,
        ]);
    }

    public function datatable()
    {
        abort_unless(userCan('Dealer Registration', 'view'), 403);

        $dealers = DealerRegistration::query()->select([
            'id', 'apply_no', 'alias_id', 'n_of_firm', 'mobile_no',
            'manager_name', 'so_approved_name', 'admin_status', 'created_at',
        ]);

        return DataTables::eloquent($dealers)
            ->addIndexColumn()
            ->editColumn('apply_no', fn (DealerRegistration $d) => $d->application_no ?: '-')
            ->editColumn('alias_id', fn (DealerRegistration $d) => $d->alias_id ?: '-')
            ->editColumn('n_of_firm', fn (DealerRegistration $d) => $d->n_of_firm ?: '-')
            ->editColumn('mobile_no', fn (DealerRegistration $d) => $d->mobile_no ?: '-')
            ->editColumn('manager_name', fn (DealerRegistration $d) => $d->manager_name ?: '-')
            ->editColumn('so_approved_name', fn (DealerRegistration $d) => $d->so_approved_name ?: '-')
            ->editColumn('admin_status', function (DealerRegistration $d) {
                $status = $d->admin_status ?: 'Pending';
                $colors = [
                    'Approved' => 'bg-emerald-100 text-emerald-700',
                    'Rejected' => 'bg-red-100 text-red-700',
                    'Pending' => 'bg-amber-100 text-amber-700',
                ];
                $class = $colors[$status] ?? 'bg-slate-100 text-slate-600';
                return '<span class="inline-block rounded-full px-2.5 py-1 text-xs font-semibold '.$class.'">'.$status.'</span>';
            })
            ->addColumn('action', fn ($row) => view('dealer-registrations.partials.action', compact('row'))->render())
            ->rawColumns(['admin_status', 'action'])
            ->make(true);
    }


    public function store(DealerRegistrationRequest $request): RedirectResponse
    {
        abort_unless(userCan('Dealer Registration', 'add'), 403);

        $validated = $this->prepareData($request);

        $validated['photo_upload1'] = $this->storeImage($request, 'photo_upload1');
        $validated['photo_upload2'] = $this->storeImage($request, 'photo_upload2');

        // apply_id / serial_no / apply_no / manager_status / admin_status /
        // manager_name are never posted from the form (excluded per spec),
        // they are generated / defaulted here instead.
        [$validated['apply_id'], $validated['serial_no'], $validated['apply_no']] = $this->generateApplicationNumbers($validated['state_wise']);
        $validated['admin_status'] = 'Pending';

        DealerRegistration::create($validated);

        return redirect()
            ->route('dealer-registrations.index')
            ->with('success', 'Dealer registration created successfully.');
    }

    public function update(DealerRegistrationRequest $request, DealerRegistration $dealerRegistration): RedirectResponse
    {
        abort_unless(userCan('Dealer Registration', 'edit'), 403);

        $validated = $this->prepareData($request);

        if ($request->hasFile('photo_upload1')) {
            $validated['photo_upload1'] = $this->storeImage($request, 'photo_upload1', $dealerRegistration->photo_upload1);
        } else {
            unset($validated['photo_upload1']);
        }

        if ($request->hasFile('photo_upload2')) {
            $validated['photo_upload2'] = $this->storeImage($request, 'photo_upload2', $dealerRegistration->photo_upload2);
        } else {
            unset($validated['photo_upload2']);
        }

        // apply_id / serial_no / apply_no / manager_status / admin_status /
        // manager_name are excluded from the edit form and therefore left
        // untouched on update.
        $dealerRegistration->update($validated);

        return redirect()
            ->route('dealer-registrations.index')
            ->with('success', 'Dealer registration updated successfully.');
    }

    public function destroy(DealerRegistration $dealerRegistration): JsonResponse
    {
        abort_unless(userCan('Dealer Registration', 'delete'), 403);

        $dealerRegistration->delete(); // soft delete only

        return response()->json([
            'success' => true,
            'message' => 'Dealer registration deleted successfully.',
        ]);
    }

    public function export()
    {
        abort_unless(userCan('Dealer Registration', 'export'), 403);

        return Excel::download(new DealerRegistrationsExport, 'dealer-registrations.xlsx');
    }

    /**
     * Two-page Dealer Registration PDF with the Agni logo, generated with
     * DomPDF via barryvdh/laravel-dompdf.
     */
    public function pdf(DealerRegistration $dealerRegistration)
    {
        abort_unless(userCan('Dealer Registration', 'view'), 403);

        // Optional DomPDF package; otherwise open printable HTML view.
        if (class_exists(\Barryvdh\DomPDF\Facade\Pdf::class)) {
            $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('dealer-registrations.pdf', [
                'dealer' => $dealerRegistration,
                'directions' => self::nearbyDirections(),
            ])->setPaper('a4', 'portrait');
            $filename = 'dealer-registration-' . ($dealerRegistration->apply_no ?: $dealerRegistration->id) . '.pdf';
            return $pdf->stream($filename);
        }

        return view('dealer-registrations.show', [
            'dealer' => $dealerRegistration,
            'print' => true,
        ]);
    }

    /**
     * Normalises the validated Form Request payload: checkbox arrays are
     * imploded into the CSV strings the database columns actually store.
     */
    private function prepareData(DealerRegistrationRequest $request): array
    {
        $validated = $request->validated();

        $validated['type_of_ac'] = implode(',', $validated['type_of_ac'] ?? []);
        $validated['status_of_firm'] = implode(',', $validated['status_of_firm'] ?? []);
        $validated['other_business'] = implode(',', $validated['other_business'] ?? []);

        return $validated;
    }

    /**
     * Stores an uploaded image on the public disk under dealers/, removing
     * the previous file (on update) if one existed. Returns the relative
     * path to save on the model, or null if no new file was uploaded.
     */
    private function storeImage(Request $request, string $field, ?string $previous = null): ?string
    {
        if (!$request->hasFile($field)) {
            return $previous;
        }

        if ($previous) {
            Storage::disk('public')->delete($previous);
        }

        return $request->file($field)->store('dealers', 'public');
    }

    /**
     * Replicates the legacy state-based sequential numbering: each state
     * gets its own running serial number, and the apply number combines
     * the state code with that serial.
     */
    private function generateApplicationNumbers(string $stateCode): array
    {
        $lastSerial = DealerRegistration::where('state_wise', $stateCode)
            ->withTrashed()
            ->max('serial_no');

        $nextSerial = ((int) $lastSerial) + 1;

        $applyId = 'ASPL';
        $applyNo = $stateCode . '-' . str_pad((string) $nextSerial, 4, '0', STR_PAD_LEFT);

        return [$applyId, (string) $nextSerial, $applyNo];
    }

    public function importForm()
    {
        abort_unless(userCan('Dealer Registration', 'import') || userCan('Dealer Registration', 'add'), 403);
        return view('dealer-registrations.import');
    }

    public function import(Request $request)
    {
        abort_unless(
            $request->user()->can('import dealer registrations'),
            403
        );

        $request->validate([
            'file' => [
                'required',
                'file',
                'mimes:xlsx,xls,csv',
                'max:10240',
            ],
        ]);

        $import = new DealerRegistrationsImport();

        try {

            Excel::import($import, $request->file('file'));

            $failures = [];

            foreach ($import->failures() as $failure) {

                $failures[] = [
                    'row' => $failure->row(),
                    'attribute' => $failure->attribute(),
                    'errors' => $failure->errors(),
                ];

            }

            if (count($failures) > 0) {

                return response()->json([
                    'success' => true,
                    'message' => 'Import finished: valid rows were saved, but ' . count($failures) . ' row(s) were skipped due to validation errors.',
                    'failures' => $failures,
                ]);

            }

            return response()->json([
                'success' => true,
                'message' => 'Dealer registrations imported successfully.',
            ]);

        } catch (\Throwable $e) {

            report($e);

            return response()->json([
                'success' => false,
                'message' => 'Unable to import dealer registrations.',
            ], 500);
        }
    }
}
