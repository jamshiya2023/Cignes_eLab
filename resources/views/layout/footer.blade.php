 <!-- start: page footer -->
            <script>
$(document).ready(function() {
  $('a[data-notification-id]').on('click', function(event) {
    event.preventDefault();
    var token = document.querySelector('meta[name="csrf-token"]').getAttribute("content");
    var notificationId = $(this).data('notification-id');
    var url = $(this).attr('href');

    // Send an AJAX request to update the database
    $.ajax({
       url: "{{'update-notification'}}",
      method: 'POST',
      data: {
        id: notificationId,
         _token: token,
      },
      success: function(response) {
        // If the update was successful, redirect to the URL
        window.location.href = url;
      },
      error: function(xhr, status, error) {
        // Handle the error if the update fails
        console.log(error);
      }
    });
  });
});
</script>
 <footer class="page-footer px-xl-4 px-sm-2 px-0 py-3">
            <div class="container-fluid d-flex flex-wrap justify-content-between align-items-center">
                <p class="col-md-4 mb-0 text-muted">© 2022 <a href="#" target="_blank" title="Cignes">Cignes</a>, All Rights Reserved.</p>
                
                <ul class="nav col-md-4 justify-content-center justify-content-lg-end">
                    <li class="nav-item"><a href="#" target="_blank" class="nav-link px-2 text-muted">Licenses</a></li>
                    <li class="nav-item"><a href="#" target="_blank" class="nav-link px-2 text-muted">Support</a></li>
                    <li class="nav-item"><a href="#" target="_blank" class="nav-link px-2 text-muted">FAQs</a></li>
                </ul>
            </div>
        </footer>