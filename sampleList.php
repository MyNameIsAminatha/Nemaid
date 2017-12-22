<!-- 21 November 2017
Aminatha
Projet: Némaid
-->
<?php include('inc/header.php'); ?>

<?php
// DB devra sortir la liste des samples
$samples = [
  ['sample1', 'name1', 'jeudi'],
  ['sample2', 'name2','vendredi']
];
?>

<div class="container z-depth-1 nemaid-window">
  <div class="nemaid-window-head">
    Sample list
  </div>

  <table>
    <thead>
      <tr>
          <th>Sample ID</th>
          <th>Sample Name</th>
          <th>Sampling date</th>
          <th>Action</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($samples as $key => $value) { ?>
        <tr>
          <td><?= $value[0]; ?></td>
          <td><?= $value[1]; ?></td>
          <td><?= $value[2]; ?></td>
          <td><a href="addSample.php?id=<?= $value[0]; ?>">Retrieve</a></td>
        </tr>
      <?php } ?>
    </tbody>
  </table>

</div>

<?php include('inc/footer.php'); ?>
