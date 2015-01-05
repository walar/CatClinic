<?php
  $I_nbCatParPage = $A_vue['nb_categorie_par_page'];
  $A_entiteParPage = $A_vue['entite_par_page'];

  $B_estTrie = isset($A_vue['tri']);
  $S_tri = $B_estTrie ? $A_vue['tri'] : null;
  $A_paramTri = $B_estTrie ? explode('-', $S_tri . '-asc') : null;
?>

<h1>Liste des catégories</h1>

<a href="/categorie/creer">Créer une nouvelle catégorie</a>

<?php if (count($A_vue['categories'])): ?>

  <table>
    <thead>
      <tr>
        <td>Titre
          <?php if (!$B_estTrie || ($B_estTrie && $A_paramTri[1] == 'titre' && $A_paramTri[2] == 'asc')): ?>
            &uarr;
          <?php else: ?>
            <a href="/categorie/paginer/1" title="Tri par ordre croissant">
              &uarr;
            </a>
          <?php endif; ?>

          <?php if ($B_estTrie && $A_paramTri[1] == 'titre' && $A_paramTri[2] == 'desc'): ?>
            &darr;
          <?php else: ?>
            <a href="/categorie/paginer/1/tri-titre-desc" title="Tri par ordre décroissant">
              &darr;
            </a>
          <?php endif; ?>
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

  <p>Il n'y a aucune catégorie à afficher.</p>

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
  <form id="entite_par_page" action="/categorie/liste" method="post">
    <label  for="nb_categorie_par_page">Catégories par page: </label>
    <select id ="nb_categorie_par_page" name="nb_categorie_par_page">
      <?php foreach ($A_entiteParPage as $I_entiteParPage): ?>
        <option value="<?php echo $I_entiteParPage ?>"
          <?php if ($I_nbCatParPage == $I_entiteParPage): ?>
            selected
          <?php endif; ?>
        ><?php echo $I_entiteParPage ?></option>
      <?php endforeach; ?>
    </select>

    <input type="submit" name="Go" value="Go" />
  </form>
</div>
