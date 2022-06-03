//Dashboard : Changing content when selected from side menu without reloading
jQuery(function () {
    jQuery('.menuBtn').click(function () {
        jQuery('.targetDiv').hide();
        jQuery('#section' + $(this).attr('section')).show();
    });
});

//Active Tab for Dashboard side
$(document).ready(function () {
    $(".menuBtn").click(function () {
        $(".menuBtn").removeClass("active");
        $(this).addClass("active");
    });
});

function confirmSubmit() {
    var agree = confirm("Are you sure you wish to delete?");
    if (agree)
        return true;
    else
        return false;
}

//For Datatables
$(document).ready(function () {
    $('#weeklyBillSplitTable').DataTable({
        paging: false,
        "bLengthChange": false,
        "dom": '<"pull-left"f><"pull-right"l>tip',
        "language": {
            "search": "_INPUT_",
            "searchPlaceholder": "Search"
        },        
        responsive: true,
    });
});