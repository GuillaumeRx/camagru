<?php $this->_t = 'Your Account'; ?>
<div id="account">
	<div class="form-box">
		<div class="profile-header">
			<div class="user-pic">
				<img src="<?= ($account->pic()) ? "../media/" . $account->pic() : 'http://via.placeholder.com/100' ?>"/>
			</div>
			<div class="username">
				<p><?= $account->username() ?></p>
				<form enctype="multipart/form-data" action="/account" method="POST" id="pic-changer">
					<label class="pic-picker" for="pic">Modifier la photo de profil</label>	
					<input type="file" accept="image/*" id="pic" name="pic" onchange="submit()"/>
				</form>
			</div>
		</div>
		<form method="POST" action="/account" class="form">
		<span>
			<label for="username">Nom d’utilisateur</label>	
			<input type="text" placeholder="Ton nom d'utilisateur"  value="<?= $account->username() ?>" id="username" name="username"/>
		</span>
		<span>
			<label for="email">Adresse e-mail</label>	
			<input type="text" placeholder="Tom e-mail" value="<?= $account->email() ?>" id="email" name="email"/>
		</span>
		<span>
			<label for="bio">Bio</label>	
			<textarea id="bio" name="bio"><?= $account->bio() ?></textarea>		
		</span>
		<span>
			<label for="notification">Me tenir notifié</label>
			<input type="checkbox" id="notification" name="notification" <?= $account->notification() ? "checked" : "" ?>/>
		</span>
		<button type="submit">Envoyer</button>
		<a href="/logout">Déconnexion</a>
		</form>
		
	</div>
</div>