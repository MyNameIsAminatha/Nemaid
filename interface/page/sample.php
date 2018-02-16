<?php
if(isset($_GET['code'])) {
  $editing = true; // boolean
  $sample_code = $_GET['code']; // sample id of the sample we are editing
  $sampleInfo = $this->cast("cosample")->getSample($sample_code); // Result of sql request where sampleid = $sample_id
  $sampleQuantChars = $this->cast("coquantchar")->getSampleQuantChars($sample_code);
} else {
  $editing = false; // we are adding a sample, not editing an existing one
}

$genuses = $this->cast("cogenus")->getGenuses();
$species = $this->cast("cospecie")->getSpecies();
$quantChars = $this->cast("coquantchar")->getQuantChars();

?>

<div class="container z-depth-1 nemaid-window">
  <div class="nemaid-window-head">
    <?php if($editing) { echo 'You are modifying sample : ' . $sample_code; } else { echo 'Register sample'; } ?>
  </div>
    <form id="sampleForm" onsubmit="return false;">
      <input style="display: none;" name="Id_Sample" value="<?= ($editing) ? $sampleInfo['Id_Sample'] : '' ?>" />

      <table>
        <thead>
          <tr>
              <th>Informations</th>
          </tr>
        </thead>

        <tbody>
          <tr>
            <td>Genus</td>
            <td>
              <select class="" name="Genus_Name">
                <option disabled selected>Choose your genus</option>
                <<?php foreach ($genuses as $genus): ?>
                  <option <?php if($editing && ($sampleInfo['Genus_Name'] == $genus['Genus_Name'])) { echo 'selected'; } ?> value="<?= $genus['Genus_Name'] ?>"><?= $genus['Genus_Name'] ?></option>
                <?php endforeach; ?>
              </select>
            </td>
          </tr>
          <tr>
            <td>Specie (optional)</td>
            <td>
              <select class="" name="Species_Name">
                <option value="" selected>Not known</option>
                <<?php foreach ($species as $specie): ?>
                  <option <?php if($editing && ($sampleInfo['Species_Name'] == $specie['Species_Name'])) { echo 'selected'; } ?> value="<?= $specie['Species_Name'] ?>"><?= $specie['Species_Name'] ?></option>
                <?php endforeach; ?>
              </select>
            </td>
          </tr>
          <tr>
            <!--in sample info the info got to be the same as in the data base-->
            <td>Date</td>
            <td><input name="date" type="date" placeholder="Date of entry" value="<?= ($editing) ? $sampleInfo['date'] : '' ?>" /></td>
          </tr>
        <thead>
          <tr>
              <th>Characters</th>
              <th>Value</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($quantChars as $quantChar) {
            if($editing) {
              $quantCharValue = "";
              foreach ($sampleQuantChars as $sampleQuantChar) {
                if($quantChar['Id_Character'] == $sampleQuantChar['Id_Character']) {
                  $quantCharValue = $sampleQuantChar['Quant_Char_Value'];
                  break;
                }
              }
            }
             ?>
            <tr>
              <td><?= $quantChar['Explaination'] ?></td>
              <td><input name="<?= $quantChar['Id_Character'] ?>" type="text" value="<?= ($editing) ? $quantCharValue : '' ?>" placeholder="<?= $quantChar['Entitled_Character'] ?>" /></td>
            </tr>
          <?php } ?>
        </tbody>
      </table>

      <!--Save and Next Buttons-->
      <button onclick="addSample()" type="submit" class="waves-effect waves-teal btn">Save</button>
    </form>
</div>

<script type="text/javascript">
  function addSample() {
    formData = $("#sampleForm").serialize();
    $.ajax({
      type: "POST",
      url: "index.php",
      async: true,
      data: "action=sample.saveSample&" + formData,
      dataType: "json",
      error: function(data) {
        alert("An error occured.");
      },
      success: function(data) {
        alert("Good");
      }
    });
  }
  $(document).ready(function() {
    $('select').material_select();
  });
</script>
