<?php

namespace App\Http\Controllers\Dealer;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Country;
use App\Models\Dealer;
use App\Models\Pincode;
use App\Models\State;
use App\Traits\HasCsvIO;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class DealerController extends Controller
{
    use HasCsvIO;

    

    public function index()
    {
        return view('dealers.index');
    }

    public function data()
    {
        return DataTables::of(Dealer::with('parentDealer'))
            ->addIndexColumn()
            ->addColumn('client_type_label', fn ($row) => $row->typeLabel())
            ->addColumn('parent_dealer_name', fn ($row) => $row->parentDealer->name ?? '-')
            // Change 5: "View Map" column — a map-pin icon that opens the dealer's
            // latitude/longitude on Google Maps in a new tab. No coordinates saved
            // yet -> the icon renders disabled/greyed out.
            ->addColumn('view_map', fn ($row) => view('dealers.columns.view_map', compact('row'))->render())
            ->addColumn('action', fn ($row) => view('dealers.partials.action', compact('row'))->render())
            ->rawColumns(['view_map', 'action'])
            ->make(true);
    }

    public function create()
    {
        $countries = Country::orderBy('name')->get();
        $parentDealers = $this->service->getParentCandidates();

        return view('dealers.create', compact('countries', 'parentDealers'));
    }

    public function store(Request $request)
    {
        $data = $request->validated();

        // if same-as-mobile checkbox ticked, mirror mobile into whatsapp_number
        if ($request->boolean('same_as_mobile')) {
            $data['whatsapp_number'] = $data['mobile'];
        }

        // client_type 1 (existing) / 2 (new) never have a parent -> force null
        if ((int) $data['client_type'] !== Dealer::TYPE_SUB) {
            $data['parent_dealer_id'] = null;
        }

        $data['alias_id'] = Dealer::generateAliasId((int) $data['client_type']);

        Dealer::create($data);

        if ($request->expectsJson()) {
            return response()->json(['success' => true, 'message' => 'Dealer created successfully.', 'redirect' => route('dealers.index')]);
        }

        return redirect()->route('dealers.index')->with('success', 'Dealer created successfully.');
    }

    public function edit(Dealer $dealer)
    {
        $countries = Country::orderBy('name')->get();
        $parentDealers = $this->service->getParentCandidates($dealer->id);

        return view('dealers.edit', compact('dealer', 'countries', 'parentDealers'));
    }

    // Change 6: read-only view — same edit layout, but rendered non-editable.
    public function show(Dealer $dealer)
    {
        $countries = Country::orderBy('name')->get();
        $parentDealers = $this->service->getParentCandidates($dealer->id);

        return view('dealers.edit', [
            'dealer' => $dealer,
            'countries' => $countries,
            'parentDealers' => $parentDealers,
            'readonly' => true,
        ]);
    }

    public function update(Request $request, Dealer $dealer)
    {
        $data = $request->validated();

        if ($request->boolean('same_as_mobile')) {
            $data['whatsapp_number'] = $data['mobile'];
        }

        if ((int) $data['client_type'] !== Dealer::TYPE_SUB) {
            $data['parent_dealer_id'] = null;
        }

        // alias_id / client_type prefix never changes on edit once generated
        $this->service->update($dealer->id, $data);

        if ($request->expectsJson()) {
            return response()->json(['success' => true, 'message' => 'Dealer updated successfully.', 'redirect' => route('dealers.index')]);
        }

        return redirect()->route('dealers.index')->with('success', 'Dealer updated successfully.');
    }

    public function destroy(Dealer $dealer)
    {
        $dealer->delete();

        return response()->json(['success' => true]);
    }

    public function importForm()
    {
        return view('dealers.import');
    }

    public function export()
    {
        return \Maatwebsite\Excel\Facades\Excel::download(
            new \App\Exports\DealerExport,
            'dealers.xlsx'
        );
    }

    public function import(Request $request)
    {
        $request->validate(['file' => 'required|file|mimes:csv,txt,xlsx,xls']);
        $rows = $this->readCsv($request->file('file'));

        $typeByLabel = array_flip(Dealer::TYPE_LABELS);
        $count = 0;

        foreach ($rows as $row) {
            $name = $this->csvValue($row, 'Name');
            $mobile = $this->csvValue($row, 'Mobile');
            if (! $name || ! $mobile) {
                continue;
            }

            $typeLabel = $this->csvValue($row, 'Type') ?? 'New Dealer';
            $clientType = $typeByLabel[$typeLabel] ?? Dealer::TYPE_NEW;

            $country = ($n = $this->csvValue($row, 'Country')) ? Country::firstOrCreate(['name' => $n]) : null;
            $state = ($n = $this->csvValue($row, 'State')) ? State::where('name', $n)->first() : null;
            $city = ($n = $this->csvValue($row, 'City')) ? City::where('name', $n)->first() : null;
            $pincode = ($n = $this->csvValue($row, 'Pincode')) ? Pincode::where('pincode', $n)->first() : null;

            Dealer::updateOrCreate(
                ['mobile' => $mobile],
                [
                    'name' => $name,
                    'client_type' => $clientType,
                    'contact_person' => $this->csvValue($row, 'Contact Person'),
                    'email' => $this->csvValue($row, 'Email'),
                    'gst_no' => $this->csvValue($row, 'GST No'),
                    'pan_no' => $this->csvValue($row, 'PAN No'),
                    'country_id' => $country?->id,
                    'state_id' => $state?->id,
                    'city_id' => $city?->id,
                    'pincode_id' => $pincode?->id,
                    'address' => $this->csvValue($row, 'Address'),
                    'alias_id' => Dealer::where('mobile', $mobile)->value('alias_id') ?? Dealer::generateAliasId($clientType),
                ]
            );
            $count++;
        }

        $message = "$count dealers imported successfully.";
        if ($request->expectsJson()) {
            return response()->json(['success' => true, 'message' => $message]);
        }
        return redirect()->route('dealers.index')->with('success', $message);
    }

    // AJAX: cascading dropdowns
    public function statesByCountry(Country $country)
    {
        return response()->json($this->stateService->getByCountry($country->id));
    }

    public function citiesByState(State $state)
    {
        return response()->json($this->cityService->getByState($state->id));
    }

    public function pincodesByCity(City $city)
    {
        return response()->json($this->pincodeService->getByCity($city->id));
    }


    private function rules(?int $id = null): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'client_type' => ['required', 'in:1,2,3'],
            'parent_dealer_id' => ['nullable', 'required_if:client_type,3', 'exists:dealers,id'],
            'designation' => ['nullable', 'string', 'max:255'],
            'contact_person' => ['nullable', 'string', 'max:255'],
            'mobile' => ['required', 'string', 'max:15'],
            'alternate_mobile' => ['nullable', 'string', 'max:15'],
            'whatsapp_number' => ['nullable', 'string', 'max:15'],
            'email' => ['nullable', 'email', 'max:255'],
            'gst_no' => ['nullable', 'string', 'max:20'],
            'pan_no' => ['nullable', 'string', 'max:20'],
            'credit_limit' => ['nullable', 'numeric'],
            'payment_terms' => ['nullable', 'string', 'max:255'],
            'country_id' => ['nullable', 'exists:countries,id'],
            'state_id' => ['nullable', 'exists:states,id'],
            'city_id' => ['nullable', 'exists:cities,id'],
            'pincode_id' => ['nullable', 'exists:pincodes,id'],
            'address' => ['nullable', 'string'],
            'latitude' => ['nullable', 'numeric'],
            'longitude' => ['nullable', 'numeric'],
        ];
    }
}
