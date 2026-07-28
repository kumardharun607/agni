@extends('layouts.app')

@section('title','SO Home Locations')

@section('page_title','SO Home Locations')

@section('content')

<x-breadcrumb
    title="SO Home Locations"
    parent="Masters"
    child="SO Home Locations"
    :button="'<div class=\'flex gap-2\'>
        <a href='.route('so-home-locations.import').' class=\'bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg\'>
            Import Excel
        </a>

        <a href='.route('so-home-locations.export').' data-ajax-skip download class=\'bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg\'>
            Export Excel
        </a>

        <a href='.route('so-home-locations.create').' class=\'bg-red-700 hover:bg-red-800 text-white px-5 py-2 rounded-lg\'>
            + Add SO Home Location
        </a>
    </div>'"
/>

@include('components.alert')

<div class="bg-white rounded-xl shadow border border-gray-200">

    <div class="p-5 border-b">

        <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-4">

            <div>

                <h2 class="text-xl font-semibold">
                    SO Home Location List
                </h2>

                <p class="text-sm text-gray-500">
                    Manage SO Home Locations
                </p>

            </div>

            <div class="w-full md:w-72">

                <input
                    type="text"
                    id="searchSoHomeLocation"
                    placeholder="Search SO Home Location..."
                    class="w-full border rounded-lg px-4 py-2">

            </div>

        </div>

    </div>

    <div class="overflow-x-auto">

        <table id="soHomeLocationTable" class="min-w-full">

            <thead class="bg-gray-100">

                <tr>

                    <th class="px-4 py-3 text-left">S.No</th>

                    <th class="px-4 py-3 text-left">SO Name</th>

                    <th class="px-4 py-3 text-left">Home Address</th>

                    <th class="px-4 py-3 text-center">Action</th>

                </tr>

            </thead>

            <tbody>

                @forelse($soHomeLocations as $location)

                <tr class="border-b hover:bg-gray-50">

                    <td class="px-4 py-3">

                        {{ $loop->iteration }}

                    </td>

                    <td class="px-4 py-3 font-medium">

                        {{ $location->so_id }}

                    </td>

                    <td class="px-4 py-3">

                        {{ $location->home_address }}

                    </td>

                    <td class="px-4 py-3">

                        <div class="flex justify-center items-center gap-2">
                            <a href="{{ route('so-home-locations.show',$location->id) }}"
                                title="View"
                               class="inline-flex items-center justify-center w-9 h-9 rounded-md bg-gray-700 hover:bg-gray-800 text-white shadow-sm">
                                <i class="fa fa-eye"></i>
                            </a>
                            <a href="{{ route('so-home-locations.edit',$location->id) }}"
                               title="Edit"
                               class="inline-flex items-center justify-center w-9 h-9 rounded-md bg-yellow-500 hover:bg-yellow-600 text-white shadow-sm">
                                <i class="fa fa-edit"></i>
                            </a>
                            <a href="https://www.google.com/maps?q={{ $location->home_lat }},{{ $location->home_long }}"
                               target="_blank" title="Map"
                               class="inline-flex items-center justify-center w-9 h-9 rounded-md bg-blue-600 hover:bg-blue-700 text-white shadow-sm">
                                <i class="fa fa-map-marker-alt"></i>
                            </a>
                            <button type="button" title="Delete"
                                onclick="deleteSoHomeLocation({{ $location->id }}, this)"
                                class="inline-flex items-center justify-center w-9 h-9 rounded-md bg-red-600 hover:bg-red-700 text-white shadow-sm">
                                <i class="fa fa-trash"></i>
                            </button>
                        </div>

                    </td>

                </tr>

                @empty

                <tr>

                    <td colspan="4"
                        class="text-center py-8 text-gray-500">

                        No Records Found

                    </td>

                </tr>

                @endforelse

            </tbody>

        </table>

    </div>

    <div class="p-5">

        {{ $soHomeLocations->links() }}

    </div>

</div>

@endsection

@push('scripts')

<script>

$("#searchSoHomeLocation").keyup(function(){

    let value=$(this).val().toLowerCase();

    $("#soHomeLocationTable tbody tr").filter(function(){

        $(this).toggle($(this).text().toLowerCase().indexOf(value)>-1);

    });

});

function deleteSoHomeLocation(id, btn){

    let $row = $(btn).closest('tr');

    Swal.fire({
        title:'Are you sure?',
        text:'This SO Home Location will be deleted permanently.',
        icon:'warning',
        showCancelButton:true,
        confirmButtonColor:'#B91C1C',
        confirmButtonText:'Yes, delete it'
    }).then((result)=>{
        if(result.isConfirmed){
            $.ajax({
                url:'/so-home-locations/'+id,
                type:'DELETE',
                data:{ _token:'{{ csrf_token() }}' },
                success:function(res){
                    const Toast = Swal.mixin({ toast: true, position: 'top-end', showConfirmButton: false, timer: 3000, timerProgressBar: true });
                    Toast.fire({ icon: 'success', title: (res && res.message) ? res.message : 'Deleted successfully' });
                    $row.fadeOut(250,function(){ $(this).remove(); });
                },
                error:function(xhr){
                    let msg = (xhr.responseJSON && xhr.responseJSON.message) ? xhr.responseJSON.message : "Something went wrong. Please try again.";
                    const Toast = Swal.mixin({ toast: true, position: 'top-end', showConfirmButton: false, timer: 4000, timerProgressBar: true });
                    Toast.fire({ icon: 'error', title: msg });
                }
            });
        }
    });
}

</script>

@endpush
