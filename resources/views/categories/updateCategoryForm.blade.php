<!-- Modal -->
<div class="col-md-4">
    <div class="modal fade" id="editCategoryModal" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalMessageTitle" aria-hidden="true">
        <div class="modal-dialog modal- modal-dialog-centered modal-" role="document">
            <div class="modal-content">
                <div class="modal-header px-5">
                    <h6 class="modal-title" id="modal-title-default">EDIT CATEGORY</h6>
                    <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body px-5">
                    <form id="updatecategoryForm" role="form text-left" onsubmit="updateCategory(event)">
                        @csrf
                        <div class="row">
                            <input type="hidden" name="_method" value="PUT">
                            <div class="col-sm-12 col-lg-9 form-group">
                                <label for="name">Name</label>
                                <input type="text" class="edit-category-input form-control" id="edit-category-input" placeholder="Category Name"
                                    name="name" id="name" required>
                            </div>
                            <input type="hidden" name="parent_category_id" id="parentCategoryId" value="">
                            <div class="col-sm-12 col-lg-3 form-group">
                                <label for="color">Color</label>
                                <input style="height: 2.5rem;" type="color" value="#cb0c9f" class="form-control"
                                    aria-label="Color" aria-describedby="color-addon" name="color" id="color">
                            </div>
                        </div>
                        <div class="text-center">
                            <button type="submit" id="saveAccountBtn"
                                class="btn bg-gradient-primary w-100 mt-4 mb-0">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>