<?php

namespace App\Http\Controllers\BdeHomeLocation;

use App\Http\Controllers\Controller;
use App\Http\Requests\BdeHomeLocation\StoreBdeHomeLocationRequest;
use App\Http\Requests\BdeHomeLocation\UpdateBdeHomeLocationRequest;
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

    public function store(StoreBdeHomeLocationRequest $request)
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
        UpdateBdeHomeLocationRequest $request,
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
}
