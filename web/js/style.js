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
                                      if ($('.mainContainer').attr('id') === 'addNextGame') {
                                          table += '<button class="btn btn-info calendarButton">0' + day + '</button>';
                                      } else {
                                          table += '<a href="/selectGameType/' + calendar.year + '/' + calendar.month + '/' + day + '/' + j + '"><button class="btn btn-info">' + 0 + day + '</button></a></td>';
                                      }
                                  } else {
                                      if ($('.mainContainer').attr('id') === 'addNextGame') {
                                         table += '<button class="btn btn-info calendarButton">' + day + '</button>'; 
                                      } else {
                                         table += '<a href="/selectGameType/' + calendar.year + '/' + calendar.month + '/' + day + '/' + j + '"><button class="btn btn-info">' + day + '</button></a></td>'; 
                                      }
                                  }
                                  day ++;
                              } else {
                                  table += '<td style="background-color: lightblue">';
                                  if (day < 10) {
                                      if ($('.mainContainer').attr('id') === 'addNextGame') {
                                          table += '<button class="btn btn-success calendarButton">0' + day + '</button>';
                                      } else {
                                          table += '<a href="/selectGameType/' + calendar.year + '/' + calendar.month + '/' + day + '/' + j + '"><button class="btn btn-success">' + 0 + day + '</button></a></td>';
                                      }
                                      
                                  } else {
                                      if ($('.mainContainer').attr('id') === 'addNextGame') {
                                          table += '<button class="btn btn-success calendarButton">' + day + '</button>';
                                      } else {
                                          table += '<a href="/selectGameType/' + calendar.year + '/' + calendar.month + '/' + day + '/' + j + '"><button class="btn btn-success">' + day + '</button></a></td>';
                                      }
                                  }
                                  day ++;
                              }
                          } else {
                              table += '<td></td>';
                          }
                      }
                    table += '</tr>';    
                  }
                  table += '</table>';
                  console.log(table);
                  
                  $('.calendarShow').append(table);
                  buttons();
              }
          });
          
    });
    
    //ustawia miesiąc i rok w select calendar na aktualny czas
    
    function monthAndYear() {
        
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
        
    }

    function buttons() {
        
        $('.calendarButton').click(function() {
        var date = $(this).html()+ '.' + $('#selectMonth').attr('month') + '.' + $('#selectYear').attr('year');
        $('#chosenDate').html(date);
        $('#selectedDate').val(date + '.' + $('#selectMonth').attr('month') + '.' + $('#selectYear').attr('year'));
    });

    $('.calendarButton').click(function() {
        var date = $(this).html()+ '.' + $('#selectMonth').attr('month') + '.' + $('#selectYear').attr('year');
         $('.addNextGameButtonContainer').empty();
        $('.dateAndPlace').empty();
        $('.dateAndPlace').append('<br><h3>Data spotkania:</h3><h2>' + date +'</h2><br><h3>Miejsce spotkania:</h3><form><input type="text" id="gamePlace"></form>');
        
        $('#gamePlace').focusout(function() {
            var place = $('#gamePlace').val();
            $('.addNextGameButtonContainer').empty();
            $('.addNextGameButtonContainer').append('<a href="/saveNewGame/' + date + '/' + place + '"><button class="btn btn-warning" style="font-size: 200%;">Dodaj</button></a>');
        });
    });
    }
    
    function changeMonth() {
        $('#selectMonth').change(function() {
            var selectedMonth = $('select option:selected').val();
            $('#selectMonth').attr('month', selectedMonth);
        });
    }
    
    function changeYear() {
         $('#selectYear').change(function() {
             var selectedYear = $('#selectYear option:selected').val();
             $('#selectYear').attr('year', selectedYear);
         });
    }
    
    changeYear();
    changeMonth();
    monthAndYear();
    buttons();
    
    $('#gameTypeSelect input').click(function () {
        if ($(this).attr('value') == 2) {
            $('.playerList').css('visibility', 'hidden');
            $('#2').css('visibility', 'visible');
            $my_global_var = '.twoOnTwo';
            
        } else if ($(this).attr('value') == 3) {
            $('.playerList').css('visibility', 'hidden');
            $('#3').css('visibility', 'visible');
            $my_global_var = '.threeOnThree';
            
        } else if ($(this).attr('value') == 4) {
            $('.playerList').css('visibility', 'hidden');
            $('#4').css('visibility', 'visible');
            $my_global_var = '.fourOnFour';
            
        } else {
            $('.playerList').css('visibility', 'hidden');
            $('#5').css('visibility', 'visible');
            $my_global_var = '.fiveOnFive';
        }
    });

        $('.addGameResult').click(function() {
            alert($my_global_var);
            var firstTeam = [];
            $('.team1' + $my_global_var + ' option:selected').each(function() {
                firstTeam.push($(this).val());
            });
            var firstTeamScore = $('.firstTeamScore' + $my_global_var).val();

            var secondTeam = [];
            $('.team2' + $my_global_var + ' option:selected').each(function() {
                secondTeam.push($(this).val());
            });
            var secondTeamScore = $('.secondTeamScore' + $my_global_var).val();

            alert(firstTeam);
            alert(secondTeam);
            alert(firstTeamScore);
            alert(secondTeamScore);
            
            $.ajax({
              type: 'POST',
              url: '/addGameResult',
              data: {
                firstTeam: firstTeam,  
                secondTeam: secondTeam,  
                firstTeamScore: firstTeamScore,  
                secondTeamScore: secondTeamScore
              },
              dataType: 'json',
              success: function(player) {
                  alert('Działam!!!');
                  alert(player);
                  console.log(player);
              }
          });
            

        });
    
});
