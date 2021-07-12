<?php 
/* Template Name: Contato */

get_header();
?>
<section id="Blog" class="container">
  <h1 class="archive-title">Contato</h1>
  <h2>Deixe sua mensagem</h2>
  <div class="contato-content">
    <div>
      <form class="contato-form" onsubmit="submitMail(event)">
        <fieldset>
          <label for="">
            Nome:
            <input class="form-part" name="nome" type="text" placeholder="Digite seu nome">
          </label>
          <label for="">
            Telefone:
            <input class="form-part"  name="tel" type="text" placeholder="Digite seu telefone">
          </label>
          <label for="">
            E-mail:
            <input class="form-part"  name="email" type="text" placeholder="Digite seu email">
          </label>
        </fieldset>
        <label>
          Mensagem:
          <textarea class="form-part"  name="msg" id="" placeholder="Digite sua mensagem"></textarea>
        </label>
        <span class="break-row">
        </span>
      <button type="submit"  id="contato-button">Enviar</button>
      </form>
    </div>
    <div id="contato-dados">
      <h5>Endereço</h5>
      <span id="endereco">Rua Escritor Nilo Pereira, 2905</span>
      <small id="detalhes-endereco">(Esquina da Av. Tropical) - CEP 59066-330 San Vale Pitimbu</small>
      <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1179.970851243558!2d-35.221862987249175!3d-5.865038942722999!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x7b255f0ace5ce49%3A0xb71648356a43692!2zR2lyZWggUmVjZXDDp8O1ZXM!5e0!3m2!1spt-BR!2sbr!4v1625863524500!5m2!1spt-BR!2sbr" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
      <h5>Telefone</h5>
      <span id="telefone">(84)4002-8922</span>
    </div>
  </div>
</section>
<?php
    get_footer();?>