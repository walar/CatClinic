<?php
  $I_nbArticleParPage = $A_vue['nb_article_par_page'];
  $A_entiteParPage = $A_vue['entite_par_page'];

  $B_estTrie = isset($A_vue['tri']);
  $S_tri = $B_estTrie ? $A_vue['tri'] : null;
  $A_paramTri = $B_estTrie ? explode('-', $S_tri . '-asc') : null;
?>

<h1>Liste des articles</h1>

<a href="/article/creer">Créer un nouveau article</a>

<?php if (count($A_vue['articles'])): ?>

  <table>
    <thead>
      <tr>
        <td>Catégorie
          <?php if (!$B_estTrie || ($B_estTrie && $A_paramTri[1] == 'categorie' && $A_paramTri[2] == 'asc')): ?>
            &uarr;
          <?php else: ?>
            <a href="/article/paginer/1" title="Tri par ordre croissant">
              &uarr;
            </a>
          <?php endif; ?>

          <?php if ($B_estTrie && $A_paramTri[1] == 'categorie' && $A_paramTri[2] == 'desc'): ?>
            &darr;
          <?php else: ?>
            <a href="/article/paginer/1/tri-categorie-desc" title="Tri par ordre décroissant">
              &darr;
            </a>
          <?php endif; ?>
        </td>

        <td>Titre
          <?php if ($B_estTrie && $A_paramTri[1] == 'titre' && $A_paramTri[2] == 'asc'): ?>
            &uarr;
          <?php else: ?>
            <a href="/article/paginer/1/tri-titre" title="Tri par ordre croissant">
              &uarr;
            </a>
          <?php endif; ?>

          <?php if ($B_estTrie && $A_paramTri[1] == 'titre' && $A_paramTri[2] == 'desc'): ?>
            &darr;
          <?php else: ?>
            <a href="/article/paginer/1/tri-titre-desc" title="Tri par ordre décroissant">
              &darr;
            </a>
          <?php endif; ?>
        </td>

        <td>Auteur
          <?php if ($B_estTrie && $A_paramTri[1] == 'auteur' && $A_paramTri[2] == 'asc'): ?>
            &uarr;
          <?php else: ?>
            <a href="/article/paginer/1/tri-auteur" title="Tri par ordre croissant">
              &uarr;
            </a>
          <?php endif; ?>

          <?php if ($B_estTrie && $A_paramTri[1] == 'auteur' && $A_paramTri[2] == 'desc'): ?>
            &darr;
          <?php else: ?>
            <a href="/article/paginer/1/tri-auteur-desc" title="Tri par ordre décroissant">
              &darr;
            </a>
          <?php endif; ?>
        </td>

        <td>Date
          <?php if ($B_estTrie && $A_paramTri[1] == 'date' && $A_paramTri[2] == 'asc'): ?>
            &uarr;
          <?php else: ?>
            <a href="/article/paginer/1/tri-date" title="Tri par ordre croissant">
              &uarr;
            </a>
          <?php endif; ?>

          <?php if ($B_estTrie && $A_paramTri[1] == 'date' && $A_paramTri[2] == 'desc'): ?>
            &darr;
          <?php else: ?>
            <a href="/article/paginer/1/tri-date-desc" title="Tri par ordre décroissant">
              &darr;
            </a>
          <?php endif; ?>
        </td>

        <td>En ligne
          <?php if ($B_estTrie && $A_paramTri[1] == 'enligne' && $A_paramTri[2] == 'asc'): ?>
            &uarr;
          <?php else: ?>
            <a href="/article/paginer/1/tri-enligne" title="Tri par ordre croissant">
              &uarr;
            </a>
          <?php endif; ?>

          <?php if ($B_estTrie && $A_paramTri[1] == 'enligne' && $A_paramTri[2] == 'desc'): ?>
            &darr;
          <?php else: ?>
            <a href="/article/paginer/1/tri-enligne-desc" title="Tri par ordre décroissant">
              &darr;
            </a>
          <?php endif; ?>
        </td>

        <td>Actions</td>
      </tr>
    </thead>

    <tbody>
      <?php foreach ($A_vue['articles'] as $O_article): ?>
        <tr>
          <td>
            <?php echo $O_article->donneCategorie()->donneTitre(); ?>
          </td>

          <td>
            <?php echo $O_article->donneTitre(); ?>
          </td>

          <td>
            <?php echo $O_article->donneAuteur()->donneNomComplet(); ?>
          </td>

          <td>
            <?php echo $O_article->donneDateCreationFormatee(); ?>
          </td>

          <td>
            <?php echo $O_article->estEnLigne() ? 'Oui' : 'Non'; ?>
          </td>

          <td>
            <a href="/article/edit/<?php echo $O_article->donneIdentifiant(); ?>">
              Modifier
            </a>
            &nbsp;
            <a href="/article/suppr/<?php echo $O_article->donneIdentifiant(); ?>">
              Effacer
            </a>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>

<?php else: ?>

  <p>Il n'y a aucun article à afficher.</p>

<?php endif; ?>

<?php if (isset($A_vue['pagination'])): ?>
  <div>
    <?php foreach ($A_vue['pagination'] as $I_numeroPage => $S_lien): ?>
      &nbsp;
      <?php if (isset($S_lien)): ?>
        <?php
          if ($B_estTrie)
          {
            $S_lien .= '/' . $S_tri;
          }
        ?>
        <a href="/<?php echo $S_lien; ?>"><?php echo $I_numeroPage; ?></a>
      <?php else: ?>
        <?php echo $I_numeroPage; ?>
      <?php endif; ?>
    <?php endforeach; ?>
  </div>
<?php endif; ?>


<div>
  <form id="entite_par_page" action="/article/liste" method="post">
    <label  for="nb_article_par_page">Articles par page: </label>
    <select id ="nb_article_par_page" name="nb_article_par_page">
      <?php foreach ($A_entiteParPage as $I_entiteParPage): ?>
        <option value="<?php echo $I_entiteParPage ?>"
          <?php if ($I_nbArticleParPage == $I_entiteParPage): ?>
            selected
          <?php endif; ?>
        ><?php echo $I_entiteParPage ?></option>
      <?php endforeach; ?>
    </select>

    <input type="submit" name="Go" value="Go" />
  </form>
</div>
