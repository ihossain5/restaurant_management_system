function bdCurrencyFormat(num) {
    var n1, n2;
    num = num + "" || "";
    n1 = num.split(".");
    n2 = n1[1] || null;
    n1 = n1[0].replace(/(\d)(?=(\d\d)+\d$)/g, "$1,");
    num = n2 ? n1 + "." + n2 : n1;
    return num;
}

let allItem = [];
let orderItem;

// function getAllItem() {
//     axios.get('https://emerald.antapp.space/api/items')
//         .then(res => {
//             if (res.status === 200 && res.data.status === true) {
//                 console.log(res.data.data);
//                 allItem = res.data.data;
//             }
//         })
//         .catch(err => {
//             console.log(err);
//         })
// }

function openEditModalAction(orderId) {
    let main_url = window.location.origin;
    axios
        .get(`${main_url}/api/items`)
        .then((res) => {
            if (res.status === 200 && res.data.status === true) {
                console.log(res.data.data);
                allItem = res.data.data;
            }
        })
        .catch((err) => {
            console.log(err);
        });
    axios
        .get(`${main_url}/api/order/${orderId}/details`)
        .then((res) => {
            if (res.status === 200 && res.data.status === true) {
                orderItem = res.data.data;
                // console.log(res.data.data);

                // getAllItem();
                if (allItem.length !== 0) {
                    addExistingItem();
                    $("#orderEditModal").modal("show");
                }
            }
        })
        .catch((err) => {
            console.log("Error");
        });
}

function addExistingItem() {
    // console.log(orderItem);
    let main_url = window.location.origin;
    $(".orderId").html(`#${orderItem.id}`);
    $(".orderIdInput").val(`${orderItem.order_id}`);
    $(".customerName").html(`${orderItem.customer_name}`);
    $(".customerEmail").html(`${orderItem.email}`);
    $(".customerContact").html(`${orderItem.customer_contact}`);
    $(".customerAddress").html(`${orderItem.customer_address}`);
    $(".specialNotes").val(`${orderItem.special_notes ?? ''}`);

    $(".editOrderTable tbody").empty();
    orderItem.items.map((item) => {
        // console.log(item);

        let othersItem = allItem.filter(
            (singleItem) => singleItem.item_id !== item.item_id
        );
        // console.log(othersItem);

        $row_track_id = $(".editOrderTable tbody>tr:last").data("row_track");
        if ($row_track_id == null) {
            $row_track_id = 1;
        } else {
            $row_track_id = $row_track_id + 1;
        }

        $(".editOrderTable tbody").append(`


    <tr data-row_track="${$row_track_id}"  id="row_edit${$row_track_id}">
    <td>
        <select class="itemSelect" onchange="selectItemsAction('${$row_track_id}')" name="item[${$row_track_id}][item_id]
        " id="itemsDesc${$row_track_id}">
        </select>
    </td>
    <td>Tk <span id="defaultPrice${$row_track_id}">${bdCurrencyFormat(
            item.price
        )}</span>
        <input type="hidden" id="defaultUnitPrice${$row_track_id}" name="item[${$row_track_id}][unit_price]" value="${
            item.price
        }">
    </td>
    <td>
        <button onclick="decrementAction('${$row_track_id}')" id="quantityDec${$row_track_id}" type="button" class="incBtn"><img
                src="${main_url}/backend/assets/icons/clarity_minus-line.svg" alt=""></button>
        <span id="quantityShow${$row_track_id}">${item.pivot.quantity}</span>
        <input type="hidden" id="quantity${$row_track_id}" name="item[${$row_track_id}][quantity]" value="${
            item.pivot.quantity
        }">
        <button onclick="incrementAction('${$row_track_id}')" id="quantityInc${$row_track_id}" type="button" class="incBtn"><img
                src="${main_url}/backend/assets/icons/carbon_add.svg" alt=""></button>
    </td>
    <td>Tk <span id="indTotalPriceHtml${$row_track_id}">${
            item.pivot.price
        }</span>
        <input id="indTotalPrice${$row_track_id}" class="totalCost" name="item[${$row_track_id}][individualTotal]" type="hidden" value="${
            item.pivot.price
        }">
    </td>
    <td>
        <button onclick="delete_row('row_edit${$row_track_id}')" id="delBtn${$row_track_id}" class="delBtn"><img src="${main_url}/backend/assets/icons/ic_baseline-delete.svg"
                alt=""></button>
    </td>
</tr>

        
        `);

        $(`#itemsDesc${$row_track_id}`).append(
            $("<option></option>").attr("value", item.item_id).text(item.name)
        );

        $.each(othersItem, function(key, value) {
            $(`#itemsDesc${$row_track_id}`).append(
                $("<option></option>")
                .attr("value", value.item_id)
                .text(value.name)
            );
        });

        totalCalculator();
    });
}

