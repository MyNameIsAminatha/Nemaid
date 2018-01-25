<?php
if(isset($_GET['id'])) {
  $editing = true; // boolean
  $sample_id = $_GET['id']; // sample id of the sample we are editing
  $sampleInfo = [
    'id' => 'Sample2',
    'desc' => 'A nice sample',
    'date' => '22/12/2017'
  ]; // Result of sql request where sampleid = $sample_id
} else {
  $editing = false; // we are adding a sample, not editing an existing one
}
?>

<div class="container z-depth-1 nemaid-window">
  <div class="nemaid-window-head">
    <?php if($editing) { echo 'You are modifying sample : ' . $sample_id; } else { echo 'Register sample'; } ?>
  </div>
    <form class="" action="index.html" method="post">
      <div class="input-field">
        <input id="sampleCode" type="text" class="validate" <?php if ($editing) echo 'value="'  . $sampleInfo['id'] . '"' ?>>
        <label for="sampleCode">Sample code number</label>
      </div>
      <div class="input-field">
        <input id="sampleDesc" type="text" class="validate" <?php if ($editing) echo 'value="'  . $sampleInfo['desc'] . '"' ?>>
        <label for="sampleDesc">Description</label>
      </div>
      <div class="input-field">
        <input id="sampleDate" type="text" class="validate" <?php if ($editing) echo 'value="'  . $sampleInfo['date'] . '"' ?>>
        <label for="sampleDate">Date</label>
      </div>
      <button type="submit" class="waves-effect waves-teal btn">Save</button>&nbsp;&nbsp;&nbsp;&nbsp;
      <button type="submit" class="waves-effect waves-teal btn">Next</button>
    </form>
</div>
