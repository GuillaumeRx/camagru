<?php $this->_t = 'Login'; ?>
<div id="forgot">
	<?= $success == true ? "<p>Tu as reçu un mail</p>" : "" ?>
	<div class="form-box">
		<h2>Mot de passe oublié</h2>
		<form method="POST" action="/forgot" class="form">
		<span>
			<label for="email">Adresse e-mail</label>
			<input type="text" placeholder="mail@exemple.com" id="email" name="email"/>
		</span>
			<button type="submit">Envoyer</button>
		</form>
		<p><?= $error ?></p>
	</div>
</div>