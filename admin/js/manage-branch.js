$('.addBtn').click(function(){
    $('#type').val('add')
    $('#exampleModalLabel').text('Add User')

})

$('.deleteBtn').click(function(){
    $('#deleteID').val($(this).attr("data-id"))
})

// $('.editBtn').click(function(){
//      id = $(this).attr("data-id")
//     $("#exampleModal").modal("show");
    
//   $.post({
//     url: "controller/manage-branch.php", // Replace with your server-side script URL
//     data: { update: id }, // Properly format data as an object
//     dataType: "json", // Specify the expected data type of the response
//     success: function(response) {
//         // Handle the response data
//         console.log(response);
//         $('#id').val(response[0])
//           $('#position').val(response[4])
//           $('#name').val(response[1])
//           $('#email').val(response[2])
//           $('#password').val(response[3])
//           $('#exampleModalLabel').text('Update User')
//           $('#type').val('update')
//     },
//     error: function() {
//         // Handle errors
//         $("#result").html("An error occurred.");
//     }
// });
// })

document.addEventListener("DOMContentLoaded", function() {

  var editButtons = document.querySelectorAll('.editBtn');

  editButtons.forEach(function(button) {
      button.addEventListener('click', function() {
      $("#exampleModal").modal("show");
          var id = this.getAttribute("data-id");
          var xhr = new XMLHttpRequest();
          xhr.open("POST", "controller/manage-branch.php", true);
          xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
          
          // Construct the data to be sent
          var data = "update=" + encodeURIComponent(id);

          xhr.onload = function() {
              if (xhr.status >= 200 && xhr.status < 400) {
                  var response = JSON.parse(xhr.responseText);
                  $('#id').val(response[0])
                  $('#name').val(response[1])
                  $('#email').val(response[2])
                  $('#password').val(response[3])
                  $('#exampleModalLabel').text('Update Branch')
                  $('#type').val('update')
                  // Handle the response here
              } else {
                  // Handle errors
                  console.error("Request failed with status: " + xhr.status);
                  document.getElementById("result").innerHTML = "An error occurred.";
              }
          };

          xhr.onerror = function() {
              // Handle network errors
              console.error("Request failed");
              document.getElementById("result").innerHTML = "An error occurred.";
          };

          xhr.send(data);
      });
  });
});




$("#formAdd,#formDelete").submit(function(event) {
    // Prevent the default form submission
    event.preventDefault();

    // Get form data
    var formData = $(this).serialize();

    // Send an Ajax POST request
    $.ajax({
      type: "POST",
      url: "controller/manage-branch.php", // Replace with your server-side script
      data: formData,
      success: function(response) {
        console.log(response)
        if (response === '200') {
          // Show a success SweetAlert
          Swal.fire({
            icon: 'success',
            title: 'Success',
            text: 'Operation successful!',
          }).then(function() {
            // Redirect to index.php
            window.location.href = 'branch.php';
          });
        } else {
          // Show an error SweetAlert
          Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Error!',
          });
        }
      },
      error: function() {
        // Handle errors
        $("#result").html("An error occurred.");
      }
    });
  });

