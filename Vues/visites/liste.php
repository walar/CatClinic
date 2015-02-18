<?php 
  $O_proprietaire = $A_vue['proprietaire'];
  $A_chats = $A_vue['chats'];
  $I_nbChat = sizeof($A_chats);
  $A_toutesLesVisites = $A_vue['toutesLesVisites'];
?>

<h1>Propriétaire <?php echo $O_proprietaire->donnePrenom() . ' ' . $O_proprietaire->donneNom() ?></h1>

<?php if (isset($A_chats) && $I_nbChat > 0): ?>
  <?php if ($I_nbChat>1): ?>
    <h2>Vos <?php echo $I_nbChat; ?> chats chez Cat Clinic</h2>
  <?php else: ?>
    <h2>Votre chat chez Cat Clinic</h2>
  <?php endif; ?>

  <table>
    <thead>
      <tr>
        <td>Chat</td>
        <td>Tatouage</td>
        <td>Age</td>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($A_chats as $O_chat): ?>
        <tr>
          <td><?php echo $O_chat->donneNom(); ?></td>
          <td><?php echo $O_chat->donneTatouage(); ?></td>
          <td><?php echo $O_chat->donneAge(); ?></td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
  
  <?php if (isset($A_toutesLesVisites) && sizeof($A_toutesLesVisites) > 0): ?>
    <h2>Les visites</h2>

    <?php foreach ($A_toutesLesVisites as $A_visites): ?>
      
      <?php if (sizeof($A_visites) > 0): ?>
        <h3><?php echo $A_visites[0]->donneChat()->donneNom(); ?></h3>

        <table>
          <thead>
            <tr>
              <td>Date</td>
              <td>Praticien</td>
              <td>Observations</td>
              <td>Prix</td>
            </tr>
          </thead>
          <tbody>
            <tr>
              <?php foreach ($A_visites as $O_visite): ?>
                <td><?php echo date("d/m/Y", strtotime($O_visite->donneDate())); ?></td>
                <td>
                  <?php echo $O_visite->donnePraticien()->donnePrenom(); ?>
                  <?php echo $O_visite->donnePraticien()->donneNom(); ?>
                </td>
                <td><?php echo $O_visite->donneObservations(); ?></td>
                <td><?php echo $O_visite->donnePrix(); ?> &euro;</td>
              <?php endforeach; ?>
            </tr>
          </tbody>
        </table>
      <?php endif; ?>

    <?php endforeach; ?>
  <?php endif; ?>

<?php else: ?>

  <p>Vous n'avez aucun chat d'enregistrer!</p>

<?php endif; ?>