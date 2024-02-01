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
            feedback.status == "awaited"
              ? "awaitedStatus status"
              : feedback.status == "denied"
              ? "deniedStatus status"
              : "acceptStatus status"
          }">${feedback.status}</div>

          <div class="${
            feedback.changedByAdmin == "yes"
              ? "changedByAdmin"
              : "notChangedByAdmin"
          }">Changed by admin</div>
         

          <button class="edit-btn" data-id="${feedback.email}">Edit</button>
          
          <div>
             <button class="accept-btn" data-id="${
               feedback.email
             }">Accept</button>

             <button class="deny-btn" data-id="${feedback.email}">Deny</button>
          </div>
          
       
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

  //manage  status
  $("#feedbacksListForAdmin").on("click", ".accept-btn", function () {
    feedbackId = $(this).data("id");
    let clickedButton = $(this);
    $.ajax({
      type: "POST",
      url: "manage-status.php",
      data: { email: feedbackId, status: "accepted" },
      success: function (response) {
        console.log("Server response:", response);
        if (response.success === true) {
          clickedButton
            .closest("li")
            .find(".status")
            .text(response.status)
            .css("color", "#1BA400");
        }
      },
      error: function (error) {
        console.error("Error:", error);
      },
    });
    console.log("accept feedback with ID:", feedbackId);
  });

  $("#feedbacksListForAdmin").on("click", ".deny-btn", function () {
    feedbackId = $(this).data("id");
    let clickedButton = $(this);
    $.ajax({
      type: "POST",
      url: "manage-status.php",
      data: { email: feedbackId, status: "denied" },
      success: function (response) {
        console.log("Server response:", response);
        if (response.success === true) {
          clickedButton
            .closest("li")
            .find(".status")
            .text(response.status)
            .css("color", "#A40200");
        }
      },
      error: function (error) {
        console.error("Error:", error);
      },
    });
    console.log("accept feedback with ID:", feedbackId);
  });
});
