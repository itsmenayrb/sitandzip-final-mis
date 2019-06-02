$(document).ready(function() {
  
  var Arrays=new Array();
  var product_nameArray = [];
  var product_quantityArray = [];
  var product_priceArray = [];
   
  
  $('#button-container li').click(function(){
    
    var thisID = $(this).attr('id');
    

    var itemname  = $(this).find('button').data('name');
    var itemprice = $(this).find('button').data('price');
      
    //alert(thisID + "" + itemname + "" + itemprice);
    if(include(Arrays,thisID))
    {
      var price    = $('#each-'+thisID).children("td").find('#price').val();
      var quantity = $('#each-'+thisID).children("td").find('#qty').val();
      quantity = parseInt(quantity)+parseInt(1);

      var total = parseInt(itemprice)*parseInt(quantity);

      // product_nameArray[thisID] = total;
      // var pos = include(product_quantityArray, Arrays);
      // product_quantityArray.splice(pos, 1, quantity);
      
      
      $('#each-'+thisID).children("td").find('#price').val(total.toFixed(2));
      $('#each-'+thisID).children("td").find('#qty').val(quantity);
      
      var prev_charges = $('.well th input#totalAmount').val();
      prev_charges = parseInt(prev_charges)-parseInt(price);
      prev_charges = parseInt(prev_charges)+parseInt(total);
      $('.well th input#totalAmount').val(prev_charges.toFixed(2));
      $('.well th input#totalAmounthidden').val(prev_charges);
      // $('#total-hidden-charges').val(prev_charges);
    }
    else
    {
      Arrays.push(thisID);
      //product_nameArray.push(itemname);
      // product_quantityArray.push(parseInt(1));
      // product_priceArray.push(itemprice);
      
      var prev_charges = $('.well th input#totalAmount').val();
      prev_charges = parseInt(prev_charges)+parseInt(itemprice);
      
      $('.well th input#totalAmount').val(prev_charges.toFixed(2));
      $('.well th input#totalAmounthidden').val(prev_charges);
      // $('#total-hidden-charges').val(prev_charges);
      
      var inputProductName = "<input type='text' name='productName[]' value='"+itemname+"' id='productNameText' readonly/>";
      var inputQty = "<input type='number' min='1' value='1' id='qty' class='qty' data-thisprice='"+itemprice+"' name='qty[]'/>";
      var inputPrice = "<input type='text' id='price' value='" + itemprice + "' name='price[]' readonly/>";
      // var inputSubTotal = "<input type='text' id='subTotal' name='subTotal[]' value='"+itemprice+"' readonly/>";

      var removeThisRow = "<button type='button' class='btn btn-sm btn-danger remove'>X</button>";

      var markup = "<tr id='each-"+thisID+"'><td>" + inputProductName + "</td><td>" + inputQty + "</td><td style='text-align: right;'>" + inputPrice + "</td><td style='text-align: center;'>" + removeThisRow + "</td></tr>";

      $("#transaction-table tbody").append(markup);
      
      
    }

    rowCount();
  });


  $('#summaryBtn').livequery('click', function() {

    var transaction_id = $('#hiddenTransactionId').val();
    var transact_by = $('#hiddenTransactBy').val();
    var totalAmount = $('#totalAmount').val();
    var payment = $('#customerPaymenthidden').val();
    var change = $('#customerChangehidden').val();

    $('td input#qty').each(function() {
      var quantity = $(this).val() || 0;
      product_quantityArray.push(parseInt(quantity));
    });

    $('td input#price').each(function() {
      var price = $(this).val() || 0;
      product_priceArray.push(parseInt(price));
    });

    $('td input#productNameText').each(function() {
      var product_name = $(this).val();
      product_nameArray.push(product_name);
    });

    $.ajax({

      method: 'POST',
      url: './controller/PosController.php',
      dataType: 'json',
      data: {
        transact_by: transact_by,
        transaction_id: transaction_id,
        product_name: product_nameArray,
        quantity: product_quantityArray,
        price: product_priceArray,
        totalAmount: totalAmount,
        payment: payment,
        change: change,
        save: 1
      },
      success: function(response) {
        $('#transaction-form')[0].reset();
        $('hiddenTransactionId').text(response);
        $('#transaction-id-span').text(response);

        Arrays.length = 0;
        $('#transaction-table > tbody').html('');

        $('.modal').each(function() {
          $(this).modal('hide');
        });

        Swal.fire({
          timer: 1000,
          onBeforeOpen: () => {
            Swal.showLoading()
          }
        });
        setTimeout(function() {
          Swal.fire({
            title: 'Transaction saved.',
            type: 'success'
          });        
        }, 1000);
      }
    });

  }); 
  
  
  $('.remove').livequery('click', function() {
    
    var deduct = $(this).parent().parent().children('td').find('#price').val();
    var prev_charges = $('.well th input#totalAmount').val();
    
    var thisID = $(this).parent().parent().attr('id').replace('each-','');
    //alert(thisID);
    
    var pos = getpos(Arrays,thisID);
    Arrays.splice(pos,1,"0");
    
    prev_charges = parseInt(prev_charges)-parseInt(deduct);
    $('.well th input#totalAmount').val(prev_charges.toFixed(2));
    $(this).parent().parent().remove();
    rowCount();
    
  });

  $('.qty').livequery('change', function() {

    var quantity = $(this).val();
    var price = $(this).data('thisprice');

    var subtotal = parseInt(quantity)*parseInt(price);
    
    $(this).parent().parent().children('td').find('#price').val(subtotal.toFixed(2));

    var totalAmount = 0;

    $('td input#price').each(function() {
      var valString = $(this).val() || 0;
      totalAmount += parseInt(valString);
    });

    //console.log(quantity + " " + price + " " + deduct);

    $('.well th input#totalAmount').val(totalAmount.toFixed(2));
    $('.well th input#totalAmounthidden').val(totalAmount);

  }); 
  
  $('.finalize-sale-btn').livequery('click', function() {
    
    Swal.fire({
      title: 'Finalize order?',
      type: 'question',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes!',
    }).then((result) => {
      if(result.value) {
        Swal.fire({
          title: 'Finalizing...',
          timer: 1000,
          onBeforeOpen: () => {
            Swal.showLoading()
          }
        });
        setTimeout(function() {
          $('#paymentModal').modal({
            backdrop: 'static',
            keyboard: false
          },'show');
        }, 1000);
      }
    });
    
  });

  $('#getPaymentBtn').livequery('click', function(e) {
    e.preventDefault();

    var totalAmounts = $('#totalAmount').val();
    var totalAmount = $('#totalAmounthidden').val();
    var payment = +$('#paymentInput').val();
    var change = 0;

    if (!isNumeric(payment)) {
      Swal.fire({
        type: 'error',
        title: 'Oops!',
        text: 'You have entered incorrect value.'
      });
    } else if (payment < 1 || payment == ''){
      Swal.fire({
        type: 'error',
        title: 'Oops!',
        text: 'Invalid amount.'
      });
    } else if (payment < totalAmount) {
      Swal.fire({
        type: 'error',
        title: 'Oops!',
        text: 'Insufficient payment.'
      });
    } else {
      
      change = payment - totalAmount;

      $('#customerPayment').val(numberWithCommas(payment.toFixed(2)));
      $('#customerChange').val(numberWithCommas(change.toFixed(2)));

      $('#customerPaymenthidden').val(payment.toFixed(2));
      $('#customerChangehidden').val(change.toFixed(2));

      $('#totalAmountSpan').text("P " + numberWithCommas(totalAmount));
      $('#paymentSpan').text("P " + numberWithCommas(payment));
      $('#changeSpan').text("P " + numberWithCommas(change));

      $('#paymentModal').modal('hide');

      $('#summaryModal').modal({
        backdrop: 'static',
        keyboard: false
      },'show');

      return true;

    }

    return false;

  })

   
  
});

function include(arr, obj) {
  for(var i=0; i<arr.length; i++) {
    if (arr[i] == obj) return true;
  }
}
function getpos(arr, obj) {
  for(var i=0; i<arr.length; i++) {
    if (arr[i] == obj) return i;
  }
}

function checkquantity(arr, obj) {
  for (var i=0; i<arr.length; i++) {
    if (arr[i] == obj[i]) return true;
  }
}

function rowCount() {

  var rowCount = $('#transaction-table tbody tr').length;

  if (rowCount == 0) {
    $('.finalize-sale-btn').attr('disabled', 'disabled');
    $('#paymentBtn').attr('disabled', 'disabled');
  } else {
    $('.finalize-sale-btn').removeAttr('disabled');
    //$('.pos-btn').removeAttr('disabled');
  }

}

function isNumeric(n) {
  return !isNaN(n);
}

function numberWithCommas(x) {
    var parts = x.toString().split(".");
    parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    return parts.join(".");
}