function addListToItem($rowno) {
    console.log(allItem);

    $.each(allItem, function(key, value) {
        $(`#itemsDesc${$rowno}`).append(
            $("<option></option>").attr("value", value.item_id).text(value.name)
        );
    });

    selectItemsAction($rowno);
}

// let totalRow = 0;

function add_row_edit() {
    let main_url = window.location.origin;
    $row_track_id = $(".editOrderTable tbody>tr:last").data("row_track");
    if ($row_track_id == null) {
        $row_track_id = 1;
    } else {
        $row_track_id = $row_track_id + 1;
    }

    $(".editOrderTable tbody").append(`


    <tr data-row_track="${$row_track_id}"  id="row_edit${$row_track_id}">
    <td>
        <select class="itemSelect" onchange="selectItemsAction('${$row_track_id}')" name="item[${$row_track_id}][item_id]
        " id="itemsDesc${$row_track_id}">
        </select>
    </td>
    <td>Tk <span id="defaultPrice${$row_track_id}">500</span>
        <input type="hidden" id="defaultUnitPrice${$row_track_id}" name="item[${$row_track_id}][unit_price]">
    </td>
    <td>
        <button onclick="decrementAction('${$row_track_id}')" id="quantityDec${$row_track_id}" type="button" class="incBtn"><img
                src="${main_url}/backend/assets/icons/clarity_minus-line.svg" alt=""></button>
        <span id="quantityShow${$row_track_id}">1</span>
        <input type="hidden" id="quantity${$row_track_id}" name="item[${$row_track_id}][quantity]" value="1">
        <button onclick="incrementAction('${$row_track_id}')" id="quantityInc${$row_track_id}" type="button" class="incBtn"><img
                src="${main_url}/backend/assets/icons/carbon_add.svg" alt=""></button>
    </td>
    <td>Tk <span id="indTotalPriceHtml${$row_track_id}">1,000</span>
        <input id="indTotalPrice${$row_track_id}" class="totalCost" name="item[${$row_track_id}][individualTotal]" type="hidden">
    </td>
    <td>
        <button onclick="delete_row('row_edit${$row_track_id}')" id="delBtn${$row_track_id}" class="delBtn"><img src="${main_url}/backend/assets/icons/ic_baseline-delete.svg"
                alt=""></button>
    </td>
</tr>

        
        `);

    addListToItem($row_track_id);
}

function delete_row(rowno) {
    $(`#${rowno}`).remove();
    totalCalculator();
}

function selectItemsAction(rowNumber) {
    let selectedItemId = $(`#itemsDesc${rowNumber}`).val();
    let selectItem = allItem.find(
        (item) => item.item_id === parseInt(selectedItemId)
    );
    // console.log(selectItem);

    $(`#defaultUnitPrice${rowNumber}`).val(selectItem.price);
    $(`#defaultPrice${rowNumber}`).html(bdCurrencyFormat(selectItem.price));

    rowWiseCalculation(rowNumber);
}

function rowWiseCalculation(rowNumber) {
    let unitePrice = $(`#defaultUnitPrice${rowNumber}`).val();
    let quantity = $(`#quantity${rowNumber}`).val();
    let cost = unitePrice * quantity;

    $(`#indTotalPriceHtml${rowNumber}`).html(bdCurrencyFormat(cost));
    $(`#indTotalPrice${rowNumber}`).val(cost);

    totalCalculator();
}

function totalCalculator() {
    let totalCost = 0;
    $(".totalCost").each(function() {
        let cleanNumber2 = $(this).val();
        let number = Number(cleanNumber2.replace(/[^0-9\.-]+/g, ""));
        totalCost += parseFloat(number || 0);
    });

    $(".totalAmount").html(bdCurrencyFormat(totalCost));
    $(".totalAmountInput").val(totalCost);
}

function decrementAction(rowNumber) {
    let quantity = $(`#quantity${rowNumber}`).val();

    if (quantity != 1) {
        let decQty = parseInt(quantity) - 1;
        $(`#quantity${rowNumber}`).val(decQty);
        $(`#quantityShow${rowNumber}`).html(decQty);
        rowWiseCalculation(rowNumber);
    }
}

function incrementAction(rowNumber) {
    let quantity = $(`#quantity${rowNumber}`).val();

    let incQty = parseInt(quantity) + 1;
    $(`#quantity${rowNumber}`).val(incQty);
    $(`#quantityShow${rowNumber}`).html(incQty);

    rowWiseCalculation(rowNumber);
}