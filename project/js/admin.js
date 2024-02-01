$(function () {
  let responseOfFeedbacks;

  function displayFeedback(feedbackArray) {
    for (const feedback of feedbackArray) {
      var feedbackElement = $(`<li id='${feedback.email}'>
          <div>
            <span>${feedback.name}</span> | <span>${
        feedback.email
      }</span> | <span>${feedback.date}</span> 
          </div> 
          <div class="editable">${feedback.text}</div>

          <div class="${
            feedback.changedByAdmin == "yes"
              ? "changedByAdmin"
              : "notChangedByAdmin"
          }">Changed by admin</div>

          <button class="edit-btn" data-id="${feedback.email}">Edit</button>
       
         </li>`);

      $("#feedbacksListForAdmin").append(feedbackElement);
    }
  }

  //GET
  $.ajax({
    type: "GET",
    url: "handlerAdmin.php",
    success: function (response) {
      console.log("Server response:", response);
      responseOfFeedbacks = response;

      displayFeedback(responseOfFeedbacks);
    },
    error: function (error) {
      console.error("Error:", error);
    },
  });

  let feedbackId;
  $("#feedbacksListForAdmin").on("click", ".edit-btn", function () {
    feedbackId = $(this).data("id");
    $("#editedEmail").text(feedbackId);
    console.log("Editing feedback with ID:", feedbackId);
  });

  $("#editFeedback").on("submit", (e) => {
    e.preventDefault();
    let feedbackText = $(this).find("textarea[name='text']").val();

    $.ajax({
      type: "POST",
      url: "handlerAdmin.php",
      data: { email: feedbackId, text: feedbackText },
      success: function (response) {
        console.log("Server response:", response);
        if (response === 1) {
          $(`#${$.escapeSelector(feedbackId)}`)
            .find(".editable")
            .text(feedbackText)
            .after('<div class="changedByAdmin">Changed by admin</div>');
        }
      },
      error: function (error) {
        console.error("Error:", error);
      },
    });
  });
});
