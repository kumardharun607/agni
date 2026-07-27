<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>

        @yield('title','AGNI Dealer Management System')

    </title>

    <!-- Tailwind -->

    <script src="https://cdn.tailwindcss.com"></script>

    <script>

        tailwind.config = {

            theme: {

                extend: {

                    colors: {

                        primary:'#B91C1C',

                        'primary-light':'#dc2626',

                        'primary-fixed-dim':'#fef2f2',

                        secondary:'#F4F6F9',

                        sidebar:'#FFFFFF',

                        border:'#E5E7EB',

                        tertiary:'#00609a',

                        'tertiary-container':'#0b79bf',

                        surface:'#f8fafb',

                        'surface-container':'#eceeef',

                        'surface-container-low':'#f2f4f5',

                        'surface-container-high':'#e6e8e9',

                        'on-surface':'#191c1d',

                        'on-surface-variant':'#5a4138',

                        outline:'#8f7066',

                        'outline-variant':'#f3d2d2'

                    }

                }

            }

        };

    </script>

    <!-- Google Font -->

    <link rel="preconnect"
          href="https://fonts.googleapis.com">

    <link rel="preconnect"
          href="https://fonts.gstatic.com"
          crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap"
          rel="stylesheet">

    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap"
          rel="stylesheet">

    <!-- DataTables (used by dealers/dealer-mapping/users/permission-dropdown/sales-stage tables) -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.8/css/jquery.dataTables.min.css">

    <!-- JQuery -->

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>

    <!-- SweetAlert -->

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- FontAwesome -->

    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">

    <style>

        body{

            font-family:'Inter',sans-serif;

            background:#F4F6F9;

            overflow:hidden;

        }

        .sidebar-scroll::-webkit-scrollbar{

            width:6px;

        }

        .sidebar-scroll::-webkit-scrollbar-thumb{

            background:#d1d5db;

            border-radius:20px;

        }

        /* --- Ported from dharun_agni, re-themed to the sharvin_agni palette above --- */
        .material-symbols-outlined { font-variation-settings: 'FILL' 0, 'wght' 500, 'GRAD' 0, 'opsz' 24; font-size: 20px; vertical-align: middle; }
        table.dataTable { font-size: 13px; }
        .font-heading { font-family: 'Inter', sans-serif; }
        .form-input, .form-select, .form-textarea { width: 100%; border: 0; border-bottom: 2px solid #E5E7EB; background: #fff; padding: .5rem .75rem; font-size: .875rem; border-radius: .25rem .25rem 0 0; }
        .form-input:focus, .form-select:focus, .form-textarea:focus { outline: none; border-color: #B91C1C; }
        .form-label { display: block; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: .03em; color: #5a4138cc; margin-bottom: .25rem; }
        .btn-primary { background: #B91C1C; color: #fff; font-size: .875rem; font-weight: 600; padding: .5rem 1rem; border-radius: .375rem; display: inline-flex; align-items: center; gap: .375rem; transition: background .15s; }
        .btn-primary:hover { background: #dc2626; }
        .btn-secondary { border: 1px solid #cbd5e1; color: #475569; font-size: .875rem; font-weight: 600; padding: .5rem 1rem; border-radius: .375rem; display: inline-flex; align-items: center; gap: .375rem; transition: background .15s; }
        .btn-secondary:hover { background: #475569; color: #fff; }
        .btn-export, .btn-import { background: #16a34a; color: #fff; font-size: .875rem; font-weight: 600; padding: .5rem 1rem; border-radius: .375rem; display: inline-flex; align-items: center; gap: .375rem; transition: background .15s; }
        .btn-export:hover, .btn-import:hover { background: #15803d; }
        .btn-danger { background: #dc2626; color: #fff; font-size: .75rem; font-weight: 600; padding: .375rem .75rem; border-radius: .375rem; }
        .btn-danger:hover { background: #b91c1c; }
        .btn-sm { font-size: .75rem; padding: .375rem .75rem; border-radius: .375rem; font-weight: 600; }
        .card { background: #fff; border: 1px solid #E5E7EB; border-radius: .5rem; padding: 1.5rem; }
        .sidebar-link { display: flex; align-items: center; gap: .75rem; padding: .625rem 1rem; font-size: .875rem; color: #64748b; border-radius: .375rem; transition: background .15s, color .15s; }
        .sidebar-link:hover { background: #fef2f2; color: #B91C1C; }
        .sidebar-link.active { color: #B91C1C; font-weight: 700; background: #fef2f2; border-left: 2px solid #B91C1C; }
        .error-text { color: #dc2626; font-size: .75rem; margin-top: .25rem; }

    </style>

</head>

<body>

<div class="flex h-screen overflow-hidden">

    {{-- Sidebar --}}

    @include('components.sidebar')

    <div class="flex flex-col flex-1 overflow-hidden">

        {{-- Navbar --}}

        @include('components.navbar')

        {{-- Dynamic Content --}}

        <main id="page-content"
              class="flex-1 overflow-y-auto p-6">

            @include('components.alert')

            @yield('content')

            @stack('scripts')

        </main>

        {{-- Footer --}}

        @include('components.footer')

    </div>

</div>

<script>

/*
|--------------------------------------------------------------------------
| AJAX PAGE LOADER
|--------------------------------------------------------------------------
*/

function loadPage(url, tab = null)
{

    $.ajax({

        url: url,

        type: "GET",

        success: function (response) {

            let content = $(response).find("#page-content").html();

            $("#page-content").html(content);

            history.pushState(
                {
                    url: url,
                    tab: tab
                },
                "",
                url
            );

            if (typeof setSidebarActive === 'function') {
                setSidebarActive(url);
            }

            if (tab === "profile") {

                setTimeout(function () {

                    if ($("#profileTab").length) {

                        $("#profileTab").trigger("click");

                    }

                }, 100);

            }

            if (tab === "password") {

                setTimeout(function () {

                    if ($("#passwordTab").length) {

                        $("#passwordTab").trigger("click");

                    }

                }, 100);

            }

            window.scrollTo(0, 0);

        },

        error: function () {

            $("#page-content").html(

                '<div class="bg-white rounded-xl shadow border p-10 text-center text-red-600 text-xl font-semibold">Page Load Failed</div>'

            );

        }

    });

}

/*
|--------------------------------------------------------------------------
| AJAX LINKS
|--------------------------------------------------------------------------
*/
/*
|--------------------------------------------------------------------------
| AJAX LINKS
|--------------------------------------------------------------------------
*/

$(document).on("click","a",function(e){

    let link=$(this);

    if(link.attr("target")=="_blank"){
        return;
    }

    if(link.is("[download]")){
        return;
    }

    if(link.is("[data-ajax-skip]")){
        return;
    }

    let href=link.attr("href");

    if(!href){
        return;
    }

    if(
        href.startsWith("#") ||
        href.startsWith("javascript:") ||
        href.startsWith("mailto:") ||
        href.startsWith("tel:")
    ){
        return;
    }

    e.preventDefault();

    loadPage(href);

});

/*
|--------------------------------------------------------------------------
| Browser Back / Forward
|--------------------------------------------------------------------------
*/

window.onpopstate = function (event) {

    if (event.state) {

        loadPage(event.state.url, event.state.tab);

    }

};

/*
|--------------------------------------------------------------------------
| AJAX FORM SUBMIT (Edit / Update forms - no page reload)
|--------------------------------------------------------------------------
*/

/*
|--------------------------------------------------------------------------
| AJAX FORM SUBMIT
|--------------------------------------------------------------------------
*/

$(document).on("submit","form",function(e){

    if($(this).is("[data-ajax-skip]")){
        return;
    }

    if($(this).hasClass("ajax-form")){
        return; // handled by the dedicated ajax-form handler below
    }

    e.preventDefault();

    let form=this;

    let formData=new FormData(form);

    $.ajax({

        url:form.action,

        type:form.method,

        data:formData,

        processData:false,

        contentType:false,

        success:function(response){

            let content=$(response).find("#page-content").html();

            if(content){

                $("#page-content").html(content);

                

            }

        },

        error:function(xhr){

            if(xhr.status==422){

                let content=$(xhr.responseText).find("#page-content").html();

                if(content){

                    $("#page-content").html(content);

                }

            }else{

                Swal.fire({
                    icon:"error",
                    title:"Error",
                    text:"Something went wrong."
                });

            }

        }

    });

});

/*
|--------------------------------------------------------------------------
| Helpers ported from dharun_agni: delete confirmation + CSV import modal,
| used by the Dealer/DealerMapping/User/PermissionDropdown/SalesStage/
| Country/State/City/Pincode/Roles module views.
|--------------------------------------------------------------------------
*/

$.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });

function setSidebarActive(url) {
    try {
        var path = (url || window.location.pathname).replace(/^https?:\/\/[^\/]+/, '');
        path = path.split('?')[0];

        // Remove active styles from all sidebar links
        $('#sidebar a').each(function () {
            $(this).removeClass('bg-red-50 text-red-700 font-semibold');
            // keep hover classes if present
            if (!$(this).hasClass('hover:bg-red-50')) {
                $(this).addClass('hover:bg-red-50 hover:text-red-700');
            }
        });

        // Match best sidebar link
        var best = null;
        var bestLen = -1;
        $('#sidebar a[href]').each(function () {
            var href = $(this).attr('href') || '';
            if (!href || href === '#' || href.indexOf('javascript:') === 0) return;
            try {
                var linkPath = href.replace(/^https?:\/\/[^\/]+/, '').split('?')[0];
            } catch (e) { return; }
            if (path === linkPath || (linkPath !== '/' && path.indexOf(linkPath) === 0)) {
                if (linkPath.length > bestLen) {
                    best = this;
                    bestLen = linkPath.length;
                }
            }
        });

        if (best) {
            $(best).addClass('bg-red-50 text-red-700 font-semibold');
            $(best).removeClass('hover:bg-red-50 hover:text-red-700');
            // Open parent submenu
            var $li = $(best).closest('ul');
            if ($li.attr('id') === 'masterSub') {
                $('#masterSub').removeClass('hidden');
                $('#masterArrow').addClass('rotate-180');
            }
            if ($li.attr('id') === 'settingSub') {
                $('#settingSub').removeClass('hidden');
                $('#settingArrow').addClass('rotate-180');
            }
        }
    } catch (e) {
        console && console.warn && console.warn('setSidebarActive', e);
    }
}

function confirmDelete(url, tableSelector) {
    Swal.fire({
        title: 'Delete this record?',
        text: 'This will soft delete the record. It can be restored later from the database only.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#B91C1C',
        confirmButtonText: 'Yes, delete it'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: url,
                type: 'DELETE',
                success: function () {
                    Swal.fire('Deleted!', 'The record has been removed.', 'success');
                    if (tableSelector && $(tableSelector).length && $.fn.DataTable.isDataTable(tableSelector)) {
                        $(tableSelector).DataTable().ajax.reload(null, false);
                    } else {
                        loadPage(window.location.href);
                    }
                },
                error: function (xhr) {
                    Swal.fire('Error', xhr.responseJSON?.message || 'Could not delete this record.', 'error');
                }
            });
        }
    });
}

// Generic Import Excel/CSV modal.
function openImportModal(importUrl, tableSelector, sampleUrl) {
    Swal.fire({
        title: 'Import from Excel / CSV',
        html: `
            <div class="text-left">
                <input type="file" id="swal-import-file" accept=".csv,.txt" class="w-full border border-gray-300 rounded px-3 py-2 text-sm">
                <p class="text-xs text-gray-500 mt-2">Upload a .csv file exported from Excel. The first row must be the column headers.</p>
                ${sampleUrl ? `<a href="${sampleUrl}" class="text-xs text-blue-600 underline" data-ajax-skip>Download sample template</a>` : ''}
            </div>`,
        confirmButtonText: 'Upload',
        confirmButtonColor: '#16a34a',
        showCancelButton: true,
        focusConfirm: false,
        preConfirm: () => {
            const fileInput = document.getElementById('swal-import-file');
            if (!fileInput.files.length) {
                Swal.showValidationMessage('Please choose a file first');
                return false;
            }
            return fileInput.files[0];
        }
    }).then((result) => {
        if (!result.isConfirmed) return;
        const formData = new FormData();
        formData.append('file', result.value);
        $.ajax({
            url: importUrl,
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function (res) {
                Swal.fire('Imported!', res.message || 'File imported successfully.', 'success');
                if (tableSelector && $(tableSelector).length && $.fn.DataTable.isDataTable(tableSelector)) {
                    $(tableSelector).DataTable().ajax.reload(null, false);
                } else {
                    loadPage(window.location.href);
                }
            },
            error: function (xhr) {
                const msg = xhr.responseJSON?.message || 'Could not import this file. Please check the format and try again.';
                Swal.fire('Import failed', msg, 'error');
            }
        });
    });
}

// AJAX submit for every dharun-derived Create/Edit form (class="ajax-form").
// No page reload: shows a toast, then navigates back via the SPA-style loadPage().
$(document).on('submit', 'form.ajax-form', function (e) {
    e.preventDefault();
    const $form = $(this);
    const $btn = $form.find('button[type=submit], button:not([type])').first();
    const originalBtnHtml = $btn.html();

    $form.find('.error-text').remove();
    $form.find('.form-input, .form-select, .form-textarea').removeClass('border-red-500');
    $btn.prop('disabled', true).html('<span class="animate-pulse">Saving...</span>');

    $.ajax({
        url: $form.attr('action'),
        type: 'POST', // Laravel method-spoofs PUT via the hidden _method field already in the form
        data: new FormData(this),
        processData: false,
        contentType: false,
        headers: { Accept: 'application/json' },
        success: function (res) {
            const Toast = Swal.mixin({ toast: true, position: 'top-end', showConfirmButton: false, timer: 1800, timerProgressBar: true });
            Toast.fire({ icon: 'success', title: res.message || 'Saved successfully.' });
            setTimeout(function () {
                loadPage(res.redirect || $form.data('index-url') || document.referrer);
            }, 400);
        },
        error: function (xhr) {
            $btn.prop('disabled', false).html(originalBtnHtml);
            if (xhr.status === 422 && xhr.responseJSON?.errors) {
                const errors = xhr.responseJSON.errors;
                let firstField = null;
                Object.keys(errors).forEach(function (field) {
                    const $field = $form.find(`[name="${field}"]`);
                    $field.addClass('border-red-500');
                    $field.closest('div').append(`<p class="error-text">${errors[field][0]}</p>`);
                    if (!firstField) firstField = $field;
                });
                if (firstField) firstField.get(0).scrollIntoView({ behavior: 'smooth', block: 'center' });
            } else {
                Swal.fire('Error', xhr.responseJSON?.message || 'Something went wrong. Please try again.', 'error');
            }
        }
    });
});
</script>

</body>

</html>