var buildit = 'buildit-desc';
var rateit = 'rate-it';
var waitit = 'wait-it';
var rateitcomplete = 'rate-it-complete';

$(document).ready(function() {

  /* Add onclick behavior form ajax form submit */
  $('#rate-it-do-it').click(function() {
    submit_rating();
  });

  $('#rate-it-close').click(function() {
    build_it();
  });

  $('#rate-it-complete-close').click(function() {
    build_it();
  });
});

function rate_it() {
  $('#' + buildit).hide();
  $('#' + rateitcomplete).hide();
  $('#' + waitit).hide();
  $('#' + rateit).show();
}

function thank_it() {
  $('#' + buildit).hide();
  $('#' + rateit).hide();
  $('#' + waitit).hide();
  $('#' + rateitcomplete).show();
}

function build_it() {
  $('#' + rateitcomplete).hide();
  $('#' + rateit).hide();
  $('#' + waitit).hide();
  $('#' + buildit).show();
}

function wait_it() {
  $('#' + rateitcomplete).hide();
  $('#' + rateit).hide();
  $('#' + buildit).hide();
  $('#' + waitit).show();
}

function submit_rating() {

  var rating = $("input[name=rate_score]:checked").val();
  var textfield = $("#textfield").val();

  if (rating == "" || rating == 0 || rating == null) {
    $("#rate-it-title").addClass('error');
    $("#rate-it-error").show();
    return false;
  }
  if(textfield == "" || textfield == null) {
    return false;
  }

  wait_it();

  var dataString = 'rating='+ rating + '&textfield=' + textfield;

  $.ajax({
    type: "POST",
    url: "scripts/rate_im.php",
    data: dataString,
    success: function() {
      thank_it();
    },
    error: function() {
      pre_check_setup();
    }
   });
  return false;
}

function pre_check_setup() {
  $("#rate-it-title").removeClass('error');
  $("#rate-it-error").hide();
  build_it();
}
