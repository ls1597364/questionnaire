
$(document).ready(function() {
    $(".edit_tr").click(function() {
        var id = $(this).attr('id');
        $("#txtHint").load("getQuestion/id=:" + id);
    });
});