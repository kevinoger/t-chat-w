<?php 

function afficherPost($champ){
    echo (!empty($_POST[$champ])? $_POST[$champ] : '' ); 

}

function afficherCheck($valeurAttendue){
    echo (!empty($_POST['sexe']) && $_POST['sexe'] == $valeurAttendue) ? 'checked' : '';
}

?>


<?php $this->layout('layout', ['title' => 'Inscrivez-vous !']) ?>

<?php $this->start('main_content') ?>

<h2>Inscription d'utilisateur</h2>

<?php $fmsg->display(); ?>

<form action="<?php echo $this->url('register'); ?>" method="POST" enctype="multipart/form-data">
    <p>
        <!-- Pseudo, mdp, mail, avatar -->
        <label for="pseudo">Pseudo : </label>
        <input type="text" name="pseudo" id="pseudo" placeholder="3 à 50 caractères" value="<?php afficherPost('pseudo'); ?>" />
    </p>
    <p>
        <label for="mot_de_passe">Mot de Passe : </label>
        <input type="password" name="mot_de_passe" id="mot_de_passe" >
    </p>
    <p>
        <label for="email">Mail : </label>
        <input type="email" name="email" id="email" value="<?php afficherPost('email'); ?>" />
    </p>
    <p>

        <label for="femme">Femme : </label>
        <input type="radio" name="sexe" value="femme" id="femme" <?php afficherCheck('femme'); ?> />

        <label for="homme">Homme : </label>
        <input type="radio" name="sexe" value="homme" id="homme" <?php afficherCheck('homme'); ?> />
    </p>
    <p>

        <label for="non-defini">Non-defini : </label>
        <input type="radio" name="sexe" value="non-defini" id="non-defini">
    </p>
    <p>
        <label for="avatar">Avatar : </label>
        <input type="file" name="avatar" id="avatar">
    </p>
    <p>
        <input type="submit" value="S'inscire">
    </p>
</form>

<?php $this->stop('main_content'); ?>