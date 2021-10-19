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
    <link href="{{ asset('backend/assets/plugins/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}"
        rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/10.15.5/sweetalert2.min.css"
        integrity="sha512-gX6K9e/4ewXjtn8Q/oePzgIxs2KPrksR4S2NNMYLxenvF7n7eNon9XbqQxb+5jcqYBVCcncIxqF6fXJYgQtoAg=="
        crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/css/dropify.min.css"
        integrity="sha512-EZSUkJWTjzDlspOoPSpUFR0o0Xy7jdzW//6qhUkoZ9c4StFkVsp9fbbd0O06p9ELS3H486m4wmrCELjza4JEog=="
        crossorigin="anonymous" />
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        .badge-custom{
            background-color: #ffff81;
        }
        .bdt_symbol{
            font-size: 16px;
        }
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

        td img {
            border-radius: 50%;
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
            backdrop-filter: blur(1px);
            -webkit-transition: 0.3s;
            transition: 0.3s;
        }

        .side-menu {
            width: 265px;
            /* background: radial-gradient(at 50% -20%, #000000, #000000) fixed; */
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

        .user_role_btn {
            margin-right: 40px;
        }

        .sidebar_user_card {
            background-color: transparent !important;
        }

        .user_name {
            /* color: #eaeaea; */
        }

        .btn_disabled {
            pointer-events: none;
            cursor: not-allowed;
            box-shadow: none;
        }

        /* .btn-outline-purple {
            color: #000000;
            background-color: transparent;
            border-color: #000000;
        }

        .btn-purple {
            color: #ffffff;
            background-color: #000000;
            border-color: #000000;
        }

        .btn-purple:hover,
        .btn-purple:focus,
        .btn-purple:active,
        .btn-purple.active,
        .btn-purple.focus,
        .btn-purple:active,
        .btn-purple:focus,
        .btn-purple:hover,
        .open>.dropdown-toggle.btn-purple,
        .btn-outline-purple.active,
        .btn-outline-purple:active,
        .show>.btn-outline-purple.dropdown-toggle,
        .btn-outline-purple:hover {
            background-color: #000000;
            border: 1px solid #000000;
            color: #ffffff;
        }

        .btn-purple.focus,
        .btn-purple:focus,
        .btn-outline-purple.focus,
        .btn-outline-purple:focus {
            -webkit-box-shadow: 0 0 0 2px rgb(0 0 0 / 30%);
            box-shadow: 0 0 0 2px rgb(0 0 0 / 30%);
        } */

        .btn-success {
            background-color: #28a745;
            border-color: #28a745;
        }


        /* Super Admin Design CSS */

        .superAdminDesign {
            display: inline-block;
            min-width: 115px;
            height: 28px;
            color: #ffffff;
            font-size: 16px;
            font-weight: 400;
            background: #6FD088;
            border-radius: 0px 5px 5px 0px;
            text-align: center;
            /* line-height  : 20px; */
            position: relative;
            z-index: 3;
        }

        .superAdminDesign::after {
            content: '';
            position: absolute;
            top: 0;
            left: -10px;
            margin: auto;
            bottom: 0;
            height: 20px;
            width: 20px;
            background-color: #6FD088;
            transform: rotate(45deg);
            z-index: 1;
        }


        .superAdminDesign::before {
            content: '';
            position: absolute;
            top: 0;
            left: -5px;
            bottom: 0;
            margin: auto;
            height: 5px;
            width: 5px;
            border-radius: 50%;
            background-color: #103863;
            z-index: 2;
        }


        .navbar-custom {
            background-color: #818286;
            color: #FFFFFF;
        }


        .custom-drp {
            color: #000000;
            font-weight: 400;
        }

        .custom-drp img {
            height: 7px;
            width: 14px;
            display: inline-block;
            margin-left: 5px;
            margin-top: -3px;
        }

        .custom-drp:hover {
            color: #FFFFFF;
        }

        .navbar-custom .dropdown.show .nav-link {
            background-color: #818286;
        }


        .addRestaurent {
            color: #892D91;
            font-weight: bold;
        }

        .customDatePicker {
            display: flex;
            justify-content: left;
            border: 2px solid #892D91;
            border-radius: 5px;
            max-width: 176px;
        }


        .customDatePicker:first-child {
            margin-right: 6px;
        }

        .customDatePicker:last-child {
            margin-left: 6px;
        }



        .customDatePicker img {
            margin-left: 12px;
            margin-right: 12px;
        }

        .customDatePicker input {
            border: none;
            color: #892D91 !important;
            font-weight: normal;
            font-size: 18px;
            padding: 0 !important;
        }

        .customDatePicker input::placeholder {
            color: #892D91 !important;
            font-weight: normal;
        }

        .custom-select {
            border: 2px solid #892D91;
            border-radius: 5px;
            height: 100%;
            background-image: url('{{ asset('backend/assets/icons/color-arrow-down.svg') }}');
            background-size: 14px 14px;
            font-weight: 500;
            color: #892D91;
        }


        .custom-select:focus {
            border: 2px solid #892D91;
            color: #892D91;

        }


        .close-btn {
            position: absolute;
            top: 0;
            right: 8px;
            background-color: transparent;
            border: none;
            font-size: 30px;
            cursor: pointer;
        }

        .addModal .modal-title {
            color: #000000;
            font-size: 20px;
            font-weight: bold;
        }


        .add-modal-input label {
            font-size: 18px;
            color: #000000;
        }

        .add-modal-input input {
            font-size: 18px;
            color: #000000;
        }


        .btn-success {
            background-color: #52B85C;
            border: 1px solid #52B85C;
        }

        .csvDesign {
            display: flex;
            justify-content: left;
        }

        .csvDesign select {
            border: none;
            -webkit-appearance: none;
            -moz-appearance: none;
        }


        .downloadDropDown {
            text-align: left;
            height: 100%;
            font-size: 18px;
            cursor: pointer;
        }


        .downloadMenu button {
            background-color: transparent;
            border: none;
            font-size: 24px;
            font-weight: 300;
            line-height: 29px;
            color: #000000;
            cursor: pointer;
            margin-top: 4px;
            margin-bottom: 4px;
        }

        .downloadMenu button img {
            width: 15px;
            height: 17px;
        }


        .btnOutlineOpen,
        .btnOutlineBusy,
        .btnOutlineClose {
            font-weight: bold;
            font-size: 20px;
            color: #00BA07;
            padding: 0 20px 3px 20px;
            background: #EBEBEB;
            border: 2px solid #00BA07;
            border-radius: 5px;
            cursor: pointer;
            text-transform: uppercase;
        }

        .btnOutlineBusy {
            color: #E39436;
            border-color: #E39436;
        }


        .btnOutlineClose {
            color: #FF0000;
            border-color: #FF0000;
        }


        .btnOpen,
        .btnBusy,
        .btnClose {
            font-weight: bold;
            font-size: 20px;
            line-height: 24px;
            color: #00BA07;
            border: 2px solid #00BA07;
            border-radius: 5px;
            padding: 4px 20px;
            width: 108px;
            text-transform: uppercase;
            cursor: pointer;
        }

        .btnBusy {
            color: #E39436;
            border-color: #E39436;
        }

        .btnClose {
            color: #FF0000;
            border-color: #FF0000;
        }

        .close_icon_add_form {
            font-size: 25px;
            cursor: pointer;
            position: absolute;
            margin: 35px -10px;
            /* border: 1px solid #f24734; */
            color: #f24734;
        }

        .add_row_btn {
            padding: 3px 25px;
            margin-right: 40px;
        }




/* Dashboard CSS */
.section-title {
    font-weight: bold;
    font-size  : 20px;
    line-height: 24px;
    color      : #000000;
}


.dashboardCard {
    padding      : 24px;
    border-radius: 10px;
    box-shadow   : 0px 5px 5px rgba(0, 0, 0, 0.25);
}

.dashboardCard:hover {
    background: #CBE2DC;
    box-shadow: 0px 8px 8px rgba(0, 0, 0, 0.25);
}

.card-content h4,
.tableCard h4 {
    font-weight: bold;
    font-size  : 20px;
    line-height: 24px;
    text-align : center;
    color      : #507E6F;
    margin     : 0;
}


.card-content h6 {
    font-size  : 16px;
    font-weight: normal;
    line-height: 20px;
    text-align : center;
    color      : #507E6F;
    margin     : 0;

}

.card-content h2 {
    font-size    : 40px;
    line-height  : 49px;
    font-weight  : normal;
    text-align   : center;
    color        : #000000;
    margin-bottom: 22px;
}


.card-content p {
    font-size  : 16px;
    line-height: 20px;
    color      : #818286;
    margin     : 0;
}

.card-content p img {
    height      : 13px;
    width       : 13px;
    margin-top  : -4px;
    margin-right: 3px;
}


.tableCard {
    padding      : 25px;
    border-radius: 10px;
}

.tableCard h4 {
    text-align: left;
}

.performTable tbody th,
.performTable tbody td {
    padding: 8px 0 20px 0 !important;

}

.performTable tbody tr:first-child th,
.performTable tbody tr:first-child td {
    border-top: none;
}

.performTable .srNo {
    font-weight: normal;
    font-size  : 20px;
    line-height: 24px;
    text-align : center;
    color      : #000000;
}

.performTable .shopInfo h5 {
    margin     : 0;
    font-size  : 20px;
    line-height: 24px;
    font-weight: normal;
    color      : #000000;
}

.performTable .shopInfo h6 {
    margin     : 0;
    font-size  : 14px;
    line-height: 17px;
    color      : #A9A4A4;
}

.performTable .sellPrice,
.performTable .sellQty {
    font-size  : 18px;
    line-height: 22px;
    color      : #000000;
    font-weight: normal;
}

.performTable .sellQty {
    text-align: right;
}


.scrollTable {
    max-height: 382px;
}

.scrollTable::-webkit-scrollbar {
    width           : 0;
    background-color: transparent;
}


/* Second Card */
.secondCardContent {
    display        : flex;
    align-items    : center;
    justify-content: center;
    padding        : 38px 0;
}

.secondCardContent img {
    max-width   : 64px;
    margin-right: 15px;
}

.secondCardContent h1 {
    font-size  : 40px;
    line-height: 49px;
    color      : #08601F;
    font-weight: normal;
    margin     : 0;
}


.secondCardContent h5 {
    font-weight: bold;
    font-size  : 20px;
    line-height: 24px;
    color      : #000000;
    margin     : 0;
}


.activeOrderCard {
    background: #F54949;
    box-shadow: 0px 5px 5px rgba(0, 0, 0, 0.25);
}


.activeOrderCard:hover {
    background: #B90000;
    box-shadow: 0px 8px 8px rgba(0, 0, 0, 0.25);
}

.activeOrderCard h1,
.activeOrderCard h5 {
    color: white;
}

.activeOrderCard svg path {
    fill: white;
}

.side-menu {
    background: linear-gradient(183.46deg, #9AD5C3 0%, #9AD5C3 101.01%) !important;
}
.has_multi_sub .mdi {
    transform: rotate(-90deg);
}

    </style>
