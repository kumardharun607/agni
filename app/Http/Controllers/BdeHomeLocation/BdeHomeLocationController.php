<?php

namespace App\Http\Controllers\BdeHomeLocation;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BdeHomeLocation;
use Illuminate\Support\Facades\DB;

class BdeHomeLocationController extends Controller
{
    public function index()
    {
        $bdeHomeLocations = BdeHomeLocation::latest()
            ->paginate(10);

        return view(
            'bde-home-locations.index',
            compact('bdeHomeLocations')
        );
    }

    public function create()
    {
        return view('bde-home-locations.create');
    }

    public function store(Request $request)
    {
        DB::beginTransaction();

        try{

            BdeHomeLocation::create($request->validated());

            DB::commit();

            return redirect()
                ->route('bde-home-locations.index')
                ->with(
                    'success',
                    'BDE Home Location Created Successfully'
                );

        }catch(\Exception $e){

            DB::rollBack();

            return back()
                ->with('error',$e->getMessage())
                ->withInput();

        }
    }

    public function show(BdeHomeLocation $bdeHomeLocation)
    {
        return view(
            'bde-home-locations.show',
            compact('bdeHomeLocation')
        );
    }

    public function edit(BdeHomeLocation $bdeHomeLocation)
    {
        return view(
            'bde-home-locations.edit',
            compact('bdeHomeLocation')
        );
    }

    public function update(
        Request $request,
        BdeHomeLocation $bdeHomeLocation
    )
    {
        DB::beginTransaction();

        try{

            $bdeHomeLocation->update(
                $request->validated()
            );

            DB::commit();

            return redirect()
                ->route('bde-home-locations.index')
                ->with(
                    'success',
                    'BDE Home Location Updated Successfully'
                );

        }catch(\Exception $e){

            DB::rollBack();

            return back()
                ->with('error',$e->getMessage())
                ->withInput();

        }
    }

    public function destroy(BdeHomeLocation $bdeHomeLocation)
    {
        try {

            $bdeHomeLocation->delete();

            return response()->json([

                'success' => true, 'status' => true,

                'message' => 'BDE Home Location Deleted Successfully'

            ]);

        } catch (\Exception $e) {

            return response()->json([

                'status' => false,

                'message' => 'This BDE Home Location cannot be deleted as it is linked with other records.'

            ], 422);

        }
    }


    private function rules(?int $id = null): array
    {
        return [
            'bde_id' => ['required', 'string', 'max:100'],
            'home_lat' => ['required', 'numeric', 'between:-90,90'],
            'home_long' => ['required', 'numeric', 'between:-180,180'],
            'home_address' => ['required', 'string'],
        ];
    }
}
