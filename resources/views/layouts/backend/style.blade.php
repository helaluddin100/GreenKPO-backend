<!-- core:css -->
<link rel="stylesheet" href="{{ asset('assets/vendors/core/core.css') }}">
<link rel="stylesheet" href="{{ asset('assets/vendors/select2/select2.min.css') }}" />

<!-- endinject -->
<link rel="stylesheet" href="{{ asset('assets/vendors/datatables.net-bs5/dataTables.bootstrap5.css') }}">

<!-- Plugin css for this page -->
<link rel="stylesheet" href="{{ asset('assets/vendors/flatpickr/flatpickr.min.css') }}">
<!-- End plugin css for this page -->

<!-- inject:css -->
<link rel="stylesheet" href="{{ asset('assets/fonts/feather-font/css/iconfont.css') }}">
<link rel="stylesheet" href="{{ asset('assets/vendors/flag-icon-css/css/flag-icon.min.css') }}">
<!-- endinject -->

<!-- Layout styles -->
<link rel="stylesheet" href="{{ asset('assets/css/demo2/style.css') }}">
<!-- End layout styles -->

<link rel="shortcut icon" href="{{ asset('assets/images/favicon.png') }}" />
<link rel="stylesheet" href="{{ asset('assets/vendors/easymde/easymde.min.css') }}" />



<style>
    .progress-wrapper {
        display: none;
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 50%;
        background: rgba(0, 0, 0, 0.8);
        color: white;
        text-align: center;
        padding: 20px;
        border-radius: 10px;
        z-index: 9999;
    }

    .progress-bar {
        width: 0;
        height: 30px;
        background-color: green;
        margin-top: 10px;
        border-radius: 5px;
    }
</style>
