$(function () {
  let responseOfFeedbacks;

  function Preview(feedbackArray) {
    var feedbackElement = $(`<li>
           <div>
             <span>${feedbackArray.name}</span> | <span>${feedbackArray.email}</span> | <span>${feedbackArray.date}</span> 
           </div> 
           <div>${feedbackArray.text}</div>
        </li>`);

    $("#feedbackList").append(feedbackElement);
  }

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
    url: "handlerForm.php",
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
      url: "handlerForm.php",
      data: formData,
      success: function (response) {
        console.log("Server response:", response);
        responseOfFeedbacks = response;
        Preview(responseOfFeedbacks);
      },
      error: function (error) {
        console.error("Error:", error);
      },
    });
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
});
