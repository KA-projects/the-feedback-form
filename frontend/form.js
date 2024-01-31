$(function () {
  // Intercept the form submission
  $("#feedbackForm").submit(function (event) {
    // Prevent the default form submission
    event.preventDefault();

    // Get form data
    var formData = {
      name: $("#name").val(),
      email: $("#email").val(),
      text: $("#text").val(),
    };

    // Send the data to the server using Ajax
    $.ajax({
      type: "POST", // or "GET" depending on your server endpoint
      url: "http://localhost:8000/feedback-post.php", // Replace with your actual server endpoint
      data: formData,
      success: function (response) {
        // Handle the server response if needed
        console.log("Server response:", response);
      },
      error: function (error) {
        // Handle errors if the request fails
        console.error("Error:", error);
      },
    });
  });
});
