<div id="footer">
    <div class="dictonsWrap">
        <div id="dictons">
            “Les films sont pour nous une seconde peau.”
            ― Pascal Dion-Laflamme
        </div>
    </div>
    <div class="foot">
        <div id="section-foot">
            <div class="section">
                <h3>Films</h3>
                <a href="/TP_01_PHP/Public/index.php#page">Liste des films</a>
                <?php if ($_SESSION['utilisateur']['Acces'] == 'admin') {?><a href="/TP_01_PHP/Public/ajouter-film.php">Nouveau film</a><?php } ?>
            </div>
            <?php if ($_SESSION['utilisateur']['Acces'] == 'admin') {?><div class="section">
                <h3>Utilisateurs</h3>
                <a href="/TP_01_PHP/Public/gestion-utilisateurs.php">Liste des utilisateurs</a>
            </div><?php } ?>
            <div class="section">
                <a href="/TP_01_PHP/Public/include/deconnexion.php"><h3>Se déconnecter</h3></a>
            </div>
        </div>
    </div>
    <div class="soyonslegaux">
        © Copyright 2016 - 9999 Les buds
    </div>
</div>
