
//��������� ��������� ��� ����������� ������
function toglin(kod_broni, otver)  {
    
    var but = $('.tog');
    
    var phid = kod_broni;    
    var phid2 = "podr" + kod_broni;
    
    var podr = $('div[title = "'+phid+'"]');        
    var podr2 = $('div[title = "'+phid2+'"]');
    
    if($('div[title = "'+phid2+'"]').html() == "��������")  {
        podr.slideUp(500); 
        podr2.html("����������");
    }    
    else if($('div[title = "'+phid2+'"]').html() == "����������" && otver == true)  {
        podr.slideDown(500); 
        podr2.html("��������");
    }    
} 

$(document).ready(

function()    {
    
    //������� � ����� - ���������� - �����������
    var podr = $('.podrobn');
    podr.slideUp(0);    

    /*
    //������ ����
    var butmen = $('.lmen');    
    butmen.hover(function()   {
        $(this).addClass('lmenon');   
    },function()   {
        $(this).removeClass('lmenon');    
    });
    
    //������ ������ - ����� � �����
    var butadm = $('.adm_link');    
    butadm.hover(function()   {
        $(this).addClass('adm_link_on');    
    },function()   {
        $(this).removeClass('adm_link_on');    
    });
    
    //������������� � ����� - ������ � ������ 
    var main_link = $('.main_afisha');    
    main_link.hover(function()   {
        $(this).addClass('main_afisha_on');    
    },function()   {
        $(this).removeClass('main_afisha_on');    
    });     

    //��������� ������ - ������� � �������������
    var but = $('.tog');    
    but.hover(function()   {
        $(this).addClass('togon');    
    },function()   {
        $(this).removeClass('togon');    
    });
    */

}

);
