$(document).ready(function () {
//    alert('hej');
    $('#loginContainer').draggable();
    $('#registerContainer').draggable();
    
//    $('.thumbView').mouseover(function(event) {
//        
//       $('#popUpThumbView').css('display','inline');
//       $('#popUpThumbView').css('left', event.pageX + 'px');
//       $('#popUpThumbView').css('top', event.page + 'px');
//    });
    
    $('.thumbView').mousemove(function(event) {
//        alert($(this).attr('photo'));
       $('#popUpThumbView').css('display','inline');
       $('#popUpImg').attr('src', '/photos/' + $(this).attr('photo'));
       $('#popUpImg').css('display', 'inline');
//       var number = parseInt(event.pageY);
//       alert(number);
//       $('#popUpThumbView').css('left', event.pageX + 'px');
//       $('#popUpThumbView').css('top', '60px');
//       $('#popUpThumbView').css('top', number + 'px');
    });
    
   $('.thumbView').mouseleave(function () {
       $('#popUpThumbView').css('display','none');
   });
});
