const swalWithBootstrapButtons = Swal.mixin({
    customClass: {
        confirmButton: "btn bg-gradient-success",
        cancelButton: "btn bg-gradient-secondary",
    },
    buttonsStyling: true,
});

const swalForDeleteConfirmation = Swal.mixin({
    customClass: {
        confirmButton: "btn bg-gradient-danger",
        cancelButton: "btn bg-gradient-secondary",
    },
    buttonsStyling: true,
})
/* Transaction JavaScript */

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
                // Hide the modal
                $('#transactionModal').modal('hide');

                // Save the message and a flag in localStorage
                localStorage.setItem('showToast', true);
                localStorage.setItem('toastMessage', "Transaction has been successfully processed.");

                // Reload the page
                window.location.reload();
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
    swalForDeleteConfirmation
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
                            // Save the message and a flag in localStorage
                            localStorage.setItem('showToast', true);
                            localStorage.setItem('toastMessage', "Your transaction has been deleted.");

                            // Reload the page
                            window.location.reload();
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

/* Accounts JavaScript */

$("#accountForm").on("submit", function (e) {
    e.preventDefault();

    var formData = new FormData(this);
    var url = window.accountRoutes.store;

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
                // Hide the modal
                $('#modal-default').modal('hide');

                // Save the message and a flag in localStorage
                localStorage.setItem('showToast', true);
                localStorage.setItem('toastMessage', "Your account has been added successfully!");

                // Reload the page
                window.location.reload();
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
    var updateUrl = window.accountRoutes.update.replace('__ACCOUNT_ID__', account.id);

    $('#editAccountForm').attr('action', updateUrl);

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
                // Hide the modal
                $('#modal-edit').modal('hide');

                // Save the message and a flag in localStorage
                localStorage.setItem('showToast', true);
                localStorage.setItem('toastMessage', "Your account has been updated successfully!");

                // Reload the page
                window.location.reload();
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
    var deleteUrl = window.accountRoutes.destroy.replace('__ACCOUNT_ID__', accountId);

    swalForDeleteConfirmation.fire({
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
                url: deleteUrl,
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (response) {
                    if (response.success) {
                        // Save the message and a flag in localStorage
                        localStorage.setItem('showToast', true);
                        localStorage.setItem('toastMessage', "The account has been deleted.");

                        // Reload the page
                        window.location.reload();
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

/* Categories JavaScript */

function toggleCategory() {
    $(this).siblings('.subcategory-card').toggle();
    $(this).find('.category-toggle-icon').toggleClass('fa-chevron-down fa-chevron-up');
}

function setCategory(id, isSubcategory = false) { // set id and name of selected category for edit or delete
    if (id) {
        document.getElementById('parentCategoryId').value = id;
        const name = document.querySelector(`#category-${id}-name`).innerText;
        document.getElementById('edit-category-name-input').value = name;
    }
    document.getElementById('add-category-name-input').placeholder = id ? 'Subcategory name' : 'Category name'
    document.getElementById('add-category-form-title').innerText = id ? 'Add Subcategory' : 'Add Category';

    document.getElementById('edit-category-name-input').placeholder = isSubcategory ? 'Edit Subcategory' : 'Edit Category'
    document.getElementById('edit-category-form-title').innerText = isSubcategory ? 'Edit Subcategory' : 'Edit Category';
}

function addCategory(event) {
    event.preventDefault();
    // Get the input field for the subcategory
    const inputSelector = event.target.querySelector('.category-input');
    const categoryName = inputSelector.value;
    inputSelector.value = "";

    if (categoryName.trim() === '') {
        swalWithBootstrapButtons.fire({
            title: "Failed",
            text: "Category name cannot be empty",
            icon: "error"
        });
        return;
    }
    const parentCategoryId = document.getElementById('parentCategoryId').value;
    const addCategoryModal = document.getElementById('addCategoryModal');
    const modal = bootstrap.Modal.getInstance(addCategoryModal);
    modal.hide();

    // Send AJAX request to the server to save the category
    $.ajax({
        url: '/categories',
        method: 'POST',
        data: {
            parent_category_id: parentCategoryId,
            name: categoryName,
            icon: "fa fa-check",
            _token: $('meta[name="csrf-token"]').attr('content')
        },
        success: function (response) {
            if (response.success) {
                swalWithBootstrapButtons.fire({
                    title: "Success!",
                    text: response.message,
                    icon: "success"
                }).then(() => {
                    $(inputSelector).val('');
                    location.reload();
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
        error: function (xhr) {
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

function deleteCategory(id, parentId) {
    var categoryId = id;

    swalWithBootstrapButtons.fire({
        title: "Are you sure?",
        text: "You want want to delete this category?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Yes, delete it!",
        cancelButtonText: "No, cancel!",
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: '/categories/' + categoryId,
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (response) {
                    if (response.success) {
                        swalWithBootstrapButtons.fire({
                            title: "Deleted!",
                            text: response.message,
                            icon: "success"
                        }).then(() => {
                            const categoryElement = document.querySelector(`#category-${categoryId}`);
                            const parentCategory = categoryElement.parentElement;
                            categoryElement.remove();
                            if (parentCategory.querySelectorAll('.subcategory-card').length === 0) { // if no subcategory
                                const categoryTitle = parentCategory.querySelector('.category-title');
                                const icon = categoryTitle.querySelector('.category-toggle-icon');
                                if (icon) {
                                    icon.remove();
                                }
                                const dropdownToggler = parentCategory.querySelector('.dropdown-toggler');
                                dropdownToggler.style.cursor = '';
                                
                                if (parentId) {
                                    const dropdownMenu = parentCategory.querySelector('.dropdown-menu');
                                    const deleteOption = dropdownMenu.querySelector('.delete-option');
                                    if (deleteOption) {
                                        deleteOption.classList.remove('d-none');
                                    }
                                }
                            }
                        });
                    } else {
                        swalWithBootstrapButtons.fire({
                            title: "Failed",
                            text: response.message,
                            icon: "error"
                        });
                    }
                },
                error: function (xhr) {
                    swalWithBootstrapButtons.fire({
                        title: "Error",
                        text: "An error occurred. Please try again.",
                        icon: "error"
                    });
                }
            });
        }
    });
}


function updateCategory(event) {
    event.preventDefault();

    // input field for the category name and the new name value
    const inputSelector = event.target.querySelector('.edit-category-input');
    const categoryName = $(inputSelector).val();

    if (categoryName.trim() === '') {
        swalWithBootstrapButtons.fire({
            title: "Failed",
            text: "Category name cannot be empty",
            icon: "error"
        });
        return;
    }

    const id = document.getElementById('parentCategoryId').value;

    // Send AJAX request to the server to update the category
    $.ajax({
        url: '/categories/' + id,
        method: 'PUT',
        data: {
            name: categoryName,
            _token: $('meta[name="csrf-token"]').attr('content')
        },
        success: function (response) {
            if (response.success) {
                swalWithBootstrapButtons.fire({
                    title: "Updated!",
                    text: response.message,
                    icon: "success"
                }).then(() => {
                    $(`#category-${id}-name`).text(categoryName);
                    $(inputSelector).val(categoryName);
                    const editCategoryModal = document.getElementById('editCategoryModal');
                    const modal = bootstrap.Modal.getInstance(editCategoryModal);
                    modal.hide();
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
        error: function (xhr) {
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

/* Categories JavaScript */

window.onload = function () {
    if (localStorage.getItem('showToast')) {
        // Get the stored message
        const message = localStorage.getItem('toastMessage');

        // Show the toast with the message
        showToast(message);

        // Remove the flag and message after the toast is displayed
        localStorage.removeItem('showToast');
        localStorage.removeItem('toastMessage');
    }
};

/* Success Toast */

function showToast(message) {
    // Set the message dynamically
    document.getElementById('successToastBody').innerText = message;

    // Show the toast
    var toastElement = new bootstrap.Toast(document.getElementById('successToast'));
    toastElement.show();
}

/* Success Toast */
