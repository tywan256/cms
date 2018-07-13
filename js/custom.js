
$.fn.dataTable.ext.search.push(
function (settings, data, dataIndex) {
    var startDate = Date.parse($('#start-date').val(), 10);
    var endDate = Date.parse($('#end-date').val(), 10);
    var columnDate = Date.parse(data[3]) || 0; // use data for the age column

    if ((isNaN(startDate) && isNaN(endDate)) ||
         (isNaN(startDate) && columnDate <= endDate) ||
         (startDate <= columnDate && isNaN(endDate)) ||
         (startDate <= columnDate && columnDate <= endDate)) {
        return true;
    }
    return false;
}
);

$(document).ready(function() {

    // Setup - add a text input to each footer cell
    $('#example thead th').each( function (i) {
        var title = $('#example thead th').eq( $(this).index() ).text();
        $(this).html( '<input type="text" placeholder="Search '+title+'" data-index="'+i+'" />' );
    } );
  
    // DataTable
    var table = $('#example').DataTable( {
        scrollY:        "200px",
        scrollX:        true,
        scrollCollapse: true,
        paging:         false,
        fixedColumns:   true,
        dom: 'Bfrtip',
                buttons: [
                    'excel'
                ]
    } );
 
    // Filter event handler
    $( table.table().container() ).on( 'keyup', 'thead input', function () {
        table
            .column( $(this).data('index') )
            .search( this.value )
            .draw();
    } );

    //Hightlight our search text in the datatable
    table.on('draw', function () {
        var body = $(table.table().body());

    //We can change the highlight color in dataTables.searchHighlight.css
        body.unhighlight();
        body.highlight(table.search());
    });

    //Event Listener for custom radio buttons to filter datatable
    $('.customRadioButton').change(function () {
        table.columns(1).search(this.value).draw();
    });

    // Initialize DatePicker
    $('.input-group.date').datepicker({
        format: "yyyy-mm-dd",
        orientation: "top left",
        autoclose: true,
        todayHighlight: false,
        toggleActive: false
    });

    // Event listener to the two range filtering inputs to redraw on input
    $('#start-date, #end-date').change(function () {
        table.draw();
    });

} );