const swalWithBootstrapButtons = Swal.mixin({
    customClass: {
        confirmButton: "btn bg-gradient-success",
        cancelButton: "btn bg-gradient-danger",
    },
    buttonsStyling: true,
});

/* Transaction JavaScript */

function transactionInitialConfiguration() {
    var filterCollapse = document.getElementById("filterCollapse");
    var filterIcon = document.getElementById("filterIcon");

    if (filterCollapse.classList.contains('show')) {
        filterIcon.classList.add("fa-angle-up");
        filterIcon.classList.remove("fa-angle-down");
    } else {
        filterIcon.classList.add("fa-angle-down");
        filterIcon.classList.remove("fa-angle-up");
    }

    filterCollapse.addEventListener("show.bs.collapse", function () {
        filterIcon.classList.remove("fa-angle-down");
        filterIcon.classList.add("fa-angle-up");
    });

    filterCollapse.addEventListener("hide.bs.collapse", function () {
        filterIcon.classList.remove("fa-angle-up");
        filterIcon.classList.add("fa-angle-down");
    });

    var width = window.innerWidth;
    if (width < 768) { // Bootstrap's MD breakpoint
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
                let errorList = '';
                for (let field in xhr.responseJSON.errors) {
                    if (xhr.responseJSON.errors.hasOwnProperty(field)) {
                        xhr.responseJSON.errors[field].forEach(error => {
                            errorList += `<p class="mb-0">${error}</p>`;
                        });
                    }
                }
                errorList += '';
                errorMessage = errorList;
            } else if (xhr.responseText) {
                errorMessage = xhr.responseText;
            }
            swalWithBootstrapButtons.fire({
                title: "Error",
                html: errorMessage,
                icon: "error",
            });
        }
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
                        let errorMessage = "An error occurred. Please try again.";
                        if (xhr.responseJSON && xhr.responseJSON.errors) {
                            let errorList = '';
                            for (let field in xhr.responseJSON.errors) {
                                if (xhr.responseJSON.errors.hasOwnProperty(field)) {
                                    xhr.responseJSON.errors[field].forEach(error => {
                                        errorList += `<p class="mb-0">${error}</p>`;
                                    });
                                }
                            }
                            errorList += '';
                            errorMessage = errorList;
                        } else if (xhr.responseText) {
                            errorMessage = xhr.responseText;
                        }
                        swalWithBootstrapButtons.fire({
                            title: "Error",
                            html: errorMessage,
                            icon: "error",
                        });
                    }
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

