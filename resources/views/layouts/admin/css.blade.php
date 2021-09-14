    <!-- App Icons -->
    <link rel="shortcut icon" href="{{ asset('backend/assets/images/favicon.ico') }}">

    <!-- DataTables -->
    <link href="{{ asset('backend/assets/plugins/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ asset('backend/assets/plugins/datatables/buttons.bootstrap4.min.css') }}" rel="stylesheet"
        type="text/css" />
    <!-- Responsive datatable examples -->
    <link href="{{ asset('backend/assets/plugins/datatables/responsive.bootstrap4.min.css') }}" rel="stylesheet"
        type="text/css" />

    <!--Morris Chart CSS -->
    <link rel="stylesheet" href="{{ asset('backend/assets/plugins/morris/morris.css') }}">

    <!-- Basic Css files -->
    <link href="{{ asset('backend/assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('backend/assets/css/icons.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('backend/assets/css/style.css') }}" rel="stylesheet" type="text/css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/10.15.5/sweetalert2.min.css"
        integrity="sha512-gX6K9e/4ewXjtn8Q/oePzgIxs2KPrksR4S2NNMYLxenvF7n7eNon9XbqQxb+5jcqYBVCcncIxqF6fXJYgQtoAg=="
        crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/css/dropify.min.css"
        integrity="sha512-EZSUkJWTjzDlspOoPSpUFR0o0Xy7jdzW//6qhUkoZ9c4StFkVsp9fbbd0O06p9ELS3H486m4wmrCELjza4JEog=="
        crossorigin="anonymous" />

    <style>
        table i {
            margin-right: 0px;

        }

        td {
            text-align: center;
            vertical-align: middle !important;
        }

        th {
            text-align: center;
            vertical-align: middle !important;
        }

        .modal_close_icon {
            padding: 2px 15px !important;
            margin: -38px -15px !important;
        }

        .ajax_loader {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            /* background-color: #f5f5f5; */
            z-index: 9999999;
            /* filter: blur(4px); */
            backdrop-filter: blur(1px);
            -webkit-transition: 0.3s;
            transition: 0.3s;
        }

        .side-menu {
            width: 265px;
            background: radial-gradient(at 50% -20%, #000000, #000000) fixed;
        }

        .topbar {
            left: 265px;
        }

        .left_sidebar_image {
            max-width: 150px;
            border-radius: 50%;
            margin-right: 35px;
            margin-top: 20px;
        }

        .logged_in_user {
            color: #ffffff;
            margin-right: 40px;
            margin-top: 20px;
        }
        .user_role_btn{
            margin-right: 40px;
        }
        .sidebar_user_card{
            background-color: transparent !important;
        }
        .user_name{
            color: #eaeaea;
        }
        .btn_disabled {
            pointer-events: none;
            cursor: not-allowed;
            box-shadow: none;
        }
          .btn-outline-purple {
            color: #000000;            
            background-color: transparent;
            border-color: #000000;
        }
        .btn-purple {
            color: #ffffff;            
            background-color: #000000;
            border-color: #000000;
        }

        .btn-purple:hover, .btn-purple:focus, .btn-purple:active, .btn-purple.active, .btn-purple.focus, .btn-purple:active, .btn-purple:focus, .btn-purple:hover, .open > .dropdown-toggle.btn-purple, .btn-outline-purple.active, .btn-outline-purple:active, .show > .btn-outline-purple.dropdown-toggle, .btn-outline-purple:hover {
    background-color: #000000;
    border: 1px solid #000000;
    color: #ffffff;
}
.btn-purple.focus, .btn-purple:focus, .btn-outline-purple.focus, .btn-outline-purple:focus {
    -webkit-box-shadow: 0 0 0 2px rgb(0 0 0 / 30%);
    box-shadow: 0 0 0 2px rgb(0 0 0 / 30%);
}

    </style>
