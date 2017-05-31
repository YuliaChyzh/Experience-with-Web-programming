$(document).ready(function () {
    $('#rectangle').mouseover(function () {
        var position = $(this).position();
        $('#rec1').offset({
          top: position.top + 10,
          left: position.left + 10
        });
        $('#rec3').offset({
          top: position.top + 20,
          left: position.left + 20
        });
    })

    $('#rec1').mouseover(function () {
        var position = $(this).position();
        $('#rectangle').offset({
          top: position.top + 10,
          left: position.left + 10
        });
        $('#rec3').offset({
          top: position.top + 20,
          left: position.left + 20
        });
    })

    $('#rec3').mouseover(function () {
        var position = $(this).position();
        $('#rec1').offset({
          top: position.top + 10,
          left: position.left + 10
        });
        $('#rectangle').offset({
          top: position.top + 20,
          left: position.left + 20
        });
    })


})
