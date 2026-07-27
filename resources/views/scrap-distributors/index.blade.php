@extends('layouts.app')

@section('title','Scrap Distributor')

@section('page_title','Scrap Distributor')

@section('content')

<x-breadcrumb
    title="Scrap Distributor"
    parent="Masters"
    child="Scrap Distributor"
    :button="'<div class=\'flex gap-2\'>
        <a href='.route('scrap-distributors.import').' class=\'bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg\'>
            Import Excel
        </a>

        <a href='.route('scrap-distributors.export').' data-ajax-skip download class=\'bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg\'>
            Export Excel
        </a>

        <a href='.route('scrap-distributors.create').' class=\'bg-red-700 hover:bg-red-800 text-white px-5 py-2 rounded-lg\'>
            + Add Scrap Distributor
        </a>
    </div>'"
/>

@include('components.alert')

<div class="bg-white rounded-xl shadow border border-gray-200">

    <div class="p-5 border-b">

        <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-4">

            <div>

                <h2 class="text-xl font-semibold">
                    Scrap Distributor List
                </h2>

                <p class="text-sm text-gray-500">
                    Manage Scrap Distributor Details
                </p>

            </div>

            <div class="w-full md:w-72">

                <input
                    type="text"
                    id="searchScrapDistributor"
                    placeholder="Search Scrap Distributor..."
                    class="w-full border rounded-lg px-4 py-2">

            </div>

        </div>

    </div>

    <div class="overflow-x-auto">

        <table id="scrapDistributorTable" class="min-w-full">

            <thead class="bg-gray-100">

                <tr>

                    <th class="px-4 py-3 text-left">Rep ID</th>

                    <th class="px-4 py-3 text-left">Name</th>

                    <th class="px-4 py-3 text-left">Customer</th>

                    <th class="px-4 py-3 text-left">Mobile</th>

                    <th class="px-4 py-3 text-left">Location</th>

                    <th class="px-4 py-3 text-left">GST</th>

                    <th class="px-4 py-3 text-left">Email</th>

                    <th class="px-4 py-3 text-center">Action</th>

                </tr>

            </thead>

            <tbody>

            @forelse($scrapDistributors as $row)

                <tr class="border-b hover:bg-gray-50">

                    <td class="px-4 py-3">{{ $row->rep_id }}</td>

                    <td class="px-4 py-3 font-medium">{{ $row->name }}</td>

                    <td class="px-4 py-3">{{ $row->customer_name }}</td>

                    <td class="px-4 py-3">{{ $row->mobile }}</td>

                    <td class="px-4 py-3">

                        {{ $row->city?->name }}

                    </td>

                    <td class="px-4 py-3">

                        {{ $row->gst_no }}

                    </td>

                    <td class="px-4 py-3">

                        {{ $row->email }}

                    </td>

                    <td class="px-4 py-3 text-center">

                        <div class="flex justify-center items-center gap-2">
                            <a href="{{ route('scrap-distributors.show',$row->id) }}"
                               target="_blank" title="View"
                               class="inline-flex items-center justify-center w-9 h-9 rounded-md bg-gray-700 hover:bg-gray-800 text-white shadow-sm">
                                <i class="fa fa-eye"></i>
                            </a>
                            <a href="{{ route('scrap-distributors.edit',$row->id) }}"
                               title="Edit"
                               class="inline-flex items-center justify-center w-9 h-9 rounded-md bg-yellow-500 hover:bg-yellow-600 text-white shadow-sm">
                                <i class="fa fa-edit"></i>
                            </a>
                            @if(!empty($row->latitude) && !empty($row->longitude))
                            <a href="https://www.google.com/maps?q={{ $row->latitude }},{{ $row->longitude }}"
                               target="_blank" title="Map"
                               class="inline-flex items-center justify-center w-9 h-9 rounded-md bg-blue-600 hover:bg-blue-700 text-white shadow-sm">
                                <i class="fa fa-map-marker-alt"></i>
                            </a>
                            @endif
                            <button type="button" title="Delete"
                                class="deleteScrapDistributor inline-flex items-center justify-center w-9 h-9 rounded-md bg-red-600 hover:bg-red-700 text-white shadow-sm"
                                data-id="{{ $row->id }}">
                                <i class="fa fa-trash"></i>
                            </button>
                        </div>

                    </td>

                </tr>

            @empty

                <tr>

                    <td colspan="8"
                        class="text-center py-8 text-gray-500">

                        No Records Found

                    </td>

                </tr>

            @endforelse

            </tbody>

        </table>

    </div>

    <div class="p-5">

        {{ $scrapDistributors->links() }}

    </div>

</div>

@endsection

@push('scripts')

<script>

$("#searchScrapDistributor").keyup(function(){

    let value=$(this).val().toLowerCase();

    $("#scrapDistributorTable tbody tr").filter(function(){

        $(this).toggle($(this).text().toLowerCase().indexOf(value)>-1);

    });

});

$(document).off("click",".deleteScrapDistributor").on("click",".deleteScrapDistributor",function(){

    let id = $(this).data("id");
    let $row = $(this).closest("tr");

    Swal.fire({

        title:"Delete Scrap Distributor?",

        text:"This record will be moved to trash.",

        icon:"warning",

        showCancelButton:true,

        confirmButtonColor:"#b91c1c",

        confirmButtonText:"Delete"

    }).then((result)=>{

        if(result.isConfirmed){

            $.ajax({

                url:"/scrap-distributors/"+id,

                type:"POST",

                data:{

                    _token:"{{ csrf_token() }}",

                    _method:"DELETE"

                },

                success:function(res){
                    const Toast = Swal.mixin({ toast: true, position: 'top-end', showConfirmButton: false, timer: 3000, timerProgressBar: true });
                    Toast.fire({ icon: 'success', title: (res && res.message) ? res.message : 'Deleted successfully' });
                    $row.fadeOut(250,function(){
                        $(this).remove();
                        if($("#scrapDistributorTable tbody tr").length===0){
                            $("#scrapDistributorTable tbody").html(
                                '<tr><td colspan="8" class="text-center py-8 text-gray-500">No Records Found</td></tr>'
                            );
                        }
                    });
                },
                error:function(xhr){
                    let msg = (xhr.responseJSON && xhr.responseJSON.message)
                        ? xhr.responseJSON.message
                        : "Something went wrong. Please try again.";
                    const Toast = Swal.mixin({ toast: true, position: 'top-end', showConfirmButton: false, timer: 4000, timerProgressBar: true });
                    Toast.fire({ icon: 'error', title: msg });
                }

            });

        }

    });

});

</script>

@endpush
