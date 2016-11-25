<?php $this->layout('layout', ['title' => 'Messages de mon salon']) ?>


<?php $this->start('main_content'); ?>

<h2>Bienvenue sur le salon "<?php echo $this->e($salon['nom']); ?>"</h2>
<ol class="messages">
    <?php foreach($messages as $message) : ?>
    <!-- htmlentities va me permettre de me proteger contre les injection HTML dont script -->
    <li>
        <span class="message">"<?php echo $this->e($message['corps']); ?>"</span></li>
    <?php  endforeach; ?>
</ol>

<form class="form-message" action="<?php echo $this->url('see_salon', array('id' => $salon['id'])); ?>" method="POST">
    <textarea name="message"></textarea>    
    <input type="submit" class="button" name="send" value="Envoyer">
</form>

<?php $this->stop('main_content'); ?>
