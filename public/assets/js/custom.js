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
    // If the method is PUT, add a hidden _method field to FormData
    if (method === 'PUT') {
        formData.append('_method', 'PUT');
    }

    fetch(url, {
        method: 'POST', // Always use POST, even for PUT or DELETE
        headers: {
            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content"),
        },
        body: formData,
    })
    .then(response => response.json())
    .then(response => {
        if (response.success) {
            // Hide the modal
            var transactionModal = document.getElementById('transactionModal');
            var modalInstance = bootstrap.Modal.getInstance(transactionModal);
            modalInstance?.hide();

            setToastMessage("Transaction has been successfully processed.");
            // Reload the page
            window.location.reload();
        } else {
            swalWithBootstrapButtons.fire({
                title: "Error",
                text: "An error occurred: " + response.message,
                icon: "error",
            });
        }
    })
    .catch(error => {
        let errorMessage = "An error occurred. Please try again.";
        if (error.response && error.response.errors) {
            let errorList = "";
            for (let field in error.response.errors) {
                if (error.response.errors.hasOwnProperty(field)) {
                    error.response.errors[field].forEach((error) => {
                        errorList += `<p class="mb-0">${error}</p>`;
                    });
                }
            }
            errorMessage = errorList;
        }
        swalWithBootstrapButtons.fire({
            title: "Error",
            html: errorMessage,
            icon: "error",
        });
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
                fetch(url, {
                    method: "DELETE",
                    headers: {
                        "X-CSRF-TOKEN": document
                            .querySelector('meta[name="csrf-token"]')
                            .getAttribute("content"),
                    },
                })
                    .then((response) => response.json())
                    .then((response) => {
                        if (response.success) {
                            setToastMessage("Your transaction has been deleted.");
                            // Reload the page
                            window.location.reload();
                        } else {
                            swalWithBootstrapButtons.fire({
                                title: "Error",
                                text: "An error occurred: " + response.message,
                                icon: "error",
                            });
                        }
                    })
                    .catch((error) => {
                        let errorMessage = "An error occurred. Please try again.";
                        if (error.response && error.response.errors) {
                            let errorList = "";
                            for (let field in error.response.errors) {
                                if (error.response.errors.hasOwnProperty(field)) {
                                    error.response.errors[field].forEach((err) => {
                                        errorList += `<p class="mb-0">${err}</p>`;
                                    });
                                }
                            }
                            errorMessage = errorList;
                        }
                        swalWithBootstrapButtons.fire({
                            title: "Error",
                            html: errorMessage,
                            icon: "error",
                        });
                    });
            }
        });
}

function openModalForAdd() {
    const form = document.querySelector('.transactionForm');
    form?.reset();

    document.getElementById("transactionModalTitle").textContent = "New Transaction";
    document.getElementById("transactionModalSubmitBtn").textContent = "Add";
    form.querySelector("#transaction_id").value = "";

    const modalElement = document.getElementById("transactionModal");
    const modal = new bootstrap.Modal(modalElement);

    // Ensure backdrop is removed and modal disposed on close
    modalElement.addEventListener('hidden.bs.modal', function () {
        document.body.classList.remove('modal-open'); // Remove modal-open class from body
        const backdrop = document.querySelector('.modal-backdrop');
        if (backdrop) backdrop.remove(); // Remove leftover backdrop
        modal.dispose(); // Properly dispose of the modal instance
    });

    modal.show();
}

