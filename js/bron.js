var kolvo=0;
var sumzak=0;

var riad = new Array(5);
riad[0]=0;
riad[1]=0;
riad[2]=0;
riad[3]=0;
riad[4]=0;

var mest = new Array(5);
mest[0]=0;
mest[1]=0;
mest[2]=0;
mest[3]=0;
mest[4]=0;

var cen = new Array(5);
cen[0]=0;
cen[1]=0;
cen[2]=0;
cen[3]=0;
cen[4]=0;

var ryadr=0;
var mestr=0;
var cenr=0;

var color1 = new Array();
color1[0] = '#fdf7dd'; 
color1[1] = '#fee3da';

var color2 = new Array();
color2[0] = '#fdd104';
color2[1] = '#c87e79';

var color3 = new Array();
color3[0] = 'rgb(253, 247, 221)';
color3[1] = 'rgb(254, 227, 218)';

var color4 = new Array();
color4[0] = 'rgb(253, 209, 4)';
color4[1] = 'rgb(200, 126, 121)';

function proverka(ryadr1, mestr1, kolv) {
    
    for(var i=0; i<kolv; i++)   {        
        if(riad[i] == ryadr1 && mest[i] == mestr1)   {
            riad[i] = 0;
            mest[i] = 0;  
            cen[i] = 0;            
        }
    }
    
    for(var i=0; i<kolv; i++)   {
        if(riad[i] == 0 && mest[i] == 0 && riad[i+1] != 0 && mest[i+1] != 0)   {
            riad[i] = riad[i+1];
            mest[i] = mest[i+1];
            cen[i] = cen[i+1];
            riad[i+1] = 0;
            mest[i+1] = 0;
            cen[i+1] = 0; 
        }
    }
}

//переменна€ flag - флаг бронировани€ или продажи дл€ проверки максимального количества выбранных мест

function process_frag3(stl, flag2) {
     var expr=$(stl).css("background-color");
     var rabr;
     var stlr=stl;
     rabr=stlr.indexOf("col");
     rabm=stlr.indexOf("_");
     rabc=stlr.indexOf("-");
     ryadr=stlr.substring(rabr+3,rabm);
     mestr=stlr.substring(rabm+1,rabc);
     price=parseInt(stlr.substring(rabc+1));
     cenr=price;
     $('#idstyle').html(stl);
     $('#fstnajd').html(rabr);
     $('#scndnajd').html(rabm);
     $('#idryad').html(ryadr);
     $('#idmesto').html(mestr);

     switch (expr) {         
         case color4[0]: {
           $(stl).css("background-color", color3[0]);
           kolvo--;
           sumzak-=price;
           $('#kolvo').html(kolvo);
           $('#sumzak').html(sumzak + " грн");
           proverka(ryadr, mestr, kolvo);
           break;
         }
         case color2[0]: {
           $(stl).css("background-color", color1[0]);
           kolvo--;
           sumzak-=price;
           $('#kolvo').html(kolvo);
           $('#sumzak').html(sumzak + " грн");
           proverka(ryadr, mestr, kolvo);
           break;
         }
         case color4[1]: {
           $(stl).css("background-color", color3[1]);
           kolvo--;
           sumzak-=price;
           $('#kolvo').html(kolvo);
           $('#sumzak').html(sumzak + " грн");
           proverka(ryadr, mestr, kolvo);
           break;
         }       
         case color2[1]: {
           $(stl).css("background-color", color1[1]);
           kolvo--;
           sumzak-=price;
           $('#kolvo').html(kolvo);
           $('#sumzak').html(sumzak + " грн");
           proverka(ryadr, mestr, kolvo);
           break;
         }
    }
     
     if(kolvo >= 5 && flag2 != 1)  {
        alert("¬ы можете забронировать максимум 5 билетов!");  
        return;
     }
  
     switch (expr) {
         case color3[0]: {
           $(stl).css("background-color", color4[0]);
           kolvo++;
           sumzak+=price;
           $('#kolvo').html(kolvo);
           $('#sumzak').html(sumzak + " грн");
           riad[kolvo-1] = ryadr;
           mest[kolvo-1] = mestr;
           cen[kolvo-1] = cenr;
           break;
         }
         case color1[0]: {
           $(stl).css("background-color", color2[0]);
           kolvo++;
           sumzak+=price;
           $('#kolvo').html(kolvo);
           $('#sumzak').html(sumzak + " грн");
           riad[kolvo-1] = ryadr;
           mest[kolvo-1] = mestr;
           cen[kolvo-1] = cenr;
           break;
         }
         case color3[1]: {
           $(stl).css("background-color", color4[1]);
           kolvo++;
           sumzak+=price;
           $('#kolvo').html(kolvo);
           $('#sumzak').html(sumzak + " грн");
           riad[kolvo-1] = ryadr;
           mest[kolvo-1] = mestr;
           cen[kolvo-1] = cenr;
           break;
         }
         case color1[1]: {
           $(stl).css("background-color", color2[1]);
           kolvo++;
           sumzak+=price;
           $('#kolvo').html(kolvo);
           $('#sumzak').html(sumzak + " грн");
           riad[kolvo-1] = ryadr;
           mest[kolvo-1] = mestr;
           cen[kolvo-1] = cenr;
           break;
         }  
     }
     
     var str = "";
     var str2 = "";
     var flag = true;
     
     for(var i=0; i<kolvo; i++) {
        if(riad[i] != 0 && mest[i] != 0)    {
            str += "–€д " + riad[i] + " ћесто " + mest[i] + " ÷ена " + cen[i] + " грн " + '<br/>';
            str2 += riad[i]+"_"+mest[i]+"_"+ cen[i] + " ";
            $('#mesta').html(str);
            $('input#strmest').val(str2);
            flag = false;    
        }
     }
     
     if(flag == true)   {
        $('#mesta').html("");
        $('input#strmest').val("");   
     }
     
     $('input#kolv').val(kolvo);
     
     $('input#sum').val(sumzak);
 } 