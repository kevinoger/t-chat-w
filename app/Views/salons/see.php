<?php $this->layout('layout', ['title' => 'Messages de mon salon']); ?>

<?php $this->start('main_content'); ?>

<!-- on a uniquement $salon et $messages à notre disposition -->

<h2>Bienvenue sur le salon "<?php echo $this->e($salon['nom']); ?>"</h2>
<ol class="messages">
	<?php foreach ($messages as $message): ?>
		<!-- htmlentities va me permettre de me protéger contre l'injection de 
			HTML dont script -->
		<li>
			<span class="personne"><?php echo $this->e($message['pseudo']); ?> : </span>
			<span class="message">"<?php echo $this->e($message['corps']); ?>"</span></li>
	<?php endforeach; ?>
</ol>
<!-- J'envoie mon formulaire d'ajout de message sur la page courante
cela va me permettre d'ajouter mes messages à ce salon précisément.
$this->url('see_salon', array('id' => $salon['id'])) va générer une url du genre :
t-chat-w/public/salon/$salon['id']
-->
<form class="form-message" action="<?php $this->url('see_salon', array('id'=>$salon['id'])) ?>" method="POST">
	<input type="text" name="message" /><input type="submit" class="button" name="send" value="Envoyer"/>
</form>

<?php $this->stop('main_content'); ?>
