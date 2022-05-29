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