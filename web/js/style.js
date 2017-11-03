$(document).ready(function () {


//Przypisanie pozycji sideMenu po załadowaniu strony do zmiennej a następnie przesunięcie menu poza ekran

    var p1 = $("#sideMenu");
    var offset1 = p1.offset();
    $('#sideMenu').animate({right: "+=100"}, 1);

    $('#sideMenu').mouseover(function() {
        //przypisanie do zmiennej pozycji sideMenu po jego schowaniu a po najechaniu myszką na ukryte menu jego wysunięcie
        var p1 = $("#sideMenu");
        var offset2 = p1.offset();
        $("#sideMenu").offset({ top: offset2.top, left: offset1.left});
    })

    $('#sideMenu').mouseleave(function() {
        //ponowne przypianie pozycji do zmiennej i po opuszczeniu kursora ukrycie sideMenu
        var p1 = $("#sideMenu");
        var offset3 = p1.offset();
        $("#sideMenu").offset({ top: offset3.top, left: offset1.left});
        $("#sideMenu").offset({ top: offset3.top, left: -99.916671752929688});
    });

    //dodanie czarnego podświetlenia do aktywnego elementu sideMenu
    $('.nav li').click(function () {
        $('.nav li').removeClass('actives');
        $(this).addClass('actives');
    });
    
    //Przekazanie wyboru miesiąca i roku
    
    $('#form').click(function() {
          var selectedMonth = $( "#selectMonth option:selected" ).val();
          var selectedYear = $( "#selectYear option:selected" ).val();
          
          $.ajax({
              type: 'POST',
              url: '/selectDay',
              data: {
                selectedYear: selectedYear,  
                selectedMonth: selectedMonth
              },
              dataType: 'json',
              success: function(calendar) {
                  alert('sukces!');
                  console.log(calendar);
                  
                  
                  
              }
          });
          
    });
    
    //ustawia miesiąc i rok w select calendar na aktualny czas
    
    var child = $('#selectMonth').attr('month');
    if (child == 01) {
        $('#jan').attr('selected', 'selected');
    } else if (child == 02) {
        $('#feb').attr('selected', 'selected');
    }else if (child == 03) {
        $('#mar').attr('selected', 'selected');
    }else if (child == 04) {
        $('#apr').attr('selected', 'selected');
    }else if (child == 05) {
        $('#may').attr('selected', 'selected');
    }else if (child == 06) {
        $('#jun').attr('selected', 'selected');
    }else if (child == 07) {
        $('#jul').attr('selected', 'selected');
    }else if (child == 08) {
        $('#aug').attr('selected', 'selected');
    }else if (child == 09) {
        $('#sep').attr('selected', 'selected');
    }else if (child == 10) {
        $('#oct').attr('selected', 'selected');
    }else if (child == 11) {
        $('#nov').attr('selected', 'selected');
    } else {
        $('#dec').attr('selected', 'selected');
    }

    
    var year = $('#selectYear').attr('year');

    if (year == 2017) {
        $('#2017').attr('selected', 'selected');
    } else if (year == 2018) {
        $('#2018').attr('selected', 'selected');
    } else if (year == 2019) {
        $('#2019').attr('selected', 'selected');
    } else {
        $('#2020').attr('selected', 'selected');
    }
    
    
});



