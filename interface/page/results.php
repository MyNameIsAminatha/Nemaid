<script type="text/javascript">
var params = {
  fields: { // Fields of the database to be displayed, label of the fields for the headers
    result_specie: {db_id: 'NomEspece', label: 'Species name', columnWidth: 15, sortable: true },
    result_population: {db_id: 'Population', label: 'Population', columnWidth: 25, sortable: true },
    result_refnumber: {db_id: 'RefNumber', label: 'Ref Number', columnWidth: 10, sortable: true },
    result_homology: {db_id: 'Homologie', label: 'Similarity', columnWidth: 10, sortable: true }
  },
  ajaxUrl: 'explore.getTableResult', // Link to ajax
  tableName: 'Resultats', // Table name (can use join)
  tableId: 'result_table', // Box ID to assign the html
  orderBy: 'Homologie', // Order by condition
  sort: 'DESC', // Sort (asc / desc)
  rowId: 'NomEspece',
  clickableRow: false, // By default, set to true
  resultPerPage: '10', // Number of results per page
  currentPage: 1, // Currrent page of the user

  search: {
    globalSearch: '',
    searchFields: {},
    searchFilters: {}
  },

  exportAllowed: false,
  exportUrl: "default",
  exportFileName: "post.csv",
};

$(document).ready(function(){

  explore.init(params, true);

});
</script>

<div class="container z-depth-1 nemaid-window">
  <div class="nemaid-window-head">
    Results
  </div>
  <a class="waves-effect waves-teal btn btn-large" onclick="calculateResults()">Refresh results</a>&nbsp;&nbsp;&nbsp;&nbsp;

  <div id="result_table">
  </div>

  <script type="text/javascript">
    $(document).ready(function() {
      $('select').material_select();
    });
    function calculateResults() {
      $.ajax({
        type: "POST",
        url: "index.php",
        async: true,
        data: "action=result.calculateResults",
        dataType: "json",
        error: function(data) {
          window.location.replace("index.php?page=results")
          //alert("An error occured.");
        },
        success: function(data) {
          window.location.replace("index.php?page=results")
          //alert("Good");
        }
      });
    }
  </script>

</div>
