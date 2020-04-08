$(document).ready(function(){
  $('#editable-table').Tabledit({
    url: '../live-edits/live-blank-edit.php',
    deleteButton: false,
    editButton: false,
    restoreButton: false,
    hideIdentifier: false,
    columns: {
      identifier: [4, 'Blank'],
      editable: [[0, 'login_username']]
    },
    onDraw: function() {
    console.log('onDraw()');
},
onSuccess: function(data, textStatus, jqXHR) {
    console.log('onSuccess(data, textStatus, jqXHR)');
    console.log(data);
    console.log(textStatus);
    console.log(jqXHR);
    location.reload();
},
onFail: function(jqXHR, textStatus, errorThrown) {
    console.log('onFail(jqXHR, textStatus, errorThrown)');
    console.log(jqXHR);
    console.log(textStatus);
    console.log(errorThrown);
},
onAlways: function() {
    console.log('onAlways()');
},
onAjax: function(action, serialize) {
    console.log('onAjax(action, serialize)');
    console.log(action);
    console.log(serialize);
}
  });
});
