$(function () {
  $("#feedbackForm").submit(function (event) {
    event.preventDefault();

    var formData = {
      name: $("#name").val(),
      email: $("#email").val(),
      text: $("#text").val(),
      date: new Date().toISOString(),
    };

    $.ajax({
      type: "POST",
      url: "http://localhost:8000/feedback-post.php",
      data: formData,
      success: function (response) {
        console.log("Server response:", response);
      },
      error: function (error) {
        console.error("Error:", error);
      },
    });
  });
});
