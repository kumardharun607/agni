<link rel="stylesheet"
href="https://cdn.datatables.net/2.3.2/css/dataTables.dataTables.min.css">

<script src="https://cdn.datatables.net/2.3.2/js/dataTables.min.js"></script>

<script>

$(function(){

new DataTable('#dataTable',{

pageLength:10,

ordering:true,

searching:true,

responsive:true,

language:{

search:"Search : "

}

});

});

</script>