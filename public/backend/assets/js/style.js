

function addListToItem($rowno) {

    // console.log(allItem);

    // $.each(allItem, function (key, value) {
    //     $(`#itemsDesc${$rowno}`).append($("<option></option>")
    //         .attr("value", value.id)
    //         .text(value.name));
    // });


    // selectItemsAction($rowno)

}




// let totalRow = 0;


function add_row_edit() {

    console.log("ADD")

    $row_track_id = $('.editOrderTable tbody>tr:last').data('row_track');
    if ($row_track_id == null) {
        $row_track_id = 1;
    } else {
        $row_track_id = $row_track_id + 1;
    }


    $(".editOrderTable tbody:last-child").append(`


    <tr data-row_track="${$row_track_id}"  id="row_edit${$row_track_id}">
    <td>
        <select class="itemSelect" onchange="selectItemsAction('${$row_track_id}')" name="item[${$row_track_id}][item_id]
        " id="itemsDesc${$row_track_id}">
            <option value="">Item Name</option>
            <option value="1">Burger</option>
            <option value="2">Pizza</option>
        </select>
    </td>
    <td>Tk <span id="defaultPrice${$row_track_id}">500</span>
        <input type="hidden" id="defaultUnitPrice${$row_track_id}" name="item[${$row_track_id}][unit_price]">
    </td>
    <td>
        <button id="quantityDec${$row_track_id}" type="button" class="incBtn"><img
                src="assets/clarity_minus-line.svg" alt=""></button>
        <span id="quantityShow${$row_track_id}">1</span>
        <input type="hidden" id="quantity${$row_track_id}" name="item[${$row_track_id}][quantity]">
        <button id="quantityInc${$row_track_id}" type="button" class="incBtn"><img
                src="assets/carbon_add.svg" alt=""></button>
    </td>
    <td>Tk <span id="indTotalPriceHtml${$row_track_id}">1,000</span>
        <input id="indTotalPrice${$row_track_id}" name="item[${$row_track_id}][individualTotal]" type="hidden">
    </td>
    <td>
        <button id="delBtn${$row_track_id}" class="delBtn"><img src="assets/ic_baseline-delete.svg"
                alt=""></button>
    </td>
</tr>

        
        `);

    addListToItem($row_track_id);
}


function delete_row(rowno) {
    $(`#${rowno}`).remove();
    // totalCalculator();


}
