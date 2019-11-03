$(document).ready(function() {
  var $sendMessage = $("div#sendmessage");
  var $errorMessage = $("div#errormessage");

  // just for the demos, avoids form submit
  jQuery.validator.setDefaults({
    debug: true,
    success: "valid"
  });

  $("button#submit").click(function(event) {
    event.preventDefault(); //prevent default action

    var $form = $("form#contactUsForm");

    $form.validate({
      wrapper: "span",
      errorPlacement: function(error, element) {
        error.css({
          "padding-left": "10px",
          "margin-right": "20px",
          "padding-bottom": "2px"
        });
        error.addClass("arrow");
        error.insertAfter(element);
      },
      rules: {
        errorClass: "validation",
        name: {
          required: true,
          normalizer: function(value) {
            // Trim the value of the `field` element before
            // validating. this trims only the value passed
            // to the attached validators, not the value of
            // the element itself.
            return $.trim(value);
          }
        },
        email: {
          required: true,
          email: true,
          normalizer: function(value) {
            // Trim the value of the `field` element before
            // validating. this trims only the value passed
            // to the attached validators, not the value of
            // the element itself.
            return $.trim(value);
          }
        },
        companyName: {
          required: true,
          normalizer: function(value) {
            // Trim the value of the `field` element before
            // validating. this trims only the value passed
            // to the attached validators, not the value of
            // the element itself.
            return $.trim(value);
          }
        },
        subject: {
          required: true,
          normalizer: function(value) {
            // Trim the value of the `field` element before
            // validating. this trims only the value passed
            // to the attached validators, not the value of
            // the element itself.
            return $.trim(value);
          }
        },
        message: {
          required: true,
          normalizer: function(value) {
            // Trim the value of the `field` element before
            // validating. this trims only the value passed
            // to the attached validators, not the value of
            // the element itself.
            return $.trim(value);
          }
        },
        companySizeId: {
          required: true,
          normalizer: function(value) {
            // Trim the value of the `field` element before
            // validating. this trims only the value passed
            // to the attached validators, not the value of
            // the element itself.
            return $.trim(value);
          }
        },
        serviceId: {
          required: true,
          normalizer: function(value) {
            // Trim the value of the `field` element before
            // validating. this trims only the value passed
            // to the attached validators, not the value of
            // the element itself.
            return $.trim(value);
          }
        }
      }
    });

    var isValid = $form.valid();
    if (isValid) {
      $(this).attr("disabled", true);
      var post_url = $form.attr("action"); //get form action url
      var form_data = $form.serialize(); //Encode form elements for submission

      $.post(post_url, form_data, function(response, textStatus, jqXHR) {
        if (jqXHR.status === 200) {
          //OK
          $form.fadeOut("slow");
          $errorMessage.hide("fast");
          $sendMessage
            .show()
            .delay(2000)
            .fadeOut();
            $("section#contact")
            .delay(2000)
            .fadeOut("slow");
        } else {
          $(this).removeAttr("disabled");
          $sendMessage.hide("fast");
          $errorMessage
            .show()
            .delay(3000)
            .fadeOut();
        }

        $form.trigger("reset");
      });
    }
  });
});
