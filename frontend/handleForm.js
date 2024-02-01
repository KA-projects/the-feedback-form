$(function () {
  $.ajax({
    type: "GET",
    url: "http://localhost:8000/feedback-post.php",
    success: function (response) {
      console.log("Server response:", response);

      for (const feedback of response) {
        var feedbackElement = $(`<li>
       <div>
         <span>${feedback.name} <span/> <span>${feedback.email} <span/> <span>${feedback.date}<span/> 
       </div> 

        <div>${feedback.text}</div>
      </li>`);

        $("#feedbackList").append(feedbackElement);
      }
    },
    error: function (error) {
      console.error("Error:", error);
    },
  });

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
