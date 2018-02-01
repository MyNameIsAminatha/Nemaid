<?php
// DB devra sortir la liste des samples
$samples = $this->cast("cosample")->getSamples();
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
          <th>Action</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($samples as $sample) { ?>
        <tr>
          <td><?= $sample['id']; ?></td>
          <td><?= $sample['code']; ?></td>
          <td><a href="index.php?page=addSample&code=<?= $sample['code']; ?>">Retrieve</a></td>
        </tr>
      <?php } ?>
    </tbody>
  </table>

</div>
