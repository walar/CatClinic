<?php
  $I_nbArticleParPage = $A_vue['nb_article_par_page'];
  $A_entiteParPage = $A_vue['entite_par_page'];

  $B_estTrie = isset($A_vue['tri']);
  $S_tri = $B_estTrie ? $A_vue['tri'] : null;
  $A_paramTri = $B_estTrie ? explode('-', $S_tri . '-asc') : null;
?>

<h1>Liste des articles</h1>

<a href="/article/creer" class="button radius">Créer un nouvel article</a>

<?php if (count($A_vue['articles'])): ?>

  <table>
    <thead>
      <tr>
        <td class="hide-for-small-only">Catégorie
          <?php if (!$B_estTrie || ($B_estTrie && $A_paramTri[1] == 'categorie' && $A_paramTri[2] == 'asc')): ?>
            <span class="fi-arrow-up"></span>
          <?php else: ?>
            <a href="/article/paginer/1" title="Tri par ordre croissant">
              <span class="fi-arrow-up"></span>
            </a>
          <?php endif; ?>

          <?php if ($B_estTrie && $A_paramTri[1] == 'categorie' && $A_paramTri[2] == 'desc'): ?>
            <span class="fi-arrow-down"></span>
          <?php else: ?>
            <a href="/article/paginer/1/tri-categorie-desc" title="Tri par ordre décroissant">
              <span class="fi-arrow-down"></span>
            </a>
          <?php endif; ?>
        </td>

        <td>Titre
          <?php if ($B_estTrie && $A_paramTri[1] == 'titre' && $A_paramTri[2] == 'asc'): ?>
            <span class="fi-arrow-up"></span>
          <?php else: ?>
            <a href="/article/paginer/1/tri-titre" title="Tri par ordre croissant">
              <span class="fi-arrow-up"></span>
            </a>
          <?php endif; ?>

          <?php if ($B_estTrie && $A_paramTri[1] == 'titre' && $A_paramTri[2] == 'desc'): ?>
            <span class="fi-arrow-down"></span>
          <?php else: ?>
            <a href="/article/paginer/1/tri-titre-desc" title="Tri par ordre décroissant">
              <span class="fi-arrow-down"></span>
            </a>
          <?php endif; ?>
        </td>

        <td class="hide-for-small-only">Auteur
          <?php if ($B_estTrie && $A_paramTri[1] == 'auteur' && $A_paramTri[2] == 'asc'): ?>
            <span class="fi-arrow-up"></span>
          <?php else: ?>
            <a href="/article/paginer/1/tri-auteur" title="Tri par ordre croissant">
              <span class="fi-arrow-up"></span>
            </a>
          <?php endif; ?>

          <?php if ($B_estTrie && $A_paramTri[1] == 'auteur' && $A_paramTri[2] == 'desc'): ?>
            <span class="fi-arrow-down"></span>
          <?php else: ?>
            <a href="/article/paginer/1/tri-auteur-desc" title="Tri par ordre décroissant">
              <span class="fi-arrow-down"></span>
            </a>
          <?php endif; ?>
        </td>

        <td class="hide-for-small-only">Date
          <?php if ($B_estTrie && $A_paramTri[1] == 'date' && $A_paramTri[2] == 'asc'): ?>
            <span class="fi-arrow-up"></span>
          <?php else: ?>
            <a href="/article/paginer/1/tri-date" title="Tri par ordre croissant">
              <span class="fi-arrow-up"></span>
            </a>
          <?php endif; ?>

          <?php if ($B_estTrie && $A_paramTri[1] == 'date' && $A_paramTri[2] == 'desc'): ?>
            <span class="fi-arrow-down"></span>
          <?php else: ?>
            <a href="/article/paginer/1/tri-date-desc" title="Tri par ordre décroissant">
              <span class="fi-arrow-down"></span>
            </a>
          <?php endif; ?>
        </td>

        <td class="hide-for-small-only">En ligne
          <?php if ($B_estTrie && $A_paramTri[1] == 'enligne' && $A_paramTri[2] == 'asc'): ?>
            <span class="fi-arrow-up"></span>
          <?php else: ?>
            <a href="/article/paginer/1/tri-enligne" title="Tri par ordre croissant">
              <span class="fi-arrow-up"></span>
            </a>
          <?php endif; ?>

          <?php if ($B_estTrie && $A_paramTri[1] == 'enligne' && $A_paramTri[2] == 'desc'): ?>
            <span class="fi-arrow-down"></span>
          <?php else: ?>
            <a href="/article/paginer/1/tri-enligne-desc" title="Tri par ordre décroissant">
              <span class="fi-arrow-down"></span>
            </a>
          <?php endif; ?>
        </td>

        <td>Actions</td>
      </tr>
    </thead>

    <tbody>
      <?php foreach ($A_vue['articles'] as $O_article): ?>
        <tr>
          <td class="hide-for-small-only">
            <?php echo $O_article->donneCategorie()->donneTitre(); ?>
          </td>

          <td>
            <?php echo $O_article->donneTitre(); ?>
          </td>

          <td class="hide-for-small-only">
            <?php echo $O_article->donneAuteur()->donneNomComplet(); ?>
          </td>

          <td class="hide-for-small-only">
            <?php echo $O_article->donneDateCreationFormatee(); ?>
          </td>

          <td class="hide-for-small-only">
            <?php if ($O_article->estEnLigne()): ?>
              Oui
            <?php else: ?>
              Non
            <?php endif; ?>
          </td>

          <td>
            <ul class='inline-list'>
              <li>
                <a href="/article/edit/<?php echo $O_article->donneIdentifiant(); ?>">
                  <span class='fi-pencil'></span> Modifier
                </a>
              </li>

              <li>
                <a href="/article/suppr/<?php echo $O_article->donneIdentifiant(); ?>">
                  <span class='fi-trash'></span> Effacer
                </a>
              </li>
            </ul>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>

<?php else: ?>

  <p>Il n'y a aucun article à afficher.</p>

<?php endif; ?>


<?php include Constantes::repertoireVues() . '/standard/pagination.php'; ?>


<form id="entite_par_page" action="/article/liste" method="post" class="row collapse">

  <div class="small-6 medium-offset-8 medium-2 columns">
    <label  for="nb_article_par_page" class="prefix">Articles par page: </label>
  </div>

  <div class="small-3 medium-1 columns">
    <select id ="nb_article_par_page" name="nb_article_par_page">
      <?php foreach ($A_entiteParPage as $I_entiteParPage): ?>
        <option value="<?php echo $I_entiteParPage ?>"
          <?php if ($I_nbArticleParPage == $I_entiteParPage): ?>
            selected
          <?php endif; ?>
        ><?php echo $I_entiteParPage ?></option>
      <?php endforeach; ?>
    </select>
  </div>

  <div class="small-3 medium-1 columns">
    <input type="submit" name="Go" value="Go" class="button postfix"/>
  </div>

</form>
