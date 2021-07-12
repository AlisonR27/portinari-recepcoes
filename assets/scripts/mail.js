function submitMail(ev) {
  ev.preventDefault();
  const formData = {}
  for(const elem of Array.from(document.querySelectorAll('.form-part'))){
    formData[elem.name] = elem.value;
  }
  fetch(apiURL+'sendMail', {
    method: 'POST',
    headers:{
      'Accept': 'application/json',
      'Content-Type': 'application/json'
    },
    body: JSON.stringify(formData)
  }).then(response => {
    console.log(response)
    Swal.fire(
      'Sucesso!',
      'Seu email de contato foi enviado com sucesso!',
      'success'
    )
  }).catch(err => {
    console.log('Erro:', err);
    Swal.fire(
      'Ops! Algo de inesperado aconteceu',
      'Tivemos um problema ao enviar o seu email, tente novamente mais tarde.',
      'error'
    )
  })
  return false;
}