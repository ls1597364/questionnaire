
$(document).ready(function() {
    $("#cancel").click(function() {
        window.location.href = 'about:blank';
        return false;
    });
});

function confirmDelete() {
  if (confirm("Are you sure you want to delete")) {
    parent.sub_frame.location = 'about:blank';
  }
}
