<script>
    toastr.options = {
        closeButton: true,
        progressBar: true,
        newestOnTop: true,
        timeOut: 3000,
        extendedTimeOut: 2000,
        positionClass: "toast-top-right"
    };

    function showSuccess(message = '') {
        toastr.success(message || 'Your action was successful.');
    }

    function showError(err = {}) {
        const message =
            err?.responseJSON?.message ??
            err?.message ??
            'Something went wrong.';

        toastr.error(message);
    }

    function showWarning(message = '') {
        toastr.warning(message || 'Please try again later.');
    }
</script>