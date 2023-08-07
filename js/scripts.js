$(function(){
    $('nav.mobile').click(function(){
        var listaMenu = $('nav.mobile ul');

        if(listaMenu.is(':hidden') == true){
            var icone = $('.botao-menu-mobile').find('i');
            icone.removeClass('fa-sharp fa-solid fa-bars');
            icone.addClass('fa-regular fa-xmark');
            listaMenu.fadeIn();
        }
        else{
            var icone = $('.botao-menu-mobile').find('i');
            icone.removeClass('fa-regular fa-xmark');
            icone.addClass('fa-sharp fa-solid fa-bars');
            listaMenu.fadeOut();
        }
    /* listaMenu.slideToggle */
    
    // abrir e fechar menu sem efeitos

    /* if(listaMenu.is(':hidden') == true){
            listaMenu.show();
        }    
        else{
            listaMenu.hide();
        }
    }
         */
 
 
    // 

  // <i class="fa-regular fa-xmark"></i>

    })
})