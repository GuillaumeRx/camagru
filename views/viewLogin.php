<?php $this->_t = 'Login'; ?>
<div id="login">
	<div class="login-box">
		<form method="POST" action="/account">
			<input type="text" placeholder="email" id="email" name="email"/>
			<input type="password" placeholder="password" id="password" name="password"/>
			<button type="submit">Submit</button>
		</form>
		<a href="/register">Register</a>
	</div>
</div>