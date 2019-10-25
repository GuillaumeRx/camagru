<?php $this->_t = 'Register'; ?>
<div id="register">
	<div class="form-box">
		<h2>Inscription</h2>
		<form method="POST" action="/register" class="form">
		<span>
			<label for="username">Nom d’utilisateur</label>	
			<input type="text" placeholder="Un truc fun" id="username" name="username"/>
		</span>
		<span>
			<label for="email">Adresse e-mail</label>	
			<input type="text" placeholder="mail@exemple.com" id="email" name="email"/>
		</span>
		<span>
		<label for="password">Mot de passe</label>	
			<input type="password" placeholder="Garde le pour toi" id="password" name="password"/>
		</span>	
		<button type="submit">Envoyer</button>
		</form>
		<p>Déjà un compte ? <a href="/login">Connexion</a></p>
	</div>
</div>