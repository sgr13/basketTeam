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
              url: '/addNextGame',
              data: {
                selectedYear: selectedYear,  
                selectedMonth: selectedMonth
              },
              dataType: 'json',
              success: function(calendar) {
                  var day = 1;
                  $('table').html('');
                  
                  var table = '\
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
                          if ((j < calendar.firstDayInMonth && i === 1) || j > calendar.daysInMonth && i === 1) {
                              table += '<td></td>';
                          } else if (day < calendar.daysInMonth + 1) {
                              if (i % 2 === 0) {
                                  table += '<td style="background-color: lightgray">';
                                  if (day < 10) {
                                      if ($('.mainContainer').attr('id') === 'addNextGame') {
                                          table += '<button class="btn btn-info calendarButton"><span>0' + day + '</span></button>';
                                      } else {
                                          table += '<a href="/selectGameType/' + calendar.year + '/' + calendar.month + '/' + day + '/' + j + '"><button class="btn btn-info">' + 0 + day + '</button></a></td>';
                                      }
                                  } else {
                                      if ($('.mainContainer').attr('id') === 'addNextGame') {
                                         table += '<button class="btn btn-info calendarButton"><span>' + day + '</span></button>'; 
                                      } else {
                                         table += '<a href="/selectGameType/' + calendar.year + '/' + calendar.month + '/' + day + '/' + j + '"><button class="btn btn-info">' + day + '</button></a></td>'; 
                                      }
                                  }
                                  day ++;
                              } else {
                                  table += '<td style="background-color: lightblue">';
                                  if (day < 10) {
                                      if ($('.mainContainer').attr('id') === 'addNextGame') {
                                          table += '<button class="btn btn-success calendarButton"><span>0' + day + '</span></button>';
                                      } else {
                                          table += '<a href="/selectGameType/' + calendar.year + '/' + calendar.month + '/' + day + '/' + j + '"><button class="btn btn-success">' + 0 + day + '</button></a></td>';
                                      }
                                      
                                  } else {
                                      if ($('.mainContainer').attr('id') === 'addNextGame') {
                                          table += '<button class="btn btn-success calendarButton"><span>' + day + '</span></button>';
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
        var date = $(this).find('span').html()+ '.' + $('#selectMonth').attr('month') + '.' + $('#selectYear').attr('year');
        var place = $('#placeSelection option:selected').val();
        $('.addNextGameButtonContainer span:nth-child(3)').html(date);
        $('.addNextGameButtonContainer span:nth-child(5)').html(place);
        $('#buttonSpot').html('');
        $('#buttonSpot').append('<a href="/saveNewGame/' + date + '/' + place + '"><button class="btn btn-warning">Dodaj</button></a>');
        
        $('#placeSelection').change(function () {
            var place = $('#placeSelection option:selected').val();
            var date = $('.addNextGameButtonContainer span:nth-child(3)').html();
            $('.addNextGameButtonContainer span:nth-child(5)').html(place);
            $('#buttonSpot').html('');
            $('#buttonSpot').append('<a href="/saveNewGame/' + date + '/' + place + '"><button class="btn btn-warning">Dodaj</button></a>');
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
                  
                  $('#containerMain').html('');
                  $('#containerMain').html('<h1>Dodano nowe spotkanie</h1><a href="/adminPanel"><button class="btn btn-success">OK!</button></a>');
  
              }
          });
        });
        
//        var selectedPlayers = [];
        
//        
//        $('.playerSelect').change(function() {
//            var selectedPlayers = []
//            $('.myRow option:selected').each(function() {
//                alert($(this).html());
//                selectedPlayers.push($(this).attr('value'));
//                alert(selectedPlayers);
                
//           });
           
//           $.ajax({
//              type: 'POST',
//              url: '/checkSelectedPlayers',
//              data: {
//                selectedPlayers: selectedPlayers,  
//              },
//              success: function(response) {
//                  console.log(response);
//                  $('.playerSelect').each(function() {
//                     $(this).html(''); 
//                  });
//              }
//                
//            });
//           
//        });
        
        
        $('#acceptResultButton').click(function (e) {
            var selectedPlayers = [];
            var result = [];
            $('#eightRow span').css('display', 'none');
            $('.myRow option:selected').each(function() {
                selectedPlayers.push($(this).attr('value'));
           });
           
           $('#eightRow input').each(function(e) {
                if ($(this).val() === '' || !$.isNumeric($(this).val())) {
                    $('#eightRow span').css('display', 'inline');
                    e.stopPropagation();
                }
                result.push($(this).val());
                
           });
           
           var date = $('.mainContainerResult').attr('value');;
           
           $.ajax({
              type: 'POST',
              url: '/addGameResultAjax',
              data: {
                selectedPlayers: selectedPlayers,
                result: result,
                date: date
              },
              dataType: 'json',
              success: function(response) {
                  alert(response);
                  console.log(response);
                  
                  $('#successMsg').css('display', 'inline');
                  $('#successMsg').draggable();
                  $('#acceptResultButton').addClass('disabled');
                  ('input').prop('disabled', true);
                  
              }
           
        });
        
        });
        
        $('#successMsg').draggable();
        
        
});
