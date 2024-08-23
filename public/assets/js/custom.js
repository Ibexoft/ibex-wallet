const swalWithBootstrapButtons = Swal.mixin({
    customClass: {
        confirmButton: "btn bg-gradient-success",
        cancelButton: "btn bg-gradient-danger",
    },
    buttonsStyling: true,
});

/* Transaction JavaScript */

function submitTransactionForm(url, formData, method) {
    $.ajax({
        url: url,
        method: method,
        data: formData,
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        success: function (response) {
            if (response.success) {
                $("#transactionModal").modal("hide");
                swalWithBootstrapButtons
                    .fire({
                        title: "Success!",
                        text: "Transaction has been successfully processed.",
                        icon: "success",
                    })
                    .then(() => {
                        location.reload();
                    });
            } else {
                console.error(response.message);
                swalWithBootstrapButtons.fire({
                    title: "Error",
                    text: "An error occurred: " + response.message,
                    icon: "error",
                });
            }
        },
        error: function (xhr, status, error) {
            console.error("Error:", error);
            swalWithBootstrapButtons.fire({
                title: "Error",
                text: "An error occurred. Please try again.",
                icon: "error",
            });
        },
    });
}

function deleteTransaction(url) {
    swalWithBootstrapButtons
        .fire({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Yes, delete it!",
            cancelButtonText: "No, cancel!",
            reverseButtons: true,
        })
        .then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: url,
                    method: "DELETE",
                    headers: {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                            "content"
                        ),
                    },
                    success: function (response) {
                        if (response.success) {
                            swalWithBootstrapButtons
                                .fire({
                                    title: "Deleted!",
                                    text: "Your transaction has been deleted.",
                                    icon: "success",
                                })
                                .then(() => {
                                    location.reload();
                                });
                        } else {
                            console.error(response.message);
                            swalWithBootstrapButtons.fire({
                                title: "Error",
                                text: "An error occurred: " + response.message,
                                icon: "error",
                            });
                        }
                    },
                    error: function (xhr, status, error) {
                        console.error("Error:", error);
                        swalWithBootstrapButtons.fire({
                            title: "Error",
                            text: "An error occurred. Please try again.",
                            icon: "error",
                        });
                    },
                });
            } else if (result.dismiss === Swal.DismissReason.cancel) {
                swalWithBootstrapButtons.fire({
                    title: "Cancelled",
                    text: "Your transaction is safe :)",
                    icon: "error",
                });
            }
        });
}

function openModalForAdd() {
    $("#transactionForm")[0].reset();
    $("#transactionModalTitle").text("New Transaction");
    $("#transactionModalSubmitBtn").text("Add");
    $("#transaction_id").val("");
    $("#transactionModal").modal("show");
}

function openModalForEdit(element) {
    $("#transactionModalTitle").text("Edit Transaction");
    $("#transactionModalSubmitBtn").text("Update");

    $("#transaction_id").val($(element).data("id"));
    $('input[name="type"][value="' + $(element).data("type") + '"]')
        .prop("checked", true)
        .trigger("click");
    $("#src_account_id").val($(element).data("src-account-id"));
    $("#dest_account_id").val($(element).data("dest-account-id"));
    $("#amount").val($(element).data("amount"));
    $("#category_id").val($(element).data("category-id"));
    $("#wallet_id").val($(element).data("wallet-id"));
    $("#details").val($(element).data("details"));
    $("#transaction_date").val($(element).data("transaction-date"));

    $("#transactionModal").modal("show");
}

function changeTransactionType(type) {
    var isTransfer = type === "transfer";
    var isExpenseOrIncome = type === "expense" || type === "income";

    $("#expense-btn").toggleClass("active", type === "expense");
    $("#income-btn").toggleClass("active", type === "income");
    $("#transfer-btn").toggleClass("active", isTransfer);

    $("#collapseToAccount").toggle(isTransfer);
    $("#account-label").text(isTransfer ? "From Account" : "Account");
    $("#category-field").toggle(isExpenseOrIncome);
    $("#wallet-field").toggle(isExpenseOrIncome);

    var amountField = $("#amount-field");
    if (isTransfer) {
        amountField.removeClass("col-md-6").addClass("col-md-12");
    } else {
        amountField.removeClass("col-md-12").addClass("col-md-6");
    }
}

function toggleSubcategories(subcategoryId, iconElement) {
    var subcategoryElement = document.getElementById(subcategoryId);
    subcategoryElement.classList.toggle("collapse");
    iconElement.classList.toggle("fa-caret-right");
    iconElement.classList.toggle("fa-caret-down");
}

document.querySelectorAll(".category-checkbox").forEach(function (checkbox) {
    checkbox.addEventListener("change", function () {
        const isChecked = checkbox.checked;
        let allSubCheckboxes = checkbox
            .closest("li")
            .querySelectorAll('input[type="checkbox"]');
        allSubCheckboxes.forEach(function (subCheckbox) {
            subCheckbox.checked = isChecked;
        });
    });
});

$('#transactionForm').on('submit', function(e) {
    e.preventDefault();
    var transactionId = $('#transaction_id').val();
    var isEdit = transactionId !== "";
    var url = isEdit ?
        window.transactionRoutes.update.replace('__TRANSACTION_ID__', transactionId) :
        window.transactionRoutes.store;
    var formData = $(this).serialize();
    var method = isEdit ? "PUT" : "POST";
    submitTransactionForm(url, formData, method);
});

/* Transaction JavaScript */
