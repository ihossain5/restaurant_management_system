<div class="modal fade bs-example-modal-center" id="RestaurantAdd" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel"
aria-hidden="true">
<div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
        <div class="modal-header d-block">
            <h5 class="modal-title mt-0 text-center">Add New Restaurant</h5>
            <button type="button" class="close modal_close_icon" data-dismiss="modal" aria-hidden="true">×</button>
        </div>
        <div class="modal-body">
            <form id="restaurantAddForm" method="POST" enctype="multipart/form-data"> @csrf
                <div class="form-row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" class="form-control" name="name" placeholder="Type name" />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Type</label>
                            <input type="text" class="form-control" name="type" placeholder="Type" />
                        </div>
                    </div>
                </div>

                <div class="form-row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Contact</label>
                            <input type="text" class="form-control" name="contact"
                                placeholder="Type contact no" />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Email</label>
                            <input type="text" class="form-control" name="email" placeholder="Type email" />
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label>Description</label>
                    <textarea name="description" id="" class="form-control" cols="30" rows="3"></textarea>
                </div>
                <div class="form-group">
                    <label>Address</label>
                    <textarea name="address" id="" class="form-control" cols="30" rows="3"></textarea>
                </div>
                <div class="form-group">
                    <label>Logo</label>
                    <div class="custom-file">
                        <input type="file" name="logo" class="custom-file-input dropify"
                            data-id="0" data-errors-position="outside"
                            data-allowed-file-extensions='["jpg", "png"]' data-max-file-size="0.6M" data-height="80"
                          >
                    </div>
                </div>
                <label for="">Photos</label>
                <div class="row asset_row  asset_div0">
                    <div class="col-md-11">
                        <div class="form-group ">
                            <div class="custom-file">
                                <input type="file" name="asset[][asset]" class="custom-file-input dropify" id="asset0"
                                    data-id="0" data-errors-position="outside"
                                    data-allowed-file-extensions='["jpg", "png"]' data-max-file-size="0.6M"
                                    data-height="80">
                            </div>
                            <span class="error_msg0 text-danger"></span>
                        </div>
                    </div>

                    <div class="col-md-1">
                        <div class=" remove_row0" onclick="remove(0)"><i
                                class="mdi mdi-delete close_icon_add_form"></i></div>
                    </div>
                </div>
     
                <button class="btn btn-primary add_row_btn float-right" onclick="addRow()" type="button"><i class="fa fa-plus"></i>   Add</button>

                <div class="form-group mt-5">
                    <div>
                        <button type="submit"  class="btn btn-block btn-success waves-effect waves-light">
                            Submit
                        </button>

                    </div>
                </div>
            </form>
        </div>
    </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
</div>