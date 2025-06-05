<!-- Page Content  -->
 <div class="content-page mb-5">
    <div class="container-fluid">
        <div class="row content-body">
            <!-- template -->
            <div id="product-template" style="display: none;">
                <div class="wrapper-addreferral product-group" data-index="__INDEX__">
                    <label for="alias">Product</label>
                    <select name="products[__INDEX__][name]" class="form-control product-select mb-2" onchange="updateAccessOptions(this)">
                        <option value="">-- Select Product --</option>
                        <?php foreach (array_keys($product) as $index => $p): ?>
                            <option
                                value="<?= htmlspecialchars($p) ?>"
                                data-access='<?= json_encode($product[$p]['access']) ?>'>
                                <?= ucfirst(htmlspecialchars($p)) ?>
                            </option>
                        <?php endforeach; ?>

                    </select>
                    <div class="wrapper-addreferral access-container">
                        <label for="access">Access</label>
                        <div class="role-wrapper">

                        </div>
                    </div>
                </div>
            </div>
            <!-- end template -->
            <div class="col-lg-12">

                <form action="<?= BASE_URL ?>godmode/admin/create_admin" method="POST">
                    <div class="send-signals">
                        <div class="title-signal-preview d-flex justify-content-between align-items-center">
                            <h4>Add Admin</h4>
                        </div>

                        <div class="main-send-signal d-flex flex-column align-items-center justify-content-center">
                            <div class="row w-100">
                                <div class="form-addreferral col-8 mx-auto">
                                    <div class="wrapper-addreferral">
                                        <label for="email">Email</label>
                                        <input type="email" name="email" class="form-control">
                                    </div>
                                    <div class="wrapper-addreferral">
                                        <label for="alias">Alias/Nickname</label>
                                        <input type="text" name="alias" class="form-control">
                                    </div>
                                    <div id="product-container">
                                        <!-- Product access -->
                                    </div>

                                    <button type="button" class="btn" onclick="addNewProduct()" id="addproduct">Add More Product +</button>
                                    <div class="wrapper-addreferral d-flex justify-content-center">
                                        <button type="submit" id="submitBtn" class="btn btn-primary">Create</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-lg-12 dash-table-referralmember mt-5">
                <h4 class="text-white my-3 text-uppercase fw-bold">Admin</h4>
                <table id="tbl_freemember" class="table table-striped" style="width:100%">
                    <thead class="thead_freemember">
                        <tr>
                            <th>EMAIL</th>
                            <th>MENU ACCESS</th>
                            <th>ACTION</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
