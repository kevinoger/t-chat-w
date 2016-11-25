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
                    <a class="button" href="<?php echo $this->url('users_list'); ?>" title="Liste des utilisateurs">Liste des utilisateurs</a>
                    <a class="button" href="deconnexion.php" title="Se déconnecter de T'Chat">Déconnexion</a>
                </ul>
            </nav>
        </aside><main>

        <section>
            <?= $this->section('main_content'); ?>
        </section>
        </main>
        <footer>
        </footer>
    </body>
</html>