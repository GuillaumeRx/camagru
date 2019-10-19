<?php $this->_t = 'Login'; ?>
<div id="login">
	<div class="form-box">
		<h2>Connexion</h2>
		<form method="POST" action="/login">
		<span>
			<label for="email">Adresse e-mail</label>
			<input type="text" placeholder="mail@exemple.com" id="email" name="email"/>
		</span>
		<span>
			<label for="password">Mot de passe</label>	
			<input type="password" placeholder="Ça c'est un secret" id="password" name="password"/>
		</span>
			<button type="submit">Envoyer</button>
		</form>
		<p><?= $error ?></p>
		<p>Pas encore de compte ? <a href="/register">Incription</a></p>
	</div>
</div>