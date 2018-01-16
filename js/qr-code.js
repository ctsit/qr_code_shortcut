qrCodeShortcut.generateQRCode = function() {
    var $form = $('#form');

    // Setting form to save & redirect mode.
    appendHiddenInputToForm('save-and-redirect', qrCodeShortcut.submitPath);

    // This is a harmless trick to avoid required fields check.
    appendHiddenInputToForm('open-ddp', 1);

    // Submit form.
    formSubmitDataEntry();

    return false;
}

document.addEventListener('DOMContentLoaded', function() {
    if (typeof qrCodeShortcut.buttonContents !== 'undefined') {
        // Inserting button that generates QR code.
        $('#formSaveTip .btn-group').after(qrCodeShortcut.buttonContents);
    }
    else if (typeof qrCodeShortcut.imageContents !== 'undefined') {
        // Inserting QR image.
        $('#questiontable').before(qrCodeShortcut.imageContents);
    }
});
