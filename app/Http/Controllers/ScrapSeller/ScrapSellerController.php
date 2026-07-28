<?php

namespace App\Http\Controllers\ScrapSeller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ScrapSeller;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class ScrapSellerController extends Controller
{
    /**
     * Image field => folder under public/uploads/
     */
    private array $imageFields = [
        'shop_image'            => 'uploads/scrap-sellers/shop-images',
        'godown_image'          => 'uploads/scrap-sellers/godown-images',
        'pancard_image'         => 'uploads/scrap-sellers/pancard-images',
        'aadhar_front_image'    => 'uploads/scrap-sellers/aadhar-front',
        'aadhar_back_image'     => 'uploads/scrap-sellers/aadhar-back',
        'reg_certificate_image' => 'uploads/scrap-sellers/reg-certificate',
    ];

    public function index()
    {
        $scrapSellers = ScrapSeller::latest()->paginate(10);

        return view('scrap-sellers.index', compact('scrapSellers'));
    }

    public function create()
    {
        return view('scrap-sellers.create');
    }

    public function store(Request $request)
    {
        DB::beginTransaction();

        try {
            $request->validate($this->sellerRules($request));
            $data = $request->safe()->except(array_keys($this->imageFields));

            foreach ($this->imageFields as $field => $folder) {
                if ($request->hasFile($field)) {
                    $data[$field] = $this->storeImage($request->file($field), $folder);
                }
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

    public function update(Request $request, ScrapSeller $scrapSeller)
    {
        DB::beginTransaction();

        try {
            $request->validate($this->sellerRules($request));
            $data = $request->safe()->except(array_keys($this->imageFields));

            foreach ($this->imageFields as $field => $folder) {
                if ($request->hasFile($field)) {
                    $this->deleteImage($scrapSeller->{$field});
                    $data[$field] = $this->storeImage($request->file($field), $folder);
                }
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
            foreach (array_keys($this->imageFields) as $field) {
                $this->deleteImage($scrapSeller->{$field});
            }

            $scrapSeller->delete();

            return response()->json([
                'status'  => true,
                'message' => 'Scrap Seller Deleted Successfully',
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status'  => false,
                'message' => 'This scrap seller cannot be deleted as it is linked with other records.',
            ], 422);
        }
    }

    /**
     * Store file under public/{folder}/ and return relative path for DB.
     */
    private function storeImage(UploadedFile $file, string $folder): string
    {
        $dir = public_path($folder);

        if (! File::isDirectory($dir)) {
            File::makeDirectory($dir, 0755, true);
        }

        $name = 'ss_' . uniqid() . '.' . $file->getClientOriginalExtension();
        $file->move($dir, $name);

        // e.g. uploads/scrap-sellers/shop-images/ss_xxx.jpg
        return $folder . '/' . $name;
    }

    /**
     * Delete image from public/ if path is set.
     */
    private function deleteImage(?string $path): void
    {
        if (empty($path)) {
            return;
        }

        $full = public_path(ltrim(str_replace('\\', '/', $path), '/'));

        if (File::exists($full) && File::isFile($full)) {
            File::delete($full);
        }
    }


    private function sellerRules($request): array
    {
        $id = optional($request->route('scrap_seller'))->id;
        return [
            'alies_id' => ['nullable', 'string', 'max:50'],
            'company_name' => ['required', 'string', 'max:255'],
            'business_age' => ['nullable', 'string', 'max:50'],
            'owner_name' => ['required', 'string', 'max:255'],
            'mobile' => ['required', 'string', 'regex:/^[0-9]{10,15}$/', 'unique:scrap_sellers,mobile,' . ($id ?? 'NULL')],
            'owner_type' => ['nullable', 'string', 'max:100'],
            'address' => ['required', 'string'],
            'gst_no' => ['nullable', 'string', 'max:30'],
            'pan_no' => ['nullable', 'string', 'max:20'],
            'email' => ['nullable', 'email', 'max:255', 'unique:scrap_sellers,email,' . ($id ?? 'NULL')],
            'owner_rent' => ['nullable', 'string', 'max:100'],
            'godownspace' => ['nullable', 'string', 'max:100'],
            'company_seller1' => ['nullable', 'string', 'max:255'],
            'company_seller2' => ['nullable', 'string', 'max:255'],
            'company_seller3' => ['nullable', 'string', 'max:255'],
            'company_seller4' => ['nullable', 'string', 'max:255'],
            'company_seller5' => ['nullable', 'string', 'max:255'],
            'tonmonth1' => ['nullable', 'string', 'max:50'],
            'tonmonth2' => ['nullable', 'string', 'max:50'],
            'tonmonth3' => ['nullable', 'string', 'max:50'],
            'tonmonth4' => ['nullable', 'string', 'max:50'],
            'tonmonth5' => ['nullable', 'string', 'max:50'],
            'total_ton' => ['nullable', 'string', 'max:50'],
            'other_business' => ['nullable', 'string', 'max:255'],
            'agni_business_value' => ['nullable', 'string', 'max:255'],
            'question1' => ['nullable', 'string'],
            'question2' => ['nullable', 'string'],
            'question3' => ['nullable', 'string'],
            'question4' => ['nullable', 'string'],
            'question5' => ['nullable', 'string'],
            'question6' => ['nullable', 'string'],
            'question7' => ['nullable', 'string'],
            'question8' => ['nullable', 'string'],
            'shop_image' => ['nullable', 'image', 'max:4096'],
            'godown_image' => ['nullable', 'image', 'max:4096'],
            'pancard_image' => ['nullable', 'image', 'max:4096'],
            'aadhar_front_image' => ['nullable', 'image', 'max:4096'],
            'aadhar_back_image' => ['nullable', 'image', 'max:4096'],
            'reg_certificate_image' => ['nullable', 'image', 'max:4096'],
            'action' => ['nullable', 'string', 'max:50'],
            'cdate' => ['nullable', 'date'],
            'rep_id' => ['nullable', 'string', 'max:50'],
            'approval' => ['nullable', 'string', 'max:50'],
        ];
    }
}
