<?php
  $I_nbAuteurParPage = $A_vue['nb_auteur_par_page'];
  $A_entiteParPage = $A_vue['entite_par_page'];

  $B_estTrie = isset($A_vue['tri']);
  $S_tri = $B_estTrie ? $A_vue['tri'] : null;
  $A_paramTri = $B_estTrie ? explode('-', $S_tri . '-asc') : null;
?>

<h1>Liste des auteurs</h1>

<a href="/auteur/creer">Créer un nouveau auteur</a>

<?php if (count($A_vue['auteurs'])): ?>

  <table>
    <thead>
      <tr>
        <td>Nom
          <?php if (!$B_estTrie || ($B_estTrie && $A_paramTri[1] == 'nom' && $A_paramTri[2] == 'asc')): ?>
            &uarr;
          <?php else: ?>
            <a href="/auteur/paginer/1" title="Tri par ordre croissant">
              &uarr;
            </a>
          <?php endif; ?>

          <?php if ($B_estTrie && $A_paramTri[1] == 'nom' && $A_paramTri[2] == 'desc'): ?>
            &darr;
          <?php else: ?>
            <a href="/auteur/paginer/1/tri-nom-desc" title="Tri par ordre décroissant">
              &darr;
            </a>
          <?php endif; ?>
        </td>
        <td>Prenom
          <?php if ($B_estTrie && $A_paramTri[1] == 'prenom' && $A_paramTri[2] == 'asc'): ?>
            &uarr;
          <?php else: ?>
            <a href="/auteur/paginer/1/tri-prenom" title="Tri par ordre croissant">
              &uarr;
            </a>
          <?php endif; ?>

          <?php if ($B_estTrie && $A_paramTri[1] == 'prenom' && $A_paramTri[2] == 'desc'): ?>
            &darr;
          <?php else: ?>
            <a href="/auteur/paginer/1/tri-prenom-desc" title="Tri par ordre décroissant">
              &darr;
            </a>
          <?php endif; ?>
        </td>
        <td>Mail
          <?php if ($B_estTrie && $A_paramTri[1] == 'mail' && $A_paramTri[2] == 'asc'): ?>
            &uarr;
          <?php else: ?>
            <a href="/auteur/paginer/1/tri-mail" title="Tri par ordre croissant">
              &uarr;
            </a>
          <?php endif; ?>

          <?php if ($B_estTrie && $A_paramTri[1] == 'mail' && $A_paramTri[2] == 'desc'): ?>
            &darr;
          <?php else: ?>
            <a href="/auteur/paginer/1/tri-mail-desc" title="Tri par ordre décroissant">
              &darr;
            </a>
          <?php endif; ?>
        </td>
        <td>Actions</td>
      </tr>
    </thead>

    <tbody>
      <?php foreach ($A_vue['auteurs'] as $O_auteur): ?>
        <tr>
          <td>
            <?php echo $O_auteur->donneNom(); ?>
          </td>

          <td>
            <?php echo $O_auteur->donnePrenom(); ?>
          </td>

          <td>
            <?php echo $O_auteur->donneMail(); ?>
          </td>

          <td>
            <a href="/auteur/edit/<?php echo $O_auteur->donneIdentifiant(); ?>">
              Modifier
            </a>
            &nbsp;
            <a href="/auteur/suppr/<?php echo $O_auteur->donneIdentifiant(); ?>">
              Effacer
            </a>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>

<?php else: ?>

  <p>Il n'y a aucun auteur à afficher.</p>

<?php endif; ?>


<?php include Constantes::repertoireVues() . '/standard/pagination.php'; ?>


<div>
  <form id="entite_par_page" action="/auteur/liste" method="post">
    <label  for="nb_auteur_par_page">Auteurs par page: </label>
    <select id ="nb_auteur_par_page" name="nb_auteur_par_page">
      <?php foreach ($A_entiteParPage as $I_entiteParPage): ?>
        <option value="<?php echo $I_entiteParPage ?>"
          <?php if ($I_nbAuteurParPage == $I_entiteParPage): ?>
            selected
          <?php endif; ?>
        ><?php echo $I_entiteParPage ?></option>
      <?php endforeach; ?>
    </select>

    <input type="submit" name="Go" value="Go" />
  </form>
</div>
