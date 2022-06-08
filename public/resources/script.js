//Split Equally in Add New Bill to All
$("#splitEqual").click(function(event) {
    var noOfPersons = document.getElementsByClassName("inputForAddBillToAll").length;
    var amount = document.getElementById("splitEqualField").value;
    $('.inputForAddBillToAll').val(amount/noOfPersons);
});

function hideInputFieldsInAddBillToAll() { 
    $("#individualAmountInAddToAll").prop("hidden", true);
    $(".inputForAddBillToAll").prop("hidden", true);
    $(".labelForAddBillToAll").prop("hidden", true);
    $("#splitEqual").click(function (event) {
        var amount = document.getElementById("splitEqualField").value;
        $('#sumForAddBillToAll').text(amount);
        var labels = document.getElementsByClassName("labelForAddBillToAll");
        var inputFields = document.getElementsByClassName("inputForAddBillToAll");
        var splitValues = "";
        for(var i=0; i<inputFields.length; i++){
            splitValues = splitValues + labels[i].innerHTML + ' - ' + inputFields[i].value + '<br>';
        }
        $('#amountSplittedEqually').text('Amount Splitted Equally');
        $('#splitValues').html(splitValues);
    });
}

function showInputFieldsInAddBillToAll() { 
    $(".inputForAddBillToAll").prop("hidden", false);
    $(".labelForAddBillToAll").prop("hidden", false);
    $("#individualAmountInAddToAll").prop("hidden", false);
    $('#sumForAddBillToAll').text('0');
    $('#amountSplittedEqually').text('');
}
