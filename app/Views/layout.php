<!DOCTYPE html>
<html lang="fr">
    <head>
        <title><?php echo $this->e($title); ?></title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="<?php echo $this->assetUrl('css/reset.css'); ?>">
        <link rel="stylesheet" href="<?php echo $this->assetUrl('css/style.css'); ?>">
    </head>
    <body>
        <header>
            <h1><?php echo $this->e($title); ?></h1>
        </header>
        <aside>
            <h3><a href="<?php echo $this->url('default_home'); ?>" title="Revenir a l'accueil">Les salons</a></h3>
            <nav>
                <ul id="menu-salons">
                   <?php foreach($salons as $salon) : ?>
                    <li><a href="<?php echo $this->url('see_salon', array('id'=>$salon['id'])); ?>"><?php echo $this->e($salon['nom']); ?></a></li>
                   <?php  endforeach; ?>
                    <li><a class="button" href="<?php echo $this->url('users_list'); ?>" title="Liste des utilisateurs">Liste des utilisateurs</a></li>
                    <li><a class="button" href="<?php echo $this->url('logout'); ?>" title="Se déconnecter de T'Chat">Déconnexion</a></li>
                </ul>
            </nav>
        </aside><main>

        <section>
            <?= $this->section('main_content'); ?>
        </section>
        </main>
        <footer>
        </footer>
        <script
          src="https://code.jquery.com/jquery-2.2.4.min.js"
          integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44="
          crossorigin="anonymous">
        </script>
        <script src="<?php echo $this->assetUrl('js/close-flash-messages.js'); ?>"></script>
    </body>
</html>