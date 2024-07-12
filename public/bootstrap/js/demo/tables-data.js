// Call the dataTables jQuery plugin
$(document).ready(function() {
    $('#tabel-data').DataTable();
  });
  $('#tabel-data').DataTable({
    "searching": false,
    "bAutoWidth": false,  
    "columnDefs": [
      { "orderable": false, "targets": [3,5] },
      { "orderable": true, "targets": [1,2,4] }
  ],
  "drawCallback": function( settings ) {
    feather.replace();
  }
  });
  