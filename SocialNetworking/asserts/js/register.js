$(document).ready(function () {
    $("#Registration").hide();
    $('#signup').click(function (e) {
        $("#Login").slideUp("fast", function () {
            $('#Registration').slideDown("slow");
        })
    });
    $('#signin').click(function (e) {
        $("#Registration").slideUp("fast", function () {
            $('#Login').slideDown("slow");
        })
    });
})

