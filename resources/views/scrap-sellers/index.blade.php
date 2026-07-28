@extends('layouts.app')

@section('title','Scrap Sellers')

@section('page_title','Scrap Sellers')

@section('content')

<x-breadcrumb
    title="Scrap Sellers"
    parent="Masters"
    child="Scrap Sellers"
    :button="'<div class=\'flex gap-2\'>
        <a href='.route('scrap-sellers.import').' class=\'bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg\'>
            Import Excel
        </a>

        <a href='.route('scrap-sellers.export').' data-ajax-skip download class=\'bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg\'>
            Export Excel
        </a>

        <a href='.route('scrap-sellers.create').' class=\'bg-red-700 hover:bg-red-800 text-white px-5 py-2 rounded-lg\'>
            + Add Scrap Seller
        </a>
    </div>'"
/>

@include('components.alert')

<div class="bg-white rounded-xl shadow border border-gray-200">

    <div class="p-5 border-b">

        <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-4">

            <div>

                <h2 class="text-xl font-semibold">
                    Scrap Seller List
                </h2>

                <p class="text-sm text-gray-500">
                    Manage Scrap Seller Details
                </p>

            </div>

            <div class="w-full md:w-72">

                <input
                    type="text"
                    id="searchScrapSeller"
                    placeholder="Search Scrap Seller..."
                    class="w-full border rounded-lg px-4 py-2">

            </div>

        </div>

    </div>

    <div class="overflow-x-auto">

        <table id="scrapSellerTable" class="min-w-full">

            <thead class="bg-gray-100">

            <tr>

                <th class="px-4 py-3 text-left">#</th>

                <th class="px-4 py-3 text-left">Alias ID</th>

                <th class="px-4 py-3 text-left">Company</th>

                <th class="px-4 py-3 text-left">Owner</th>

                <th class="px-4 py-3 text-left">Mobile</th>

                <th class="px-4 py-3 text-left">Email</th>

                <th class="px-4 py-3 text-left">GST</th>

                <th class="px-4 py-3 text-left">PAN</th>

                <th class="px-4 py-3 text-left">Approval</th>

                <th class="px-4 py-3 text-center">Action</th>

            </tr>

            </thead>

            <tbody>

            @forelse($scrapSellers as $seller)

                <tr class="border-b hover:bg-gray-50">

                    <td class="px-4 py-3">
                        {{ $loop->iteration }}
                    </td>

                    <td class="px-4 py-3">
                        {{ $seller->alies_id }}
                    </td>

                    <td class="px-4 py-3 font-medium">
                        {{ $seller->company_name }}
                    </td>

                    <td class="px-4 py-3">
                        {{ $seller->owner_name }}
                    </td>

                    <td class="px-4 py-3">
                        {{ $seller->mobile }}
                    </td>

                    <td class="px-4 py-3">
                        {{ $seller->email }}
                    </td>

                    <td class="px-4 py-3">
                        {{ $seller->gst_no }}
                    </td>

                    <td class="px-4 py-3">
                        {{ $seller->pan_no }}
                    </td>

                    <td class="px-4 py-3">

                        @if($seller->approval)

                            <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs">

                                Approved

                            </span>

                        @else

                            <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-xs">

                                Pending

                            </span>

                        @endif

                    </td>

                    <td class="px-4 py-3">

                        <div class="flex justify-center items-center gap-2">
                            <a href="{{ route('scrap-sellers.show',$seller->id) }}" title="View"
                               class="inline-flex items-center justify-center w-9 h-9 rounded-md bg-gray-700 hover:bg-gray-800 text-white shadow-sm">
                                <i class="fa fa-eye"></i>
                            </a>
                            <a href="{{ route('scrap-sellers.edit',$seller->id) }}"
                               title="Edit"
                               class="inline-flex items-center justify-center w-9 h-9 rounded-md bg-yellow-500 hover:bg-yellow-600 text-white shadow-sm">
                                <i class="fa fa-edit"></i>
                            </a>
                            <button type="button" title="Delete"
                                onclick="deleteSeller({{ $seller->id }}, this)"
                                class="inline-flex items-center justify-center w-9 h-9 rounded-md bg-red-600 hover:bg-red-700 text-white shadow-sm">
                                <i class="fa fa-trash"></i>
                            </button>
                        </div>

                    </td>

                </tr>

            @empty

                <tr>

                    <td colspan="10"
                        class="text-center py-8 text-gray-500">

                        No Records Found

                    </td>

                </tr>

            @endforelse

            </tbody>

        </table>

    </div>

    <div class="p-5">

        {{ $scrapSellers->links() }}

    </div>

</div>

@endsection

@push('scripts')

<script>

$("#searchScrapSeller").keyup(function(){

    let value=$(this).val().toLowerCase();

    $("#scrapSellerTable tbody tr").filter(function(){

        $(this).toggle($(this).text().toLowerCase().indexOf(value)>-1);

    });

});

function deleteSeller(id, btn){
    let $row = $(btn).closest('tr');

    Swal.fire({
        title: 'Delete?',
        text: 'This record will be deleted.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc2626',
        confirmButtonText: 'Delete'
    }).then(function(result){
        if (!result.isConfirmed) return;

        $.ajax({
            url: @json(url('/scrap-sellers')) + '/' + id,
            type: 'POST',
            dataType: 'json',
            data: {
                _token: @json(csrf_token()),
                _method: 'DELETE'
            },
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            },
            success: function(res){
                const Toast = Swal.mixin({ toast: true, position: 'top-end', showConfirmButton: false, timer: 3000, timerProgressBar: true });
                Toast.fire({ icon: 'success', title: (res && res.message) ? res.message : 'Deleted successfully' });
                $row.fadeOut(250, function(){
                    $(this).remove();
                    if ($("#scrapSellerTable tbody tr:visible").length === 0) {
                        $("#scrapSellerTable tbody").html(
                            '<tr><td colspan="10" class="text-center py-8 text-gray-500">No Records Found</td></tr>'
                        );
                    }
                });
            },
            error: function(xhr){
                let msg = (xhr.responseJSON && xhr.responseJSON.message)
                    ? xhr.responseJSON.message
                    : 'Something went wrong. Please try again.';
                const Toast = Swal.mixin({ toast: true, position: 'top-end', showConfirmButton: false, timer: 4000, timerProgressBar: true });
                Toast.fire({ icon: 'error', title: msg });
            }
        });
    });
}

</script>





@endpush
