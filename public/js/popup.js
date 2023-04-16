var popupTitle = $('#popupModalTitle');
var popupContent = $('#popupModalContent');
var updateItem = $('#updateItem');
var updatePrice = $('#updatePrice');

function popupShow() {
    $('#popupModal').modal('show');
}

function popupClose() {
    $('#popupModal').modal('hide');
}

function setPopupTitle(title) {
    popupTitle.text(title);
}

function setPopupContent(content) {
    popupContent.append(content);
}

function setUpdateItem(itemName) {
    updateItem.val(itemName);
}

function setUpdatePrice(price) {
    updatePrice.val(price);
}

function setUpdatePayer (payer) {
    $('#updatePayer option:contains("' + payer + '")').prop('selected', true);
}