function openModalForEdit(element) {
    // Get the transaction ID from the data-id attribute
    const transactionId = element.parentElement.dataset.id;
    var showUrl = window.transactionRoutes.show.replace('__TRANSACTION_ID__', transactionId);
    var modalDiv = document.getElementById("modalDiv");
    var form=modalDiv.querySelector(".transactionForm");

    // Update the modal title and submit button text
    modalDiv.querySelector("#transactionModalTitle").textContent = "Edit Transaction";
    modalDiv.querySelector("#transactionModalSubmitBtn").textContent = "Update";

    // Fetch transaction data from the server
    fetch(showUrl, {
        method: 'GET'
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const transaction = data.data;

            // Populate the form fields with the fetched data
            modalDiv.querySelector("#transaction_id").value = transaction.id;

            // Handle the 'type' field
            const typeValue = transaction.type; // Ensure this matches your enum values
            const typeInput = modalDiv.querySelector(`input[name="type"][value="${typeValue}"]`);
            if (typeInput) {
                typeInput.checked = true;
                changeTransactionType(typeValue,form);
            }

            modalDiv.querySelector("#src_account_id").value = transaction.src_account_id || '';
            modalDiv.querySelector("#dest_account_id").value = transaction.dest_account_id || '';
            modalDiv.querySelector("#amount").value = transaction.amount || '';
            modalDiv.querySelector("#category_id").value = transaction.category_id || '';
            modalDiv.querySelector("#details").value = transaction.details || '';
            modalDiv.querySelector("#transaction_date").value = transaction.transaction_date || '';

            // Show the modal (assuming Bootstrap 5 is used)
            const transactionModalElement = document.getElementById('transactionModal');
            const transactionModal = new bootstrap.Modal(transactionModalElement);
            transactionModal.show();
        }
    });
}

function changeTransactionType(type, form) {
    if (!type){
        return;
    }
    var isTransfer = type === "Transfer";
    var isExpenseOrIncome = type === "Expense" || type === "Income";

    // Toggle 'active' class on buttons
    form.querySelector("#expense-btn").classList.toggle("active", type === "Expense");
    form.querySelector("#income-btn").classList.toggle("active", type === "Income");
    form.querySelector("#transfer-btn").classList.toggle("active", isTransfer);

    // Show or hide the 'To Account' collapse section
    var collapseToAccount = form.querySelector("#collapseToAccount");
    if (collapseToAccount) {
        var selectElement = collapseToAccount.querySelector("select");
        if (selectElement) {
            isTransfer ? selectElement.setAttribute("required", "") : selectElement.removeAttribute("required");
        }
        collapseToAccount.style.display = isTransfer ? "" : "none";
    }

    // Update the account label
    var accountLabel = form.querySelector("#account-label");
    if (accountLabel) {
        accountLabel.innerHTML = isTransfer
            ? "From Account <span class='text-danger'>*</span>"
            : "Account <span class='text-danger'>*</span>";
    }

    // Show or hide category and wallet fields
    var categoryField = form.querySelector("#category-field");
    if (categoryField) {
        categoryField.style.display = isExpenseOrIncome ? "" : "none";
    }

    var walletField = form.querySelector("#wallet-field");
    if (walletField) {
        walletField.style.display = isExpenseOrIncome ? "" : "none";
    }

    // Adjust amount field and accounts field column size
    var amountField = form.querySelector("#amount-field");
    var accountField = form.querySelector("#account-label").parentNode;
    if (amountField) {
        if (isTransfer) {
            amountField.classList.remove("col-4");
            amountField.classList.add("col-12");
            accountField.classList.remove("col-8");
            accountField.classList.add("col-6");
        } else {
            amountField.classList.remove("col-12");
            amountField.classList.add("col-4");
            accountField.classList.remove("col-6");
            accountField.classList.add("col-8");
        }
    }
}


document.querySelectorAll('.transactionForm').forEach(function (form) {
    form.addEventListener('submit', function (e) {
        e.preventDefault();

        var transactionId = form.querySelector("#transaction_id").value;
        var isEdit = transactionId !== "";

        // Determine the URL based on whether it's an edit or a new transaction
        var url = isEdit
            ? window.transactionRoutes.update.replace("__TRANSACTION_ID__", transactionId)
            : window.transactionRoutes.store;

        var formData = new FormData(form);

        var method = isEdit ? "PUT" : "POST";

        submitTransactionForm(url, formData, method);
    });
});

document.getElementById("transaction-filter-form")?.addEventListener("change", function(event) {
    // Prevent form submission for processing
    event.preventDefault();

    // Get all input and select elements in the form
    const inputs = this.querySelectorAll("input, select");

    // Loop through each input/select element
    inputs.forEach(input => {
        // Check if the input is empty
        if (input.value.trim() === "") {
            // Disable the input before submission
            input.setAttribute("disabled", "disabled");
        } else {
            // Ensure enabled fields remain enabled
            input.removeAttribute("disabled");
        }
    });

    // Submit the form after disabling empty fields
    this.submit();
});