function toggleSubcategories(subcategoryId, iconElement, event) {
    event.preventDefault();
    event.stopPropagation();
    var subcategoryElement = document.getElementById(subcategoryId);
    subcategoryElement.classList.toggle("collapse");
    iconElement.classList.toggle("fa-angle-right");
    iconElement.classList.toggle("fa-angle-down");
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

/* Accounts JavaScript */

$("#accountForm").on("submit", function (e) {
    e.preventDefault();

    var formData = new FormData(this);
    var url = '/accounts';

    addAccount(url, formData);
});

function addAccount(url, formData) {
    $.ajax({
        url: url,
        method: 'POST',
        data: formData,
        processData: false,  // Prevent jQuery from automatically transforming the data into a query string
        contentType: false,  // Prevent jQuery from setting the Content-Type header
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        dataType: 'json',
        success: function (data) {
            if (data.success) {
                swalWithBootstrapButtons.fire({
                    title: "Success!",
                    text: "Your account has been created successfully.",
                    icon: "success",
                    confirmButtonText: "OK"
                }).then((result) => {
                    if (result.isConfirmed) {
                        $('#modal-default').modal('hide');
                        window.location.reload();
                    }
                });
            } else {
                let errorList = '';
                for (let field in data.errors) {
                    if (data.errors.hasOwnProperty(field)) {
                        data.errors[field].forEach(error => {
                            errorList += `<p class="mb-0">${error}</p>`;
                        });
                    }
                }
                errorList += '';

                swalWithBootstrapButtons.fire({
                    title: "Validation Errors",
                    html: errorList,
                    icon: "error",
                });
            }
        },
        error: function (xhr, textStatus, errorThrown) {
            let errorMessage = "An error occurred. Please try again.";
            if (xhr.responseJSON && xhr.responseJSON.errors) {
                let errorList = '';
                for (let field in xhr.responseJSON.errors) {
                    if (xhr.responseJSON.errors.hasOwnProperty(field)) {
                        xhr.responseJSON.errors[field].forEach(error => {
                            errorList += `<p class="mb-0">${error}</p>`;
                        });
                    }
                }
                errorList += '';

                errorMessage = errorList;
            } else if (xhr.responseText) {
                errorMessage = xhr.responseText;
            }
            swalWithBootstrapButtons.fire({
                title: "Error",
                html: errorMessage,
                icon: "error",
            });
        }
    });
}


function openEditAccountModal(account) {
    // Set the action URL for the form
    $('#editAccountForm').attr('action', `/accounts/${account.id}`);

    // Populate fields with account data
    $('#editAccountId').val(account.id);
    $('#editName').val(account.name);
    $('#editColor').val(account.color);
    $('#editBalance').val(account.balance);
    $('#editType').val(account.type);
    $('#editCurrency').val(account.currency);

    // Show the modal
    $('#modal-edit').modal('show');
}

$("#editAccountForm").on("submit", function (e) {
    e.preventDefault();

    var formData = new FormData(this);
    var url = this.action;

    updateAccount(url, formData);
});

function updateAccount(url, formData) {
    $.ajax({
        url: url,
        method: 'POST',
        data: formData,
        processData: false,  // Prevent jQuery from automatically transforming the data into a query string
        contentType: false,  // Prevent jQuery from setting the Content-Type header
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        dataType: 'json',
        success: function (data) {
            if (data.success) {
                swalWithBootstrapButtons.fire({
                    title: "Success!",
                    text: "Your account has been updated successfully.",
                    icon: "success",
                    confirmButtonText: "OK"
                }).then((result) => {
                    if (result.isConfirmed) {
                        $('#modal-edit').modal('hide');
                        window.location.reload();
                    }
                });
            } else {
                let errorList = '';
                for (let field in data.errors) {
                    if (data.errors.hasOwnProperty(field)) {
                        data.errors[field].forEach(error => {
                            errorList += `<p class="mb-0">${error}</p>`;
                        });
                    }
                }

                swalWithBootstrapButtons.fire({
                    title: "Validation Errors",
                    html: errorList,
                    icon: "error",
                });
            }
        },
        error: function (xhr, textStatus, errorThrown) {
            let errorMessage = "An error occurred. Please try again.";
            if (xhr.responseJSON && xhr.responseJSON.errors) {
                let errorList = '';
                for (let field in xhr.responseJSON.errors) {
                    if (xhr.responseJSON.errors.hasOwnProperty(field)) {
                        xhr.responseJSON.errors[field].forEach(error => {
                            errorList += `<p class="mb-0">${error}</p>`;
                        });
                    }
                }

                errorMessage = errorList;
            } else if (xhr.responseText) {
                errorMessage = xhr.responseText;
            }

            swalWithBootstrapButtons.fire({
                title: "Error",
                html: errorMessage,
                icon: "error",
            });
        }
    });
}


function deleteAccount(accountId) {
    swalWithBootstrapButtons.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Yes, delete it!",
        cancelButtonText: "No, cancel!",
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: `/accounts/${accountId}`,
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (response) {
                    if (response.success) {
                        swalWithBootstrapButtons.fire({
                            title: "Deleted!",
                            text: "The account has been deleted.",
                            icon: "success"
                        }).then(() => {
                            window.location.reload();
                        });
                    } else {
                        swalWithBootstrapButtons.fire({
                            title: "Failed",
                            text: "Failed to delete the account. Please try again.",
                            icon: "error"
                        });
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.error('AJAX Error:', textStatus, errorThrown);
                    swalWithBootstrapButtons.fire({
                        title: "Error",
                        text: "An error occurred. Please try again.",
                        icon: "error"
                    });
                }
            });
        } else if (result.dismiss === Swal.DismissReason.cancel) {
            swalWithBootstrapButtons.fire({
                title: "Cancelled",
                text: "Your account is safe :)",
                icon: "error"
            });
        }
    });
}

/* Accounts JavaScript */


