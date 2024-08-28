const swalWithBootstrapButtons = Swal.mixin({
    customClass: {
        confirmButton: "btn bg-gradient-success",
        cancelButton: "btn bg-gradient-danger",
    },
    buttonsStyling: true,
});

/* Transaction JavaScript */

function transactionInitialConfiguration() {
    const filterButtons = document.querySelectorAll(
        'span[data-bs-toggle="collapse"]'
    );

    filterButtons.forEach(function (button) {
        let icon = button.querySelector("i"); // Directly reference the <i> element within the button

        // Find the specific collapse element associated with this button
        const collapseTarget = document.querySelector(
            button.getAttribute("data-bs-target")
        );

        // Show event for this specific collapse
        collapseTarget.addEventListener("show.bs.collapse", function (event) {
            // Stop any parent events from being triggered
            event.stopPropagation();
            icon.classList.remove("fa-angle-right");
            icon.classList.add("fa-angle-down");
        });

        // Hide event for this specific collapse
        collapseTarget.addEventListener("hide.bs.collapse", function (event) {
            // Stop any parent events from being triggered
            event.stopPropagation();
            icon.classList.remove("fa-angle-down");
            icon.classList.add("fa-angle-right");
        });
    });

    var width = window.innerWidth;
    if (width < 768) {
        // Bootstrap's MD breakpoint
        var bsCollapse = new bootstrap.Collapse(filterCollapse, {
            toggle: false,
        });
        bsCollapse.hide();
    }
}

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
        error: function (xhr, textStatus, errorThrown) {
            let errorMessage = "An error occurred. Please try again.";
            if (xhr.responseJSON && xhr.responseJSON.errors) {
                let errorList = "";
                for (let field in xhr.responseJSON.errors) {
                    if (xhr.responseJSON.errors.hasOwnProperty(field)) {
                        xhr.responseJSON.errors[field].forEach((error) => {
                            errorList += `<p class="mb-0">${error}</p>`;
                        });
                    }
                }
                errorList += "";
                errorMessage = errorList;
            } else if (xhr.responseText) {
                errorMessage = xhr.responseText;
            }
            swalWithBootstrapButtons.fire({
                title: "Error",
                html: errorMessage,
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
                    error: function (xhr, textStatus, errorThrown) {
                        let errorMessage =
                            "An error occurred. Please try again.";
                        if (xhr.responseJSON && xhr.responseJSON.errors) {
                            let errorList = "";
                            for (let field in xhr.responseJSON.errors) {
                                if (
                                    xhr.responseJSON.errors.hasOwnProperty(
                                        field
                                    )
                                ) {
                                    xhr.responseJSON.errors[field].forEach(
                                        (error) => {
                                            errorList += `<p class="mb-0">${error}</p>`;
                                        }
                                    );
                                }
                            }
                            errorList += "";
                            errorMessage = errorList;
                        } else if (xhr.responseText) {
                            errorMessage = xhr.responseText;
                        }
                        swalWithBootstrapButtons.fire({
                            title: "Error",
                            html: errorMessage,
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
    $("#account-label").html(
        isTransfer
            ? "From Account <span class='text-danger'>*</span>"
            : "Account <span class='text-danger'>*</span>"
    );
    $("#category-field").toggle(isExpenseOrIncome);
    $("#wallet-field").toggle(isExpenseOrIncome);

    var amountField = $("#amount-field");
    if (isTransfer) {
        amountField.removeClass("col-md-6").addClass("col-md-12");
    } else {
        amountField.removeClass("col-md-12").addClass("col-md-6");
    }
}

$("#transactionForm").on("submit", function (e) {
    e.preventDefault();
    var transactionId = $("#transaction_id").val();
    var isEdit = transactionId !== "";
    var url = isEdit
        ? window.transactionRoutes.update.replace(
              "__TRANSACTION_ID__",
              transactionId
          )
        : window.transactionRoutes.store;
    var formData = $(this).serialize();
    var method = isEdit ? "PUT" : "POST";
    submitTransactionForm(url, formData, method);
});

/* Transaction JavaScript */
