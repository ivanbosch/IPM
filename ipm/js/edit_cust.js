$(document).ready(function(){
  $('#editable-cust').Tabledit({
    url: '../live-edits/live-cust-edit.php',
    deleteButton: false,
    editButton: false,
    restoreButton: false,
    hideIdentifier: false,
    columns: {
      identifier: [0, 'customer_ID'],
      editable: [[1, 'customer_Type'], [5, 'customer_LP'], [6, 'customer_Debt'], [7, 'discount_ID']]
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
