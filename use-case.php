
<?php 

$model = $args['data']; 

?>
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
<div class="container-fluid fim-branco pt-4 pb-4">
<div class="row justify-content-center pt-4 pb-4">
<div class="col-12 col-md-8 col-lg-8">
<h1>
	<?php echo $model->modelTitle; ?>
</h1>
<p>
	<?php echo $model->modelDesc; ?>
</p>
<form id="newCall">
<input type="hidden" value="<?php echo $model->_id; ?>" name="id"> 
<?php for ($i = 0; $i < count($model->fields); ++$i): ?>
<span>
  <?php if (strcmp($model->fields[$i]->type, 'input') == 0): ?>
    <div class="form-group mt-1 mb-1">
      <label for="<?php echo $model->fields[$i]->field ;?>"><?php echo $model->fields[$i]->label ;?></label>
      <input class="form-control mb-2" maxlength="<?php echo $model->fields[$i]->maxlength ;?>" name="<?php echo $model->fields[$i]->field ;?>" id="<?php echo $model->fields[$i]->field ;?>"
        required="<?php echo $model->fields[$i]->required ;?>" placeholder="<?php echo $model->fields[$i]->placeholder ;?>" type="text" (input)="callTokenizer($event)">
    </div>
  <?php endif; ?>
  <?php if (strcmp($model->fields[$i]->type, 'textarea')==0): ?>
    <div class="form-group submit-line mt-1 mb-1">
      <label for="<?php echo $model->fields[$i]->field ;?>"><?php echo $model->fields[$i]->label ;?></label>
      <textarea autosize class="form-control" maxlength="<?php echo $model->fields[$i]->maxlength ;?>" rows="2"
        placeholder="<?php echo $model->fields[$i]->placeholder ;?>" name="<?php echo $model->fields[$i]->field ;?>" id="<?php echo $model->fields[$i]->field ;?>" required="<?php echo $model->fields[$i]->required ;?>"
        aria-describedby="resultInputHelp" (input)="callTokenizer($event)"></textarea>
      <small id="resultInputHelp" class="form-text text-danger"></small>
    </div>
  <?php endif; ?>
</span>
<?php endfor; ?>
<div class="form-group mb-3">
  <label for="examplesCountClient">Quantos exemplos?</label>
  <input type="number" class="form-control form-control-sm" id="examplesCountClient" name="examplesCountClient"
    max="1" min="1" value="1">
  <small class="muted">Para ver mais exemplos de resultado, acesse a plataforma completa.</small>
</div>
<input id="submitButton" type="button" value="Gerar Ideias" class="btn btn-primary btn-lg d-block" />
<button id="load" class="btn btn-primary mt-3 btn-lg d-none">
  <span class="spinner-border spinner-border-sm"></span>
  Gerando Ideias...
</button>
<p class="mt-3">
  <?php
    if(is_user_logged_in(  )){
      echo '<a href="https://app.redatudo.online">Acesse a plataforma completa agora.</a>';
    }else{
      echo '<a href="https://redatudo.online/minha-conta">Registre-se ou Entre.</a>';
    }
  ?>
</p>
</form>
<div id="editor" style="height: 375px;">
  <p>Crie conteúdo incrível agora!</p>
  <p>Isso é só uma palhinha. Teste gratuitamente todo o poder de <a href="https://app.redatudo.online?token=<?php echo token_generate(); ?>">REDATUDO</a></p>
  <p>Ainda não tem uma conta? <a href="https://redatudo.online/minha-conta">Assine grátis.</a></p>
  <p>Ou assine uma conta prêmium. <a href="https://redatudo.online/#assine-agora">Assine uma conta premium.</a></p>
  <p><br></p>
</div>
<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
<script>
  var quill = new Quill('#editor', {
    theme: 'snow'
  });
  var results = []
  function show () {
    document.getElementById("submitButton").classList.remove("d-block")
    document.getElementById("submitButton").classList.add("d-none")
    document.getElementById("load").classList.remove("d-none")
    document.getElementById("load").classList.add("d-block")
  }
  function hide () {
    document.getElementById("load").classList.remove("d-block")
    document.getElementById("load").classList.add("d-none")
    document.getElementById("submitButton").classList.remove("d-none")
    document.getElementById("submitButton").classList.add("d-block")
  }

  function callApi(){
    show()
    var form = document.getElementById('newCall')
    var formData = new FormData(form)
    //formData.set('examplesCountClient', '1')
    var object = {};
    formData.forEach((value, key) => object[key] = value);
    var json = JSON.stringify(object);
    const token = "Bearer <?php echo token_generate(); ?>"
    fetch('https://hidden-crag-82241.herokuapp.com/api/new-gpt', {
      method: 'POST', // *GET, POST, PUT, DELETE, etc.
      headers: {
        'Content-Type': 'application/json',
        'authorization': token
        // 'Content-Type': 'application/x-www-form-urlencoded',
      },
      body: json // body data type must match "Content-Type" header
    })
    .then((response) => response.json())
    .then((data) => {
      console.log(data)
      var contents = []
      data.choices.forEach(element => {
        contents.push({insert: element.text})
      });
      quill.setContents(contents)
      hide()
    })
    .catch((error) => {
      console.log(error)
      hide()
    })
  }

  const input = document.getElementById('submitButton')
  input.addEventListener('click', ()=>{
    callApi()
  })
</script>
</div>
</div>
</div>
