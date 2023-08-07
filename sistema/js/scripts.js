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

document.addEventListener('click', function(e) {
    var dropdown = document.querySelector('.dropdown');
    if (!dropdown.contains(e.target)) {
      var submenu = dropdown.querySelector('.submenu');
      submenu.style.display = 'none';
    }
  });


  function formatarCNPJ(campo) {
    var cnpj = campo.value.replace(/\D/g, '');
    if (cnpj.length > 14) {
        cnpj = cnpj.slice(0, 14);
    }
    if (cnpj.length === 14) {
        cnpj = cnpj.replace(/^(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})$/, '$1.$2.$3/$4-$5');
    }
    campo.value = cnpj;
}

function formatarCPF(campo) {
    var cpf = campo.value.replace(/\D/g, '');
    if (cpf.length > 11) {
      cpf = cpf.slice(0, 11);
    }
    if (cpf.length === 11) {
      cpf = cpf.replace(/^(\d{3})(\d{3})(\d{3})(\d{2})$/, '$1.$2.$3-$4');
    }
    campo.value = cpf;
  }
  
  function limitarComprimentoCampo(campo) {
    campo.addEventListener("input", function() {
        if (campo.value.length > campo.maxLength) {
            campo.value = campo.value.slice(0, campo.maxLength);
        }
    });
}