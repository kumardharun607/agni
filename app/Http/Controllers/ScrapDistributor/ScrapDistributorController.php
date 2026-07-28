<?php

namespace App\Http\Controllers\ScrapDistributor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ScrapDistributor;
use App\Models\Country;
use App\Models\State;
use App\Models\City;
use App\Models\Pincode;
use Illuminate\Support\Facades\DB;

class ScrapDistributorController extends Controller
{
    public function index()
    {
        $scrapDistributors = ScrapDistributor::with([
            'country',
            'state',
            'city',
            'pincode'
        ])
        ->latest()
        ->paginate(10);

        return view('scrap-distributors.index', compact('scrapDistributors'));
    }

    public function create()
    {
        $countries = Country::orderBy('name')->get();

        $states = State::orderBy('name')->get();

        $cities = City::orderBy('name')->get();

        $pincodes = Pincode::orderBy('pincode')->get();

        return view('scrap-distributors.create', compact(
            'countries',
            'states',
            'cities',
            'pincodes'
        ));
    }

    public function store(Request $request)
    {
        DB::beginTransaction();

        try {

            $data = $request->validate($this->distributorRules());

            if ($request->hasFile('image')) {

                $data['image'] = $request->file('image')
                    ->store('scrap-distributors', 'public');
            }

            ScrapDistributor::create($data);

            DB::commit();

            return redirect()
                ->route('scrap-distributors.index')
                ->with('success', 'Scrap Distributor Created Successfully');

        } catch (\Exception $e) {

            DB::rollBack();

            return back()
                ->withInput()
                ->with('error', $e->getMessage());
        }
    }

    public function show(ScrapDistributor $scrapDistributor)
    {
        $scrapDistributor->load([
            'country',
            'state',
            'city',
            'pincode'
        ]);

        return view('scrap-distributors.show', compact('scrapDistributor'));
    }

    public function edit(ScrapDistributor $scrapDistributor)
    {
        $countries = Country::orderBy('name')->get();

        $states = State::orderBy('name')->get();

        $cities = City::orderBy('name')->get();

        $pincodes = Pincode::orderBy('pincode')->get();

        return view('scrap-distributors.edit', compact(
            'scrapDistributor',
            'countries',
            'states',
            'cities',
            'pincodes'
        ));
    }

    public function update(Request $request, ScrapDistributor $scrapDistributor)
    {
        DB::beginTransaction();

        try {

            $data = $request->validate($this->distributorRules());

            if ($request->hasFile('image')) {

                $data['image'] = $request->file('image')
                    ->store('scrap-distributors', 'public');
            }

            $scrapDistributor->update($data);

            DB::commit();

            return redirect()
                ->route('scrap-distributors.index')
                ->with('success', 'Scrap Distributor Updated Successfully');

        } catch (\Exception $e) {

            DB::rollBack();

            return back()
                ->withInput()
                ->with('error', $e->getMessage());
        }
    }

    public function destroy(ScrapDistributor $scrapDistributor)
    {
        try {

            $scrapDistributor->delete();

            return response()->json([
                'status' => true,
                'message' => 'Scrap Distributor Deleted Successfully'
            ]);

        } catch (\Exception $e) {

            return response()->json([
                'status' => false,
                'message' => 'This scrap distributor cannot be deleted as it is linked with other records.'
            ], 422);

        }
    }


    private function distributorRules(): array
    {
        return [
            'company_name' => ['required', 'string', 'max:255'],
            'owner_name' => ['nullable', 'string', 'max:255'],
            'mobile' => ['nullable', 'string', 'max:20'],
            'email' => ['nullable', 'email', 'max:255'],
            'address' => ['nullable', 'string'],
            'country_id' => ['nullable', 'exists:countries,id'],
            'state_id' => ['nullable', 'exists:states,id'],
            'city_id' => ['nullable', 'exists:cities,id'],
            'pincode_id' => ['nullable', 'exists:pincodes,id'],
            'latitude' => ['nullable', 'numeric'],
            'longitude' => ['nullable', 'numeric'],
        ];
    }
}
