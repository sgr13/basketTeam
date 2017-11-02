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
    
    //Zniknięcie/pojawienie się opisów kategorii
    
//    $('.sideMenuHeader').css('display', 'none');
    
//    $('#sideMenuContainer').mouseover(function() {
//        $('.sideMenuHeader').css('display', 'inline');
//    });
    
    
});



