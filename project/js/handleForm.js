$(function () {
  let responseOfFeedbacks;
  const awaitedStatus = "awaited";
  const deniedStatus = "denied";

  function displayFeedback(feedbackArray) {
    for (const feedback of feedbackArray) {
      if (
        feedback.status === awaitedStatus ||
        feedback.status === deniedStatus
      ) {
        continue;
      }

      var feedbackElement = $(`<li>
      <div>
        <span>${feedback.name}</span> | <span>${
        feedback.email
      }</span> | <span>${feedback.date}</span> 
      </div> 
      <div>${feedback.text}</div>

       <input type="file" class="imageInput" accept=".jpg, .gif, .png">
         <button data-email="${
           feedback.email
         }" class="uploadButton">Upload Image</button>
          <div class="imageContainer"></div>

      <div class="${
        feedback.changedByAdmin == "yes"
          ? "changedByAdmin"
          : "notChangedByAdmin"
      }">Changed by admin</div>
     </li>`);

      $("#feedbackList").append(feedbackElement);
    }
  }

  function Preview(feedbackArray) {
    var feedbackElement = $(`<li>
           <div>
             <span>${feedbackArray.name}</span> | <span>${feedbackArray.email}</span> | <span>${feedbackArray.date}</span> 
           </div> 
           <div>${feedbackArray.text}</div>
        </li>`);

    $("#feedbackList").append(feedbackElement);
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

  //add feedback
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

        if (responseOfFeedbacks.success) {
          Preview(responseOfFeedbacks);
        } else {
          alert(responseOfFeedbacks.message);
        }
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

  //add image
  $("#feedbackList").on("click", ".uploadButton", function () {
    let email = $(this).data("email");
    let image = $(this).closest("li").find(".imageInput")[0];
    let imageContainer = $(this).closest("li").find(".imageContainer");

    var file = image.files[0];
    if (file) {
      var formData = new FormData();
      formData.append("image", file);

      $.ajax({
        type: "POST",
        url: "upload.php",
        data: formData,
        processData: false,
        contentType: false,
        success: function (response) {
          console.log("Server response:", response);

          let imageUrl = response.imageUrl;

          if (imageUrl) {
            imageContainer.html(`<img src="${imageUrl}" alt="Uploaded Image">`);
          } else {
            alert(response.error);
          }
        },
        error: function (error) {
          console.error("Error:", error);
        },
      });
    } else {
      alert("Please select an image.");
    }
  });
});
