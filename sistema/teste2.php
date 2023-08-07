<!DOCTYPE html>
<html>
<head>
  <title>Página de Controle</title>
  <link rel="stylesheet" href="css/style.css">
  <style>
    /* Estilos CSS */
    body {
      margin: 0;
      padding: 0;
      font-family: Arial, sans-serif;
    }

    /* Mural de Avisos */
    .mural-avisos {
      margin: 0 auto;
      width: 400px;
      height: 300px;
      background-color: #e0e0e0;
      margin-top: 100px;
      padding: 20px;
      overflow: hidden;
      position: relative;
    }

    /* Itens do Mural de Avisos */
    .mural-item {
      display: none;
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      transition: opacity 0.5s ease-in-out;
    }

    .mural-item.active {
      display: block;
    }

    /* Botões de Navegação */
    .navegacao {
      text-align: center;
      margin-top: 10px;
    }
  </style>
</head>
<body>
    <section class="conteudo-pag">
  <div class="mural-avisos">
    <div class="mural-item active">
      <h2>Aviso 1</h2>
      <p>Conteúdo do aviso 1...</p>
    </div>
    <div class="mural-item">
      <h2>Aviso 2</h2>
      <p>Conteúdo do aviso 2...</p>
    </div>
    <div class="mural-item">
      <h2>Aviso 3</h2>
      <p>Conteúdo do aviso 3...</p>
    </div>
    <div class="mural-item">
      <h2>Aviso 4</h2>
      <p>Conteúdo do aviso 4...</p>
    </div>
  </div>

  <div class="navegacao">
    <button onclick="anterior()">Anterior</button>
    <button onclick="proximo()">Próximo</button>
  </div>

  <script>
    // JavaScript para o Carrossel de Avisos
    const mural = document.querySelector('.mural-avisos');
    const itens = document.querySelectorAll('.mural-item');
    const btnAnterior = document.querySelector('button:first-of-type');
    const btnProximo = document.querySelector('button:last-of-type');
    let index = 0;

    function mostrarItem(index) {
      itens.forEach((item, i) => {
        if (i === index) {
          item.classList.add('active');
        } else {
          item.classList.remove('active');
        }
      });
    }

    function anterior() {
      if (index === 0) {
        index = itens.length - 3;
      } else {
        index--;
      }
      mostrarItem(index);
    }

    function proximo() {
      if (index === itens.length - 3) {
        index = 0;
      } else {
        index++;
      }
      mostrarItem(index);
    }
  </script>
  </section>
</body>
</html>