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
                  console.log(calendar);
                  console.log(calendar.year);
                  var day = 1;
                  $('.calendarShow').html('');
                  
                  var table = '\
                <table border="solid" cellpadding="10" class="calendarShow">\n\
                    <tr>\n\
                        <th class="days">Pn</th>\n\
                        <th class="days">Wt</th>\n\
                        <th class="days">Śr</th>\n\
                        <th class="days">Cz</th>\n\
                        <th class="days">Pt</th>\n\
                        <th class="days">Sb</th>\n\
                        <th class="days">Nd</th>\n\
                    </tr>\n';

                  for (i = 1; i <= calendar.numberOfWeeksInMonth; i++) {
                      table += '<tr>';
                      for (var j = 1; j <= 7; j++) {
                          if ((j < calendar.firstDayInMonth && i == 1) || j > calendar.daysInMonth && i == 1) {
                              table += '<td></td>';
                          } else if (day < calendar.daysInMonth + 1) {
                              if (i % 2 == 0) {
                                  table += '<td style="background-color: lightgray">';
                                  if (day < 10) {
                                      table += '<a href="/selectGameType/' + calendar.year + '/' + calendar.month + '/' + day + '/' + j + '"><button class="btn btn-info">' + 0 + day + '</button></a></td>';
                                  } else {
                                      table += '<a href="/selectGameType/' + calendar.year + '/' + calendar.month + '/' + day + '/' + j + '"><button class="btn btn-info">' + day + '</button></a></td>';
                                  }
                                  day ++;
                              } else {
                                  table += '<td style="background-color: lightblue">';
                                  if (day < 10) {
                                      table += '<a href="/selectGameType/' + calendar.year + '/' + calendar.month + '/' + day + '/' + j + '"><button class="btn btn-success">' + 0 + day + '</button></a></td>';
                                  } else {
                                      table += '<a href="/selectGameType/' + calendar.year + '/' + calendar.month + '/' + day + '/' + j + '"><button class="btn btn-success">' + day + '</button></a></td>';
                                  }
                                  day ++;
                              }
                          }
                      }
                    table += '</tr>';    
                  }
                  table += '</table>';
                  console.log(table);
                  
                  $('.calendarShow').append(table);
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
    
    
    $('.calendarButton').click(function() {
        var date = $(this).html()+ '.' + $('#selectMonth').attr('month') + '.' + $('#selectYear').attr('year');
        $('#chosenDate').html(date);
        $('#selectedDate').val(date + '.' + $('#selectMonth').attr('month') + '.' + $('#selectYear').attr('year'));
    });
    
    $('.sendButton').click(function() {
        if ($('#gamePlace').val() == '') {
            $('#gamePlace').after('<span style="color:red">Musisz podać miejsce nastepnego spotkania!</span>');
            event.preventDefault();
        }
        
    })
});
