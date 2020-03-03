$(document).ready(function(){
  $('#data_table').Tabledit({
    deleteButton: false,
    editButton: false,
    columns: {
      identifier: [0, 'blank_ID'],
      editable: [[1, 'login_username']]
    },
    hideIdentifier: false,
    url: '../PHP/live_blank_alloc.php'
  });
});
