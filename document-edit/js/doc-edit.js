$(document).on("click", ".tool li", function (e) {
  var toolId = $(this).data("id");
  var toolName = $(this).data("value");
  // $('.'+toolId).css('display', 'block');
  $("#storage").val(toolId);
  $("#toolName").val(toolName);
  // addMouseMoveListener(toolId)

  var current_click = $("#currentId").val();
  if (current_click != "") {
    removeMouseMoveListener();
    addMouseMoveListener(toolId);
  } else {
    addMouseMoveListener(toolId);
  }
});
$(document).on("click", "#clearSession", function (e) {
  clearCart()
});
function addMouseMoveListener(toolId) {
  var count = 1;
  $(document).bind("mousemove.toolId", function (e) {
    count = count + 1;
    $("." + toolId).attr("id", count);
    $("#currentId").val(count);
    $("." + toolId).css({
      display: "block",
      left: e.pageX + 10,
      top: e.pageY,
    });
  });
}

$(document).on("click", "#mainWrapper", function (e) {
  var storage = $("#storage");
  // console.log(storage);
  if (storage.val() != "") {
    var eId = $("#storage").val();
    var cId = $("#currentId").val();
    $("#" + cId).css("display", "none");
    let toolName = $("#toolName").val();
    var posX = $(this).offset().left;
    var posY = $(this).offset().top;
    let x = e.pageX - posX;
    let y = e.pageY - posY;

    appendToolbox(x, y, eId);
    removeMouseMoveListener();
    storage.val("");
    if (toolName == "Sign") {
      findSignature()
    }
    var action = "add";
    var tool_id = cId;
    var tool_class = "box";
    var tool_text = toolName;
    var tool_top_pos = y;
    var tool_left_pos = x;

    savetoSession(
      action,
      tool_id,
      tool_class,
      tool_text,
      tool_top_pos,
      tool_left_pos,
    );
  }
});

function findSignature() {
  $.ajax({
    url: "inc/find-element.php", //path to send this image data to the server site api or file where we will get this data and convert it into a file by base64
    method: "POST",
    dataType: "json",
    data: {
      findSignature: 1,
    },
    success: function (data) {
      if (data.success == true) {
        // Do nothing
      } else {
        $("#createSignatureModal").modal("show");
      }
    },
  });
}


function savetoSession(
  action,
  tool_id,
  tool_class,
  tool_text,
  tool_top_pos,
  tool_left_pos,
) {
  var tool_qty = 1;
  $.ajax({
    url: "session/action.php",
    method: "POST",
    data: {
      action: action,
      tool_id: tool_id,
      tool_qty: tool_qty,
      tool_class: tool_class,
      tool_text: tool_text,
      tool_top_pos: tool_top_pos,
      tool_left_pos: tool_left_pos,
    },
    success: function (data) {
      load_session_data();
      // move(tool_id)
    },
  });
}

function editSession(
  edit,
  tool_id,
  tool_class,
  tool_text,
  tool_top_pos,
  tool_left_pos,
) {
  var tool_qty = 1;
  $.ajax({
    url: "session/action.php",
    method: "POST",
    data: {
      tool_id: tool_id,
      tool_qty: tool_qty,
      tool_class: tool_class,
      tool_text: tool_text,
      tool_top_pos: tool_top_pos,
      tool_left_pos: tool_left_pos,
      edit: edit,
    },
    success: function (data) {
      load_session_data();
      // move(tool_id)
    },
  });
}

function clearCart() {
  var action = 'empty';
  $.ajax({
    url: "session/action.php",
    method: "POST",
    data: { action: action },
    success: function () {
      load_session_data();
    }
  });
}

load_session_data();
function load_session_data() {
  var document_id = $("#document_id").val();

  console.log(document_id);
  $.ajax({
    url: "session/fetch_session.php",
    method: "POST",
    dataType: "json",
    data: { document_id: document_id },
    success: function (data) {
      // console.log(data.session_details);
      $("#mainWrapper").html(data.session_details);
      $("#shopping_cart").html(data.total_item);
      // $( ".box" ).draggable();
      // console.log(data)
      savedragged();
    },
  });
}

// Add a circle to the document and return its handle
function appendToolbox(x, y, eId) {
  let toolName = $("#toolName").val();
  let newDiv = document.createElement("dl");
  // var cId = $("#currentId").val();
  // console.log(toolName)
  if (toolName == 'Textarea') {
    // var div = '<input aria-invalid="false" type="text"  class="textareaTool" value="">';

    var div = '<div class=" " id="textTool1"><button type="button" class="btn-close deleteItem" data-id="1"></button><div>';
    div += '<input aria-invalid="false" type="text"  class="textareaTool" value=""></div></div>';
    // console.log("Text")
  } else {
    var div = '<div><button type="button" class="btn-close deleteItem"></button>';
    div += "<div>" + toolName + '<i data-feather="arrow-down-right"></i></div>';
    div += "</div>";
    console.log("others")
  }

  $(newDiv).html(div);
  // $(newDiv).attr('id', 'draggable');
  let adjX = x + 10; //click happens in center
  let adjY = y;
  $(newDiv).css("left", adjX);
  $(newDiv).css("top", adjY);
  $("#mainWrapper").append(newDiv);
  return newDiv;
}

$(document).on("click", ".deleteItem", function () {
  $(this).parent().parent().remove();
  var tool_id = $(this).data("id");
  // console.log(tool_id);
  var action = "remove";
  $.ajax({
    url: "session/action.php",
    method: "POST",
    data: { tool_id: tool_id, action: action },
    success: function () {
      load_session_data();
    },
  });
});

function removeMouseMoveListener() {
  $(document).unbind("mousemove");
}

function savedragged() {
  $(".box").each(function () {
    var $elem = $(this);
    var tool_text = $(this).data("name");
    var tool_id = $(this).attr("id");
    var tool_class = "";
    let edit = "edit_product";
    $elem.draggable({
      containment: "#mainWrapper",
      scroll: false,
      stop: function (e, ui) {
        let tool_top_pos = ui.position.top;
        let tool_left_pos = ui.position.left;
        editSession(
          edit,
          tool_id,
          tool_class,
          tool_text,
          tool_top_pos,
          tool_left_pos,
        );
      },
    });
  });
}




