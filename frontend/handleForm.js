$(function () {
  let responseOfFeedbacks;

  function displayFeedback(feedbackArray) {
    for (const feedback of feedbackArray) {
      var feedbackElement = $(`<li>
           <div>
             <span>${feedback.name}</span> | <span>${feedback.email}</span> | <span>${feedback.date}</span> 
           </div> 
           <div>${feedback.text}</div>
        </li>`);

      $("#feedbackList").append(feedbackElement);
    }
  }

  //get all feedbacks
  $.ajax({
    type: "GET",

    url: "http://localhost:8000/feedback-post.php",
    success: function (response) {
      console.log("Server response:", response);
      responseOfFeedbacks = response;
      responseOfFeedbacks.sort((a, b) => (b.date > a.date ? 1 : -1));

      displayFeedback(responseOfFeedbacks);
    },
    error: function (error) {
      console.error("Error:", error);
    },
  });

  //sort feedbacks by name
  $("#sortByName").on("click", () => {
    responseOfFeedbacks.sort((a, b) =>
      a.name.toLowerCase() > b.name.toLowerCase() ? 1 : -1
    );

    $("#feedbackList").empty();

    displayFeedback(responseOfFeedbacks);
  });

  //sort feedbacks by email
  $("#sortByEmail").on("click", () => {
    responseOfFeedbacks.sort((a, b) =>
      a.email.toLowerCase() > b.email.toLowerCase() ? 1 : -1
    );

    $("#feedbackList").empty();

    displayFeedback(responseOfFeedbacks);
  });

  //sort feedbacks by date
  $("#sortByDate").on("click", () => {
    responseOfFeedbacks.sort((a, b) => (b.date > a.date ? 1 : -1));

    $("#feedbackList").empty();

    displayFeedback(responseOfFeedbacks);
  });

  $("#feedbackForm").on("submit", function (event) {
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
