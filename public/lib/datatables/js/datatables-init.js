$(document).ready(function() {
	   let tables = ['.ace-table'];
	   for(var i=0; i<tables.length;i++){
          $(tables[i]).DataTable({
            lengthMenu: [[10,20,50,-1],[10,20,50,"All"]]
          });
        }
    });
    $('#example23').DataTable({
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    });
