// Call the dataTables jQuery plugin
$(document).ready(function() {
  $('#dataTable').DataTable();
});
$('#dataTable').DataTable({
  "searching": false,
  "bAutoWidth": false,
  "columnDefs": [
    { "orderable": false, "targets": [,4, 5, 7] },
    { "orderable": true, "targets": [1, 2, 3, 6] }
],
"drawCallback": function( settings ) {
  feather.replace();
}
});

// $('#id-of-my-table').DataTable({

// })
