<script type="text/javascript">
var params = {
  fields: { // Fields of the database to be displayed, label of the fields for the headers
    result_specie: {db_id: 'NomEspece', label: 'Specie name', columnWidth: 15, sortable: true },
    result_population: {db_id: 'Population', label: 'Population', columnWidth: 25, sortable: true },
    result_refnumber: {db_id: 'RefNumber', label: 'Ref Number', columnWidth: 10, sortable: true },
    result_homology: {db_id: 'Homologie', label: 'Homology', columnWidth: 10, sortable: true }
  },
  ajaxUrl: 'explore.getTableResult', // Link to ajax
  tableName: 'Resultats', // Table name (can use join)
  tableId: 'result_table', // Box ID to assign the html
  orderBy: 'NomEspece', // Order by condition
  sort: 'ASC', // Sort (asc / desc)
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

  <div id="result_table">
  </div>

  <script type="text/javascript">
    $(document).ready(function() {
      $('select').material_select();
    });
  </script>

</div>
