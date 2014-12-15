<h1>Liste des catégories</h1>

<a href="/categorie/creer">Créer une nouvelle catégorie</a>

<?php if (count($A_vue['categories'])): ?>

    <table>

        <thead>
            <tr>
                <td>Titre
                    <a href="/categorie/paginer/1/tri-titre" title="Tri par ordre croissant">&uarr;</a>
                    <a href="/categorie/paginer/1/tri-titre-desc" title="Tri par ordre décroissant">&darr;</a>
                </td>
                <td>Actions</td>
            </tr>
        </thead>

        <tbody>
            <?php foreach ($A_vue['categories'] as $O_categorie): ?>
                <tr>
                    <td>
                        <?php echo $O_categorie->donneTitre(); ?>
                    </td>

                    <td>
                        <a href="/categorie/edit/<?php echo $O_categorie->donneIdentifiant(); ?>">
                            Modifier
                        </a>
                        &nbsp;
                        <a href="/categorie/suppr/<?php echo $O_categorie->donneIdentifiant(); ?>">
                            Effacer
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>

    </table>

<?php else: ?>

    <p>Il n'y a aucune catégorie ici.</p>

<?php endif; ?>

<?php if (isset($A_vue['pagination'])): ?>
   <div>
        <?php foreach ($A_vue['pagination'] as $I_numeroPage => $S_lien): ?>
            &nbsp;
            <?php if (isset($S_lien)): ?>
                <?php
                    if (isset($A_vue['tri']))
                    {
                        $S_lien .= '/' . $A_vue['tri'];
                    }
                ?>
                <a href="/<?php echo $S_lien; ?>"><?php echo $I_numeroPage; ?></a>
            <?php else: ?>
                <?php echo $I_numeroPage; ?>
            <?php endif; ?>
        <?php endforeach; ?>
    </div>
<?php endif; ?>
