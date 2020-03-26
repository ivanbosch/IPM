$(document).ready(function(){
  $('#editable-cust').Tabledit({
    url: '../live-edits/live-disc-edit.php',
    deleteButton: false,
    editButton: false,
    restoreButton: false,
    hideIdentifier: false,
    columns: {
      identifier: [0, 'discount_ID'],
      editable: [[2, 'discount_Amount']]
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
