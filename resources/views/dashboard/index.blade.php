@extends('layouts.app')

@section('title','Dashboard')

@section('page_title','Dashboard')

@section('content')

<div class="flex items-center gap-4 mb-6">
    <img src="{{ asset('images/agni-logo.png') }}" alt="AGNI" class="w-14 h-14 rounded-full object-cover">
    <div>
        <h1 class="text-2xl font-bold text-red-700">AGNI Dealer Management System</h1>
        <p class="text-sm text-gray-500">Overview of your dealer network, team, and locations</p>
    </div>
</div>



<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">


    <!-- Countries -->

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">

        <div class="flex items-center justify-between">

            <div>
                <p class="text-sm text-gray-500">
                    Total Countries
                </p>

                <h2 class="text-3xl font-bold text-red-700 mt-2">
                    {{ $data['countries'] }}
                </h2>
            </div>


            <div class="w-14 h-14 rounded-full bg-red-100 flex items-center justify-center">

                <i class="fa-solid fa-earth-asia text-red-700 text-2xl"></i>

            </div>

        </div>

    </div>



    <!-- States -->

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">

        <div class="flex items-center justify-between">

            <div>

                <p class="text-sm text-gray-500">
                    Total States
                </p>

                <h2 class="text-3xl font-bold text-blue-700 mt-2">
                    {{ $data['states'] }}
                </h2>

            </div>


            <div class="w-14 h-14 rounded-full bg-blue-100 flex items-center justify-center">

                <i class="fa-solid fa-map-location-dot text-blue-700 text-2xl"></i>

            </div>


        </div>

    </div>




    <!-- Cities -->

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">

        <div class="flex items-center justify-between">


            <div>

                <p class="text-sm text-gray-500">
                    Total Cities
                </p>


                <h2 class="text-3xl font-bold text-green-700 mt-2">
                    {{ $data['cities'] }}
                </h2>


            </div>


            <div class="w-14 h-14 rounded-full bg-green-100 flex items-center justify-center">

                <i class="fa-solid fa-city text-green-700 text-2xl"></i>

            </div>


        </div>

    </div>





    <!-- Pincode -->


    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">

        <div class="flex items-center justify-between">


            <div>

                <p class="text-sm text-gray-500">
                    Total Pincodes
                </p>


                <h2 class="text-3xl font-bold text-yellow-600 mt-2">
                    {{ $data['pincodes'] }}
                </h2>


            </div>


            <div class="w-14 h-14 rounded-full bg-yellow-100 flex items-center justify-center">

                <i class="fa-solid fa-location-dot text-yellow-600 text-2xl"></i>

            </div>


        </div>

    </div>





    <!-- Dealers -->

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">

        <div class="flex items-center justify-between">

            <div>
                <p class="text-sm text-gray-500">
                    Total Dealers
                </p>

                <h2 class="text-3xl font-bold text-teal-700 mt-2">
                    {{ $data['dealers'] }}
                </h2>
            </div>

            <div class="w-14 h-14 rounded-full bg-teal-100 flex items-center justify-center">

                <i class="fa-solid fa-handshake text-teal-700 text-2xl"></i>

            </div>

        </div>

    </div>


    <!-- Users -->

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">

        <div class="flex items-center justify-between">

            <div>
                <p class="text-sm text-gray-500">
                    Total Users
                </p>

                <h2 class="text-3xl font-bold text-purple-700 mt-2">
                    {{ $data['users'] }}
                </h2>
            </div>

            <div class="w-14 h-14 rounded-full bg-purple-100 flex items-center justify-center">

                <i class="fa-solid fa-users text-purple-700 text-2xl"></i>

            </div>

        </div>

    </div>


    <!-- Sales Stage -->

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">

        <div class="flex items-center justify-between">

            <div>
                <p class="text-sm text-gray-500">
                    Sales Stages
                </p>

                <h2 class="text-3xl font-bold text-cyan-700 mt-2">
                    {{ $data['salesStages'] }}
                </h2>
            </div>

            <div class="w-14 h-14 rounded-full bg-cyan-100 flex items-center justify-center">

                <i class="fa-solid fa-chart-line text-cyan-700 text-2xl"></i>

            </div>

        </div>

    </div>



    <!-- Scrap Distributor -->


    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">


        <div class="flex justify-between items-center">


            <div>

                <p class="text-sm text-gray-500">
                    Scrap Distributors
                </p>


                <h2 class="text-3xl font-bold text-indigo-700 mt-2">
                    {{ $data['scrapDistributors'] }}
                </h2>

            </div>


            <div class="w-14 h-14 rounded-full bg-indigo-100 flex items-center justify-center">

                <i class="fa-solid fa-truck text-indigo-700 text-2xl"></i>

            </div>


        </div>


    </div>





    <!-- Scrap Seller -->


    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">


        <div class="flex justify-between items-center">


            <div>

                <p class="text-sm text-gray-500">
                    Scrap Sellers
                </p>


                <h2 class="text-3xl font-bold text-pink-700 mt-2">
                    {{ $data['scrapSellers'] }}
                </h2>


            </div>


            <div class="w-14 h-14 rounded-full bg-pink-100 flex items-center justify-center">

                <i class="fa-solid fa-user-group text-pink-700 text-2xl"></i>

            </div>


        </div>


    </div>





    <!-- BDE Home Location -->


    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">


        <div class="flex justify-between items-center">


            <div>

                <p class="text-sm text-gray-500">
                    BDE Home Locations
                </p>


                <h2 class="text-3xl font-bold text-emerald-700 mt-2">
                    {{ $data['bdeLocations'] }}
                </h2>


            </div>


            <div class="w-14 h-14 rounded-full bg-emerald-100 flex items-center justify-center">

                <i class="fa-solid fa-house text-emerald-700 text-2xl"></i>

            </div>


        </div>


    </div>





    <!-- SO Home Location -->


    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">


        <div class="flex justify-between items-center">


            <div>

                <p class="text-sm text-gray-500">
                    SO Home Locations
                </p>


                <h2 class="text-3xl font-bold text-orange-700 mt-2">
                    {{ $data['soLocations'] }}
                </h2>


            </div>


            <div class="w-14 h-14 rounded-full bg-orange-100 flex items-center justify-center">

                <i class="fa-solid fa-location-dot text-orange-700 text-2xl"></i>

            </div>


        </div>


    </div>


    <!-- Brands -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <div class="flex justify-between items-center">
            <div>
                <p class="text-sm text-gray-500">Total Brands</p>
                <h2 class="text-3xl font-bold text-red-700 mt-2">{{ $data['brands'] ?? 0 }}</h2>
            </div>
            <div class="w-14 h-14 rounded-full bg-red-100 flex items-center justify-center">
                <i class="fa-solid fa-tags text-red-700 text-2xl"></i>
            </div>
        </div>
    </div>

    <!-- Floor Stages -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <div class="flex justify-between items-center">
            <div>
                <p class="text-sm text-gray-500">Floor Stages</p>
                <h2 class="text-3xl font-bold text-blue-700 mt-2">{{ $data['floorStages'] ?? 0 }}</h2>
            </div>
            <div class="w-14 h-14 rounded-full bg-blue-100 flex items-center justify-center">
                <i class="fa-solid fa-layer-group text-blue-700 text-2xl"></i>
            </div>
        </div>
    </div>

    <!-- Building Stages -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <div class="flex justify-between items-center">
            <div>
                <p class="text-sm text-gray-500">Building Stages</p>
                <h2 class="text-3xl font-bold text-indigo-700 mt-2">{{ $data['buildingStages'] ?? 0 }}</h2>
            </div>
            <div class="w-14 h-14 rounded-full bg-indigo-100 flex items-center justify-center">
                <i class="fa-solid fa-building text-indigo-700 text-2xl"></i>
            </div>
        </div>
    </div>

    <!-- Dealer Registrations -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <div class="flex justify-between items-center">
            <div>
                <p class="text-sm text-gray-500">Dealer Registrations</p>
                <h2 class="text-3xl font-bold text-rose-700 mt-2">{{ $data['dealerRegistrations'] ?? 0 }}</h2>
            </div>
            <div class="w-14 h-14 rounded-full bg-rose-100 flex items-center justify-center">
                <i class="fa-solid fa-file-signature text-rose-700 text-2xl"></i>
            </div>
        </div>
    </div>


</div>


@endsection