/* Transaction JavaScript */

/* Accounts JavaScript */

document.getElementById("accountForm")?.addEventListener("submit", function (e) {
    e.preventDefault();

    var formData = new FormData(this);
    var url = window.accountRoutes.store;

    addAccount(url, formData);
});

function addAccount(url, formData) {
    var xhr = new XMLHttpRequest();
    xhr.open('POST', url, true);
    
    // Set the CSRF token in the headers
    xhr.setRequestHeader('X-CSRF-TOKEN', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
    
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4) { // Request is completed
            if (xhr.status === 200) {
                var data = JSON.parse(xhr.responseText);
                
                if (data.success) {
                    // Hide the modal
                    var modalElement = document.getElementById('modal-default');
                    var modalInstance = bootstrap.Modal.getInstance(modalElement);
                    modalInstance.hide();

                    setToastMessage("Your account has been added successfully!");

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
            } else {
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
        }
    };

    xhr.onerror = function () {
        swalWithBootstrapButtons.fire({
            title: "Error",
            text: "An error occurred while processing the request.",
            icon: "error",
        });
    };

    // Send the request with FormData
    xhr.send(formData);
}



function fetchAccountData(url) {
    fetch(url, {
        method: 'GET'
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            var account = data.data;
            openEditAccountModal(account);
        }
    })
}


function openEditAccountModal(account) {
    var updateUrl = window.accountRoutes.update.replace('__ACCOUNT_ID__', account.id);

    document.getElementById('editAccountForm').action = updateUrl;

    document.getElementById('editAccountId').value = account.id;
    document.getElementById('editName').value = account.name;
    document.getElementById('editColor').value = account.color;
    document.getElementById('editBalance').value = account.balance;
    document.getElementById('editType').value = account.type;
    document.getElementById('editCurrency').value = account.currency;

    // Show the modal
    var modal = new bootstrap.Modal(document.getElementById('modal-edit'));
    modal.show();
}



document.getElementById("editAccountForm").addEventListener("submit", function (e) {
    e.preventDefault();

    var formData = new FormData(this);
    var url = this.action;

    updateAccount(url, formData);
});

function updateAccount(url, formData) {
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    const options = {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': csrfToken,
        },
        body: formData,
    };

    // Send the request using fetch
    fetch(url, options)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Hide the modal
                const modalElement = document.getElementById('modal-edit');
                const modalInstance = bootstrap.Modal.getInstance(modalElement);
                modalInstance.hide();

                setToastMessage("Your account has been updated successfully!");

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
        })
        .catch(error => {
            let errorMessage = "An error occurred. Please try again.";
            if (error.response && error.response.errors) {
                let errorList = '';
                for (let field in error.response.errors) {
                    if (error.response.errors.hasOwnProperty(field)) {
                        error.response.errors[field].forEach(err => {
                            errorList += `<p class="mb-0">${err}</p>`;
                        });
                    }
                }
                errorMessage = errorList;
            } else if (error.responseText) {
                errorMessage = error.responseText;
            }

            swalWithBootstrapButtons.fire({
                title: "Error",
                html: errorMessage,
                icon: "error",
            });
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
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            
            // Create the request options
            const options = {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                },
            };

            // Send the request using fetch
            fetch(deleteUrl, options)
                .then(response => response.json())
                .then(response => {
                    if (response.success) {
                        setToastMessage("The account has been deleted.");
                        // Reload the page
                        window.location.reload();
                    } else {
                        swalWithBootstrapButtons.fire({
                            title: "Failed",
                            text: response.message,
                            icon: "error"
                        });
                    }
                })
                .catch(error => {
                    swalWithBootstrapButtons.fire({
                        title: "Error",
                        text: "An error occurred. Please try again.",
                        icon: "error"
                    });
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
    // Get all sibling elements with the class 'subcategory-card'
    const siblingCards = Array.from(this.parentElement.children).filter(
        element => element !== this && element.classList.contains('subcategory-card')
    );

    // Toggle visibility for each sibling subcategory card
    siblingCards.forEach(card => {
        card.style.display = card.style.display === 'none' || card.style.display === '' ? 'flex' : 'none';
    });

    const icon = this.querySelector('.category-toggle-icon');
    if (icon) {
        if (icon.classList.contains('fa-chevron-down')) {
            icon.classList.remove('fa-chevron-down');
            icon.classList.add('fa-chevron-up');
        } else {
            icon.classList.remove('fa-chevron-up');
            icon.classList.add('fa-chevron-down');
        }
    }
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

    // Send fetch request to the server to save the category
    fetch('/categories', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            parent_category_id: parentCategoryId,
            name: categoryName,
            icon: "fa fa-check"
        })
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                setToastMessage(data.message);
                inputSelector.value = '';
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
        })
        .catch(error => {
            console.error("Error:", error);
            swalWithBootstrapButtons.fire({
                title: "Error",
                text: "An error occurred. Please try again.",
                icon: "error",
            });
        });
}

