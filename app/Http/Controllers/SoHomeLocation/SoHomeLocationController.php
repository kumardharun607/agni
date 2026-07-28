<?php

namespace App\Http\Controllers\SoHomeLocation;

use App\Http\Controllers\Controller;
use App\Http\Requests\SoHomeLocation\StoreSoHomeLocationRequest;
use App\Http\Requests\SoHomeLocation\UpdateSoHomeLocationRequest;
use App\Models\SoHomeLocation;
use Illuminate\Support\Facades\DB;

class SoHomeLocationController extends Controller
{
    public function index()
    {
        $soHomeLocations = SoHomeLocation::latest()
            ->paginate(10);

        return view(
            'so-home-locations.index',
            compact('soHomeLocations')
        );
    }

    public function create()
    {
        return view('so-home-locations.create');
    }

    public function store(StoreSoHomeLocationRequest $request)
    {
        DB::beginTransaction();

        try {

            SoHomeLocation::create(
                $request->validated()
            );

            DB::commit();

            return redirect()
                ->route('so-home-locations.index')
                ->with(
                    'success',
                    'SO Home Location Created Successfully'
                );

        } catch (\Exception $e) {

            DB::rollBack();

            return back()
                ->withInput()
                ->with(
                    'error',
                    $e->getMessage()
                );
        }
    }

    public function show(SoHomeLocation $soHomeLocation)
    {
        return view(
            'so-home-locations.show',
            compact('soHomeLocation')
        );
    }

    public function edit(SoHomeLocation $soHomeLocation)
    {
        return view(
            'so-home-locations.edit',
            compact('soHomeLocation')
        );
    }

    public function update(
        UpdateSoHomeLocationRequest $request,
        SoHomeLocation $soHomeLocation
    ) {

        DB::beginTransaction();

        try {

            $soHomeLocation->update(
                $request->validated()
            );

            DB::commit();

            return redirect()
                ->route('so-home-locations.index')
                ->with(
                    'success',
                    'SO Home Location Updated Successfully'
                );

        } catch (\Exception $e) {

            DB::rollBack();

            return back()
                ->withInput()
                ->with(
                    'error',
                    $e->getMessage()
                );
        }
    }

    public function destroy(SoHomeLocation $soHomeLocation)
    {
        try {

            $soHomeLocation->delete();

            return response()->json([
                'success' => true, 'status' => true,
                'message' => 'SO Home Location Deleted Successfully'
            ]);

        } catch (\Exception $e) {

            return response()->json([
                'status' => false,
                'message' => 'This SO Home Location cannot be deleted as it is linked with other records.'
            ], 422);

        }
    }
}
