<?php

namespace App\Http\Controllers\ScrapSeller;

use App\Http\Controllers\Controller;
use App\Http\Requests\ScrapSeller\StoreScrapSellerRequest;
use App\Http\Requests\ScrapSeller\UpdateScrapSellerRequest;
use App\Models\ScrapSeller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ScrapSellerController extends Controller
{
    public function index()
    {
        $scrapSellers = ScrapSeller::latest()
            ->paginate(10);

        return view('scrap-sellers.index', compact('scrapSellers'));
    }

    public function create()
    {
        return view('scrap-sellers.create');
    }

    public function store(StoreScrapSellerRequest $request)
    {
        DB::beginTransaction();

        try {

            $data = $request->validated();

            if ($request->hasFile('shop_image')) {
                $data['shop_image'] = $request->file('shop_image')
                    ->store('scrap-sellers/shop-images', 'public');
            }

            if ($request->hasFile('godown_image')) {
                $data['godown_image'] = $request->file('godown_image')
                    ->store('scrap-sellers/godown-images', 'public');
            }

            if ($request->hasFile('pancard_image')) {
                $data['pancard_image'] = $request->file('pancard_image')
                    ->store('scrap-sellers/pancard-images', 'public');
            }

            if ($request->hasFile('aadhar_front_image')) {
                $data['aadhar_front_image'] = $request->file('aadhar_front_image')
                    ->store('scrap-sellers/aadhar-front', 'public');
            }

            if ($request->hasFile('aadhar_back_image')) {
                $data['aadhar_back_image'] = $request->file('aadhar_back_image')
                    ->store('scrap-sellers/aadhar-back', 'public');
            }

            if ($request->hasFile('reg_certificate_image')) {
                $data['reg_certificate_image'] = $request->file('reg_certificate_image')
                    ->store('scrap-sellers/reg-certificate', 'public');
            }

            ScrapSeller::create($data);

            DB::commit();

            return redirect()
                ->route('scrap-sellers.index')
                ->with('success', 'Scrap Seller Created Successfully');

        } catch (\Exception $e) {

            DB::rollBack();

            return back()
                ->withInput()
                ->with('error', $e->getMessage());
        }
    }

    public function show(ScrapSeller $scrapSeller)
    {
        return view('scrap-sellers.show', compact('scrapSeller'));
    }

    public function edit(ScrapSeller $scrapSeller)
    {
        return view('scrap-sellers.edit', compact('scrapSeller'));
    }

    public function update(UpdateScrapSellerRequest $request, ScrapSeller $scrapSeller)
    {
        DB::beginTransaction();

        try {

            $data = $request->validated();

            if ($request->hasFile('shop_image')) {

                if ($scrapSeller->shop_image) {
                    Storage::disk('public')->delete($scrapSeller->shop_image);
                }

                $data['shop_image'] = $request->file('shop_image')
                    ->store('scrap-sellers/shop-images', 'public');
            }

            if ($request->hasFile('godown_image')) {

                if ($scrapSeller->godown_image) {
                    Storage::disk('public')->delete($scrapSeller->godown_image);
                }

                $data['godown_image'] = $request->file('godown_image')
                    ->store('scrap-sellers/godown-images', 'public');
            }

            if ($request->hasFile('pancard_image')) {

                if ($scrapSeller->pancard_image) {
                    Storage::disk('public')->delete($scrapSeller->pancard_image);
                }

                $data['pancard_image'] = $request->file('pancard_image')
                    ->store('scrap-sellers/pancard-images', 'public');
            }

            if ($request->hasFile('aadhar_front_image')) {

                if ($scrapSeller->aadhar_front_image) {
                    Storage::disk('public')->delete($scrapSeller->aadhar_front_image);
                }

                $data['aadhar_front_image'] = $request->file('aadhar_front_image')
                    ->store('scrap-sellers/aadhar-front', 'public');
            }

            if ($request->hasFile('aadhar_back_image')) {

                if ($scrapSeller->aadhar_back_image) {
                    Storage::disk('public')->delete($scrapSeller->aadhar_back_image);
                }

                $data['aadhar_back_image'] = $request->file('aadhar_back_image')
                    ->store('scrap-sellers/aadhar-back', 'public');
            }

            if ($request->hasFile('reg_certificate_image')) {

                if ($scrapSeller->reg_certificate_image) {
                    Storage::disk('public')->delete($scrapSeller->reg_certificate_image);
                }

                $data['reg_certificate_image'] = $request->file('reg_certificate_image')
                    ->store('scrap-sellers/reg-certificate', 'public');
            }

            $scrapSeller->update($data);

            DB::commit();

            return redirect()
                ->route('scrap-sellers.index')
                ->with('success', 'Scrap Seller Updated Successfully');

        } catch (\Exception $e) {

            DB::rollBack();

            return back()
                ->withInput()
                ->with('error', $e->getMessage());
        }
    }

    public function destroy(ScrapSeller $scrapSeller)
    {
        try {

            if ($scrapSeller->shop_image) {
                Storage::disk('public')->delete($scrapSeller->shop_image);
            }

            if ($scrapSeller->godown_image) {
                Storage::disk('public')->delete($scrapSeller->godown_image);
            }

            if ($scrapSeller->pancard_image) {
                Storage::disk('public')->delete($scrapSeller->pancard_image);
            }

            if ($scrapSeller->aadhar_front_image) {
                Storage::disk('public')->delete($scrapSeller->aadhar_front_image);
            }

            if ($scrapSeller->aadhar_back_image) {
                Storage::disk('public')->delete($scrapSeller->aadhar_back_image);
            }

            if ($scrapSeller->reg_certificate_image) {
                Storage::disk('public')->delete($scrapSeller->reg_certificate_image);
            }

            $scrapSeller->delete();

            return response()->json([
                'status' => true,
                'message' => 'Scrap Seller Deleted Successfully'
            ]);

        } catch (\Exception $e) {

            return response()->json([
                'status' => false,
                'message' => 'This scrap seller cannot be deleted as it is linked with other records.'
            ], 422);

        }
    }
}