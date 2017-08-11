
//раскрытие подробнее для конкретного пункта
function toglin(kod_broni, otver)  {
    
    var but = $('.tog');
    
    var phid = kod_broni;    
    var phid2 = "podr" + kod_broni;
    
    var podr = $('div[title = "'+phid+'"]');        
    var podr2 = $('div[title = "'+phid2+'"]');
    
    if($('div[title = "'+phid2+'"]').html() == "Свернуть")  {
        podr.slideUp(500); 
        podr2.html("Развернуть");
    }    
    else if($('div[title = "'+phid2+'"]').html() == "Развернуть" && otver == true)  {
        podr.slideDown(500); 
        podr2.html("Свернуть");
    }    
} 

$(document).ready(

function()    {
    
    //продажи и брони - развернуть - свертывание
    var podr = $('.podrobn');
    podr.slideUp(0);    

    /*
    //кнопки меню
    var butmen = $('.lmen');    
    butmen.hover(function()   {
        $(this).addClass('lmenon');   
    },function()   {
        $(this).removeClass('lmenon');    
    });
    
    //кнопки админа - войти и выйти
    var butadm = $('.adm_link');    
    butadm.hover(function()   {
        $(this).addClass('adm_link_on');    
    },function()   {
        $(this).removeClass('adm_link_on');    
    });
    
    //подчеркивание в афише - месяцы и ссылки 
    var main_link = $('.main_afisha');    
    main_link.hover(function()   {
        $(this).addClass('main_afisha_on');    
    },function()   {
        $(this).removeClass('main_afisha_on');    
    });     

    //подсветка кнопки - продать и забронировать
    var but = $('.tog');    
    but.hover(function()   {
        $(this).addClass('togon');    
    },function()   {
        $(this).removeClass('togon');    
    });
    */

}

);
