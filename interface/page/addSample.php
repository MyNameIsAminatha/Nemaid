<?php
if(isset($_GET['code'])) {
  $editing = true; // boolean
  $sample_code = $_GET['code']; // sample id of the sample we are editing
  $sampleInfo = $this->cast("cosample")->getSample($sample_code); // Result of sql request where sampleid = $sample_id
} else {
  $editing = false; // we are adding a sample, not editing an existing one
}
?>

<div class="container z-depth-1 nemaid-window">
  <div class="nemaid-window-head">
    <?php if($editing) { echo 'You are modifying sample : ' . $sample_code; } else { echo 'Register sample'; } ?>
  </div>
    <form id="sampleForm" onsubmit="return false;">
      <input style="display: none;" name="id" value="<?= ($editing) ? $sampleInfo['id'] : '' ?>" />
      <table>
        <thead>
          <tr>
              <th>Characters</th>
              <th>Value</th>
          </tr>
        </thead>

        <tbody>
          <tr>
            <td>Identification</td>
            <td><input name="code" type="text" placeholder="Code" value="<?= ($editing) ? $sampleInfo['code'] : '' ?>" /></td>
          </tr>
          <tr>
            <td>Body Length</td>
            <td><input name="body_length_ci" type="text" placeholder="CI" value="<?= ($editing) ? $sampleInfo['body_length_ci'] : '' ?>" /></td>
          </tr>
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
      data: "action=sample.addSample&" + formData,
      dataType: "json",
      error: function(data) {
        alert("An error occured.");
      },
      success: function(data) {
        alert("Good");
      }
    });
  }
</script>
