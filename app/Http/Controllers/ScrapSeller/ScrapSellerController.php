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
                $data['shop_image'] = $this->storePublicImage($request->file('shop_image'), 'shop-images');
            }

            if ($request->hasFile('godown_image')) {
                $data['godown_image'] = $this->storePublicImage($request->file('godown_image'), 'godown-images');
            }

            if ($request->hasFile('pancard_image')) {
                $data['pancard_image'] = $this->storePublicImage($request->file('pancard_image'), 'pancard-images');
            }

            if ($request->hasFile('aadhar_front_image')) {
                $data['aadhar_front_image'] = $this->storePublicImage($request->file('aadhar_front_image'), 'aadhar-front');
            }

            if ($request->hasFile('aadhar_back_image')) {
                $data['aadhar_back_image'] = $this->storePublicImage($request->file('aadhar_back_image'), 'aadhar-back');
            }

            if ($request->hasFile('reg_certificate_image')) {
                $data['reg_certificate_image'] = $this->storePublicImage($request->file('reg_certificate_image'), 'reg-certificate');
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
                    $this->deletePublicImage($scrapSeller->shop_image);
                }

                $data['shop_image'] = $this->storePublicImage($request->file('shop_image'), 'shop-images');
            }

            if ($request->hasFile('godown_image')) {

                if ($scrapSeller->godown_image) {
                    $this->deletePublicImage($scrapSeller->godown_image);
                }

                $data['godown_image'] = $this->storePublicImage($request->file('godown_image'), 'godown-images');
            }

            if ($request->hasFile('pancard_image')) {

                if ($scrapSeller->pancard_image) {
                    $this->deletePublicImage($scrapSeller->pancard_image);
                }

                $data['pancard_image'] = $this->storePublicImage($request->file('pancard_image'), 'pancard-images');
            }

            if ($request->hasFile('aadhar_front_image')) {

                if ($scrapSeller->aadhar_front_image) {
                    $this->deletePublicImage($scrapSeller->aadhar_front_image);
                }

                $data['aadhar_front_image'] = $this->storePublicImage($request->file('aadhar_front_image'), 'aadhar-front');
            }

            if ($request->hasFile('aadhar_back_image')) {

                if ($scrapSeller->aadhar_back_image) {
                    $this->deletePublicImage($scrapSeller->aadhar_back_image);
                }

                $data['aadhar_back_image'] = $this->storePublicImage($request->file('aadhar_back_image'), 'aadhar-back');
            }

            if ($request->hasFile('reg_certificate_image')) {

                if ($scrapSeller->reg_certificate_image) {
                    $this->deletePublicImage($scrapSeller->reg_certificate_image);
                }

                $data['reg_certificate_image'] = $this->storePublicImage($request->file('reg_certificate_image'), 'reg-certificate');
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


    /**
     * Store upload under public/uploads so it is web-accessible without storage:link.
     */
    private function storePublicImage($file, string $folder): string
    {
        $dir = public_path('uploads/scrap-sellers/' . $folder);
        if (! is_dir($dir)) {
            mkdir($dir, 0755, true);
        }
        $name = uniqid('ss_', true) . '.' . $file->getClientOriginalExtension();
        $file->move($dir, $name);

        return 'uploads/scrap-sellers/' . $folder . '/' . $name;
    }

    private function deletePublicImage(?string $path): void
    {
        if (! $path) {
            return;
        }
        $full = public_path($path);
        if (is_file($full)) {
            @unlink($full);
        }
        try {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($path);
        } catch (\Throwable $e) {
            // ignore
        }
    }

    public function destroy(ScrapSeller $scrapSeller)
    {
        try {
            foreach ([
                'shop_image', 'godown_image', 'pancard_image',
                'aadhar_front_image', 'aadhar_back_image', 'reg_certificate_image',
            ] as $field) {
                $this->deletePublicImage($scrapSeller->{$field} ?? null);
            }

            $scrapSeller->delete();

            return response()->json([
                'success' => true,
                'status' => true,
                'message' => 'Scrap Seller deleted successfully.',
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'status' => false,
                'message' => 'Unable to delete this Scrap Seller. Please try again.',
            ], 422);
        }
    }
}