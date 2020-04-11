
$(document).ready(function(){
  $('#editable-staff').Tabledit({
    url: '../live-edits/live-staff-edit.php',
    deleteButton: false,
    editButton: false,
    restoreButton: false,
    hideIdentifier: false,
    columns: {
      identifier: [0, 'staff_ID'],
      editable: [[5, 'interline'], [6, 'domestic']]
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
