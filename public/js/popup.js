var popupTitle = $('#popupModalTitle');
var popupContent = $('#popupModalContent');
var updateItemId = $('#itemId');
var updateItemName = $('#updateItem');
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

function setUpdateItemId(itemId) {
    updateItemId.val(itemId);
}

function setUpdateItemName(itemName) {
    updateItemName.val(itemName);
}

function setUpdatePrice(price) {
    updatePrice.val(price);
}

function setUpdatePayer (payer) {
    $('#updatePayer option:contains("' + payer + '")').prop('selected', true);
}