<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\ScrapDistributor;
use App\Models\ScrapSeller;
use App\Models\BdeHomeLocation;
use App\Models\SoHomeLocation;


class ReportController extends Controller
{

    public function index()
    {

        $distributors = ScrapDistributor::latest()->get();

        return view(
            'reports.index',
            compact('distributors')
        );

    }



    public function search(Request $request)
    {


        $query = ScrapDistributor::query();



        // Global Search

        if($request->search)
        {

            $search = $request->search;


            $query->where(function($q) use($search){

                $q->where('name','LIKE',"%$search%")
                ->orWhere('mobile','LIKE',"%$search%")
                ->orWhere('email','LIKE',"%$search%");

            });

        }



        // Date Filter

        if($request->from_date)
        {

            $query->whereDate(
                'created_at',
                '>=',
                $request->from_date
            );

        }



        if($request->to_date)
        {

            $query->whereDate(
                'created_at',
                '<=',
                $request->to_date
            );

        }




        // Status Filter

        if($request->status)
        {

            $query->where(
                'status',
                $request->status
            );

        }



        $data = $query
                ->latest()
                ->get();



        return response()->json($data);


    }

}