function deleteCategory(id, parentId) {
    var categoryId = id;

    swalWithBootstrapButtons.fire({
        title: "Are you sure?",
        text: "You want to delete this category?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Yes, delete it!",
        cancelButtonText: "No, cancel!",
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            fetch('/categories/' + categoryId, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json'
                }
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
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
                        showToast(data.message);
                    } else {
                        swalWithBootstrapButtons.fire({
                            title: "Failed",
                            text: data.message,
                            icon: "error"
                        });
                    }
                })
                .catch(error => {
                    console.error("Error:", error);
                    swalWithBootstrapButtons.fire({
                        title: "Error",
                        text: "An error occurred. Please try again.",
                        icon: "error"
                    });
                });
        }
    });
}


function updateCategory(event) {
    event.preventDefault();

    // Input field for the category name and the new name value
    const inputSelector = event.target.querySelector('.edit-category-input');
    const categoryName = inputSelector.value;

    if (categoryName.trim() === '') {
        Swal.fire({
            title: "Failed",
            text: "Category name cannot be empty",
            icon: "error"
        });
        return;
    }

    const id = document.getElementById('parentCategoryId').value;
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    // Send fetch request to the server to update the category
    fetch(`/categories/${id}`, {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken
        },
        body: JSON.stringify({ name: categoryName })
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                document.querySelector(`#category-${id}-name`).textContent = categoryName;
                inputSelector.value = categoryName;

                const editCategoryModal = document.getElementById('editCategoryModal');
                const modal = bootstrap.Modal.getInstance(editCategoryModal);
                modal.hide();

                showToast(data.message);
            } else {
                let errorList = '';
                if (data.errors) {
                    for (let field in data.errors) {
                        if (data.errors.hasOwnProperty(field)) {
                            data.errors[field].forEach(error => {
                                errorList += `<p class="mb-0">${error}</p>`;
                            });
                        }
                    }
                }
                Swal.fire({
                    title: "Validation Errors",
                    html: errorList,
                    icon: "error",
                });
            }
        })
        .catch(error => {
            Swal.fire({
                title: "Error",
                text: "An error occurred. Please try again.",
                icon: "error"
            });
        });
}

/* Categories JavaScript */

window.onload = function () {
    if (localStorage.getItem('showToast')) {
        const message = localStorage.getItem('toastMessage');
        showToast(message);

        // Remove the flag and message after the toast is displayed
        localStorage.removeItem('showToast');
        localStorage.removeItem('toastMessage');
    }
};

/* Success Toast */

function setToastMessage(message) {
    // Save the message and a flag in localStorage
    localStorage.setItem('showToast', true);
    localStorage.setItem('toastMessage', message);
}

function showToast(message) {
    document.getElementById('successToastBody').innerText = message;
    var toastElement = new bootstrap.Toast(document.getElementById('successToast'));
    toastElement.show();
}

/* Success Toast */

/* Transaction To and From Dropdown */
function filterDestinationOptions(sourceDropdown, destDropdown) {
    const selectedValue = sourceDropdown.value;
    Array.from(destDropdown.options).forEach(option => {
        if (option.value === selectedValue) {
            option.classList.add('d-none');
            if (option.selected) {
                destDropdown.selectedIndex = 0;
            }
        } else {
            option.classList.remove('d-none');
        }
    });
    if (destDropdown.value === selectedValue) {
        destDropdown.selectedIndex = 0;
    }
}
/* Transaction To and From Dropdown */