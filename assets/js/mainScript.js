$(document).ready(function() {
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
})
function getPage() {
  var obj = {
    url: $("#url").val(),
    tags: $("#tags").val()
  }
  api.call("getPage", function(res) {
    if (res.status == "ok") {
      $("#text_received").html(utf8Decode(res.text));
      $.each($("#tags").val(), function() {
        var ths = this;
        $("#text_received").highlight(this);
        $(".highlight").css({
          backgroundColor: "yellow"
        })
      })
      var tg = [];
      $.each($("#tags").val(), function() {
        tg.push(this.toUpperCase());
      })
    var hg = [];
    $.each($(".highlight"), function() {
      hg.push($(this).text().toUpperCase());
    })
    console.log(hg)
      $.each($(".tag.label.label-info"), function() {
        if (hg.indexOf($(this).text().toUpperCase()) > -1) {
          $(this).css({
            backgroundColor: "yellow",
            color: "blue"
          })
        } else {
          $(this).css({
            backgroundColor: "red"
          })
        }
      })

    }
  }, obj, {})
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
