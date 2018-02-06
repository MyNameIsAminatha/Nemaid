<?php
if(isset($_GET['code'])) {
  $editing = true; // boolean
  $sample_code = $_GET['code']; // sample id of the sample we are editing
  $genuses = $this->cast("cogenus")->getGenuses();
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
              <th>Informations</th>
          </tr>
        </thead>

        <tbody>
          <tr>
            <td>Sample number code</td>
            <td><input name="numbercode" type="text" placeholder="Sample Id" value="<?= ($editing) ? $sampleInfo['numbercode'] : '' ?>" /></td>
          </tr>
          <tr>
            <td>Genus</td>
            <td>
              <select class="" name="genus">
                <option disabled selected>Choose your genus</option>
                <<?php foreach ($genuses as $genus): ?>
                  <option <?php if($editing && ($sampleInfo['Genus_Name'] == $genus['Genus_Name'])) { echo 'selected'; } ?> value=""><?= $genus['Genus_Name'] ?></option>
                <?php endforeach; ?>
              </select>
            </td>
          </tr>
          <tr>
            <!--in sample info the info got to be the same as in the data base-->
            <td>Date</td>
            <td><input name="date" type="text" placeholder="Date of entry" value="<?= ($editing) ? $sampleInfo['Date'] : '' ?>" /></td>
          </tr>
          <tr>
            <td>Location</td>
            <td><input name="location" type="text" placeholder="Location" value="<?= ($editing) ? $sampleInfo['location'] : '' ?>" /></td>
          </tr>
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
            <td>LGT</td>
            <td><input name="body_length_ci" type="text" placeholder="Body Length" value="<?= ($editing) ? $sampleInfo['body_length_ci'] : '' ?>" /></td>
          </tr>
          <tr>
            <td>STY</td>
            <td><input name="sty" type="text" placeholder="Stylet Length" value="<?= ($editing) ? $sampleInfo['sty'] : '' ?>" /></td>
          </tr>
          <tr>
            <td>DGO</td>
            <td><input name="dgo" type="text" placeholder="Distance dorasal gland opening to stylet base" value="<?= ($editing) ? $sampleInfo['dgo'] : '' ?>" /></td>
          </tr>
          <tr>
            <td>EXPO</td>
            <td><input name="expo" type="text" placeholder="Distance anterior end to excretory pore" value="<?= ($editing) ? $sampleInfo['expo'] : '' ?>" /></td>
          </tr>
          <tr>
            <td>BAW</td>
            <td><input name="baw" type="text" placeholder="Width of body annuli" value="<?= ($editing) ? $sampleInfo[''] : '' ?>" /></td>
          </tr>
          <tr>
            <td>TAIL</td>
            <td><input name="tail" type="text" placeholder="Tail Length" value="<?= ($editing) ? $sampleInfo[''] : '' ?>" /></td>
          </tr>
          <tr>
            <td>TAN</td>
            <td><input name="tan" type="text" placeholder="Number of tail annuli (ventral side)" value="<?= ($editing) ? $sampleInfo[''] : '' ?>" /></td>
          </tr>
          <tr>
            <td>PHAS</td>
            <td><input name="phas" type="text" placeholder="Number of annuli between phasmids and anus" value="<?= ($editing) ? $sampleInfo['code'] : '' ?>" /></td>
          </tr>
          <tr>
            <td>a</td>
            <td><input name="code" type="text" placeholder="Ratio a" value="<?= ($editing) ? $sampleInfo['code'] : '' ?>" /></td>
          </tr>
          <tr>
            <td>c</td>
            <td><input name="code" type="text" placeholder="Ratio c" value="<?= ($editing) ? $sampleInfo['code'] : '' ?>" /></td>
          </tr>
          <tr>
            <td>c'</td>
            <td><input name="code" type="text" placeholder="Ratio c'" value="<?= ($editing) ? $sampleInfo['code'] : '' ?>" /></td>
          </tr>
          <tr>
            <td>m</td>
            <td><input name="code" type="text" placeholder="Ratio m" value="<?= ($editing) ? $sampleInfo['code'] : '' ?>" /></td>
          </tr>
          <tr>
            <td>V</td>
            <td><input name="code" type="text" placeholder="Ratio V" value="<?= ($editing) ? $sampleInfo['code'] : '' ?>" /></td>
          </tr>
          <tr>
            <td>SPIC</td>
            <td><input name="code" type="text" placeholder="Spicule Length" value="<?= ($editing) ? $sampleInfo['code'] : '' ?>" /></td>
          </tr>
          <tr>
            <td>Males</td>
            <td><input name="code" type="text" placeholder="% males/total number of specimens" value="<?= ($editing) ? $sampleInfo['code'] : '' ?>" /></td>
          </tr>
          <tr>
            <td>PGB</td>
            <td><input name="code" type="text" placeholder="% of specimens with Posterior genital branch degenerate" value="<?= ($editing) ? $sampleInfo['code'] : '' ?>" /></td>
          </tr>
          <tr>
            <td>PUS</td>
            <td><input name="code" type="text" placeholder="% of specimens with Posterior genital branch degenerate" value="<?= ($editing) ? $sampleInfo['code'] : '' ?>" /></td>
          </tr>
          <tr>
            <td>DISC</td>
            <td><input name="code" type="text" placeholder="Ratio m" value="<?= ($editing) ? $sampleInfo['code'] : '' ?>" /></td>
          </tr>
          <tr>
            <td>CAN</td>
            <td><input name="code" type="text" placeholder="Ratio m" value="<?= ($editing) ? $sampleInfo['code'] : '' ?>" /></td>
          </tr>
          <tr>
            <td>HAB</td>
            <td><input name="code" type="text" placeholder="Ratio m" value="<?= ($editing) ? $sampleInfo['code'] : '' ?>" /></td>
          </tr>
          <tr>
            <td>LIP</td>
            <td><input name="code" type="text" placeholder="Ratio m" value="<?= ($editing) ? $sampleInfo['code'] : '' ?>" /></td>
          </tr>
          <tr>
            <td>INC</td>
          <td><input name="code" type="text" placeholder="Ratio m" value="<?= ($editing) ? $sampleInfo['code'] : '' ?>" /></td>
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
  $(document).ready(function() {
    $('select').material_select();
  });
</script>
