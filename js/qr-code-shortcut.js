qrCodeShortcut.generateQRCode = function() {
    var $form = $('#form');

    // Setting form to save & redirect mode.
    appendHiddenInputToForm('save-and-redirect', qrCodeShortcut.redirectPath);

    // This is a harmless trick to avoid required fields check.
    appendHiddenInputToForm('open-ddp', 1);

    // Submit form.
    formSubmitDataEntry();

    return false;
}

qrCodeShortcut.displayQRCode = function() {
    $('.qr-code-hidden').removeClass('qr-code-hidden');
    $('#submit-btn-qrcode').hide();
}

$(function() {
    if (typeof qrCodeShortcut.displayFormSaveBtnTooltip !== 'undefined') {
        return;
    }

    qrCodeShortcut.displayFormSaveBtnTooltip = displayFormSaveBtnTooltip;

    displayFormSaveBtnTooltip = function() {
        qrCodeShortcut.displayFormSaveBtnTooltip();

        if (typeof qrCodeShortcut.buttonContents !== 'undefined') {
            // Inserting button that generates QR code.
            $('#formSaveTip .btn-group').after(qrCodeShortcut.buttonContents);
        }

        if (typeof qrCodeShortcut.imageContents !== 'undefined') {
            // Inserting QR image.
            $('#questiontable').before(qrCodeShortcut.imageContents);
        }
    }
});
