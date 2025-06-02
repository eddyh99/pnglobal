<!-- Page Content  -->
<div class="content-page mb-5">
    <div class="container-fluid">

        <!-- <div class="satoshi-signal-container">
            <div class="satoshi-signal-label">SATOSHI SIGNAL</div>
        </div> -->
        <div class="row content-body">
            <div class="col-lg-12 dash-table-referralmember mt-5">
                <h4 class="text-white my-3 text-uppercase fw-bold">Giveaway</h4>
                <table id="table_referralmember" class="table table-striped" style="width:100%">
                    <thead class="thead_referralmember">
                        <tr>
                            <th>EMAIL</th>
                            <th>PROFILE</th>
                            <th>LINK 1</th>
                            <th>LINK 2</th>
                            <th>LINK 3</th>
                            <th>LINK 4</th>
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

<!-- Upgrade Modal -->
<div class="modal fade" id="bonusmodal" tabindex="-1" aria-labelledby="upgradeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content upgrade-member">
            <div class="modal-header">
                <!-- <h5 class="modal-title" id="upgradeModalLabel">Modal title</h5> -->
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span class="text-black" aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" action="<?= BASE_URL ?>godmode/giveaway/sendbonus?type=giveaway">
                    <input type="hidden" name="gid" id="gid">
                    <input type="hidden" name="email" id="emailid">
                    <div class="d-flex flex-column justify-content-center align-items-center">
                        <p>You will give a bonus to this member</p>
                        <h4 class="my-4"><span id="email"></span></h4>
                        <input type="number" name="amount" id="amount" class="form-control text-black" required>
                        <button class="btn-modal-upgrade mb-4 mt-4">Send</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>