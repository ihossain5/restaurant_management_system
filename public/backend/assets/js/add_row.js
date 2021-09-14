
// add row into add modal
// var i = 0;
// function addRow(){
//     var asset = $(".asset_row")
//         .find("#asset" + i)
//         .val();
//     if (asset === "") {
//         $(".error_msg" + i)
//             .addClass("mt-1")
//             .text("This field is required");
//         $(".error_msg" + i).show();

//     } else {
//         ++i;

//         var new_i = i - 1;
//         $(".error_msg" + new_i).hide();
//         $(".asset_row:last")
//             .after(` <div class="row asset_row test_row asset_div${i}">                         
//                         <div class="col-md-5">
//                             <div class="form-group">
//                                 <select class="form-control asset error0" name="asset[][asset_type_id]" id="asset${i}" data-id="${i}">
//                                     <option value="">Choose Asset Type</option>
//                                     @foreach ($asset_types as $asset_type)
//                                         <option value="{{ $asset_type->asset_type_id }}">{{ $asset_type->name }}</option>
//                                     @endforeach

//                                 </select>
//                                  <span class="error_msg${i} text-danger"></span>
//                              </div>

//                         </div>  
//                         <div class="col-md-5">
//                         <div class="form-group ">
//                             <div class="custom-file">
//                                 <input type="file" name="asset[][image]" class="custom-file-input dropify" data-id="${i}"
//                                     data-errors-position="outside" data-allowed-file-extensions='["jpg", "png"]'
//                                     data-max-file-size="0.6M" data-height="22">
//                             </div>
//                             <span class="error_msg0 text-danger"></span>
//                         </div>
//                     </div> 

//                         <div class="col-md-2">
//                             <div class=" remove_row${i}" onclick="remove(${i})"><i class="mdi mdi-close close_icon_add_form"></i></div>
//                         </div> 
//                     </div>`);
//     }
// }