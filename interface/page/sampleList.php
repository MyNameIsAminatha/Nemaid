<?php
// DB devra sortir la liste des samples
$samples = $this->cast("cosample")->getSamples();
?>



<script type="text/javascript">
var params = {
  fields: { // Fields of the database to be displayed, label of the fields for the headers
    sample_id: {db_id: 'Id_Sample', label: 'Id', columnWidth: 40, sortable: true },
    sample_genus: {db_id: 'Genus_Name', label: 'Genus', columnWidth: 20, sortable: true },
    sample_date: {db_id: 'date', label: 'Date', columnWidth: 10, sortable: true }
  },
  ajaxUrl: 'explore.getTableResult', // Link to ajax
  tableName: 'sample', // Table name (can use join)
  tableId: 'sample_table', // Box ID to assign the html
  orderBy: 'Id_Sample', // Order by condition
  sort: 'ASC', // Sort (asc / desc)
  rowId: 'Id_Sample',
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
    Sample list
  </div>

<div id="sample_table">

</div>

</div>
