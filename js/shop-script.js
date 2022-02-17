$(document).ready(function(){
    
   
 //Типа новости но не рабочие   
    $("#newssticker").jCarouselLite({
        vertical: true;
        hoverPause: true;
        btnPrev: "#strela-up",
        btnNext: "#strela-down",
        visible: 3,
        auto: 3000,
        speed:        
    });
    
//Переключатель сортировки
  
  $("#style-grid").click(function(){
    
    $("#block-tovar-grid").show();
    $("#block-tovar-list").hide();
    
    $("#style-grid").attr("src=","/images/tabl1.jpg");
    $("#style-list").attr("src=","/images/listing.jpg");
    
    $.cookie('select_style','grid');
  });
  
    $("#style-list").click(function(){
    
    $("#block-tovar-grid").hide();
    $("#block-tovar-list").show();
    
    $("#style-list").attr("src=","/images/listing1.jpg");
    $("#style-grid").attr("src=","/images/tabl.jpg");
    
    $.cookie('select_style','list');
    
  });   
    if($.cookie('select_style')=='grid'){
        $("#block-tovar-grid").show();
        $("#block-tovar-list").hide();
    
        $("#style-grid").attr("src=","/images/tabl1.jpg");
        $("#style-list").attr("src=","/images/listing.jpg");  
    }
    else{
         $("#block-tovar-grid").hide();
         $("#block-tovar-list").show();
    
        $("#style-list").attr("src=","/images/listing1.jpg");
        $("#style-grid").attr("src=","/images/tabl.jpg");
    }
    
  $("#select-sort").click(function(){
    $("#sorting-list").slideToggle(200);
  });
  
  
 //Слайдер по моделям авто
  
  $('#block-category > ul > li > a').click(function(){
    if($(this).attr('class') !='active'){
        $('#block-category > ul > li > ul').slideUp(400);
        $(this).next().slideToggle(400);
            $('#block-category > ul > li > a').removeClass('active');
            $(this).addClass('active');
            $.cookie('select_cat', $(this).attr('id'));
            }
            else{
                
            $('#block-category > ul > li > a').removeClass('active');
            $('#block-category > ul > li > ul').slideUp(400);
            $.cookie('select_cat', '');
            }
    });
if($.cookie('select_cat')!=''){
    $('#block-category > ul > li > #'+$.cookie('select_cat')).addclass('active').next().show();
}
});  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
    
    
    
    
});