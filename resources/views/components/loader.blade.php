<div
id="loader"
class="fixed inset-0 bg-white/70 z-[9999] hidden flex items-center justify-center">

    <div class="animate-spin rounded-full h-16 w-16 border-4 border-red-700 border-t-transparent">

    </div>

</div>

<script>

$(document).ajaxStart(function(){

    $("#loader").removeClass("hidden");

});

$(document).ajaxStop(function(){

    $("#loader").addClass("hidden");

});

</script>