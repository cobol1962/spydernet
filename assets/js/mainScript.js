$(document).ready(function() {
  $("#step1").addClass("in")
  jQuery.validator.setDefaults({
    debug: true,
    success: "valid"
  });
  $( "#link" ).validate({
    rules: {
      url: {
        required: true,
        url: true
      }
    },
    submitHandler: function(form) {
      getPage();
    }
  });
  document.getElementById("tags_jstree").addEventListener( "contextmenu", function(e) {
    if (parseInt($(e.target).closest("li").attr("aria-level")) > 2) {
        e.preventDefault();
        setTimeout(function() {
          $(".vakata-context.jstree-contextmenu.jstree-default-contextmenu").find("li").eq(0).hide();
        }, 250);
        return false;
    }
  });

  $('#tags_jstree').jstree({
    "types": {
        "default": {
            "max_children": -2,
            "max_depth": 2
        }
    },
       'core' : {
       'data' : {
               'url' : '/api/tags.php?operation=get_node',
               'data' : function (node) {
                 return { 'id' : node.id };
               },
               "dataType" : "json"
             }
             ,'check_callback' : true,
             'themes' : {
               'responsive' : false
             }
       },
       'plugins' : ['state','contextmenu','wholerow']
         }).on('create_node.jstree', function (e, data) {
           if (data.node.parents.length > 3) {
             console.log(data)
             $("#" + data.node.id).remove()
             return false;
           }
           $.get('/api/tags.php?operation=create_node', { 'id' : data.node.parent, 'position' : data.position, 'text' : data.node.text })
             .done(function (d) {
               data.instance.set_id(data.node, d.id);
             })
             .fail(function () {
               data.instance.refresh();
             });

         }).on('rename_node.jstree', function (e, data) {
           $.get('/api/tags.php?operation=rename_node', { 'id' : data.node.id, 'text' : data.text })
             .fail(function () {
               data.instance.refresh();
             });
         }).on('delete_node.jstree', function (e, data) {
               $.get('/api/tags.php?operation=delete_node', { 'id' : data.node.id })
                     .fail(function () {
                     data.instance.refresh();
               });

         }).on('select_node.jstree', function (e, data) {


         });
})
function getPage() {

  if ($("#url").val().indexOf(".php?") > -1) {
    swal({
      type: "info",
      text: "Unsupported for now. Comming soon."
    })
    return;
  }
  var u = $("#url").val();
  var pf = u.split("//")[0] + "//";
  u = u.replace("http://", "").replace("https://", "");
  u = pf + u.split("/")[0];

  var obj = {
    url: $("#url").val(),
    tags: $("#tags").val(),
    host: u
  }
//  $("#text_received")[0].style.height = 0 + "px";
//  $("#text_received").attr("src", "show.php?url=" + $("#url").val());

  api.call("getPage", function(res) {
    if (res.status == "ok") {
      $("#text_received").attr("src", res.src);

    }
  }, obj, {})
}
function frameLoaded(obj) {
  obj.style.height = obj.contentWindow.document.body.scrollHeight + 'px';
  setTimeout(function() {
    highlightTerms();
  }, 2000)

}
function highlightTerms() {
  var dtags = [];
  var iBody = $("#text_received").contents().find("body");
  $.each($("#tags").val(), function() {
    var tg = this;
    api.call("getTags", function(res) {
      $.each(res, function() {
        iBody.highlight(this, tg);
      });
    }, { tag: this }, {});
  });

  $.each(iBody.find(".highlight"), function() {
    $(this).css({
      backgroundColor: "#03b2df"
    })
  })
  $.each($("#tags").val(), function () {
    var c = 0;
    var ths = this;
    $.each(iBody.find("[search]"), function() {
      if (ths.toUpperCase() == $(this).attr("search").toUpperCase()) {
        c++;
      }
    })
    $.each($(".tag.label.label-info"), function() {
      if ($(this).text().toUpperCase() == ths.toUpperCase()) {
        $(this).text($(this).text() + "");
        $("<span data-role='remove'></span>").appendTo($(this));
        $(this).css({
          backgroundColor: ((c > 0) ? "yellow" : "red"),
          color: ((c > 0) ? "#03b2df" : "white")
        })
      }
    })
  })
}
function utf8Decode(utf8String) {
    var unicodeString = utf8String.replace(
        /[\u00e0-\u00ef][\u0080-\u00bf][\u0080-\u00bf]/g,  // 3-byte chars
        function(c) {  // (note parentheses for precedence)
            var cc = ((c.charCodeAt(0)&0x0f)<<12) | ((c.charCodeAt(1)&0x3f)<<6) | ( c.charCodeAt(2)&0x3f);
            return String.fromCharCode(cc); }
    ).replace(
        /[\u00c0-\u00df][\u0080-\u00bf]/g,                 // 2-byte chars
        function(c) {  // (note parentheses for precedence)
            var cc = (c.charCodeAt(0)&0x1f)<<6 | c.charCodeAt(1)&0x3f;
            return String.fromCharCode(cc); }
    );
    return unicodeString;
}
