$(document).on('hidden.bs.modal', function () {
    if($('.modal.show').length > 0) {
        $('body').addClass('modal-open');
    }
});
