<?php if (!empty(session('success'))) { ?>
    <div class="alert alert-success fade show position-absolute" style="top: 1rem; right: 1rem; width: 30%; z-index: 99999;" role="alert">
        <div class="iq-alert-icon">
            <i class="ri-information-line"></i>
        </div>
        <div class="iq-alert-text text-black">
            <?= session('success') ?>
        </div>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <i class="ri-close-line text-black"></i>
        </button>
    </div>
<?php } ?>

<?php if (!empty(session('failed'))) { ?>
    <div class="alert alert-danger fade show position-absolute" style="top: 1rem; right: 1rem; width: 30%; z-index: 99999;" role="alert">
        <div class="iq-alert-icon">
            <i class="ri-information-line"></i>
        </div>
        <div class="iq-alert-text text-black">
            <?= session('failed') ?>
        </div>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <i class="ri-close-line text-black"></i>
        </button>
    </div>
<?php } ?>

<!-- Page Content  -->
<div class="content-page mb-5">
    <div class="container-fluid">

        <div class="row content-body">
            <div class="col-lg-12">
                <h2 class="text-center">Score</h2>
                <div style="margin-bottom: 2rem;">
                    <h4 class="mb-3">Give score to student</h4>
                    <div class="mx-4">
                        <div class="row">
                            <div class="col-2 border border-5 border-primary d-flex align-items-center" style="background-color: rgba(180, 139, 61, 0.2);">
                                <span><b>Name</b></span>
                            </div>
                            <div class="col">
                                <input type="text" class="form-control border-primary" value="Leonardo Da Vinci">
                            </div>
                        </div>
                        <div class="row my-2">
                            <div class="col-2 border border-5 border-primary d-flex align-items-center" style="background-color: rgba(180, 139, 61, 0.2);">
                                <span><b>Material Exam</b></span>
                            </div>
                            <div class="col">
                                <input type="text" class="form-control border-primary" value="100">
                            </div>
                            <div class="col-2 pl-0 d-flex align-items-center">
                                <button class="btn btn-primary w-100 py-2" type="button">SEND SCORE</button>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-2 border border-5 border-primary d-flex align-items-center" style="background-color: rgba(180, 139, 61, 0.2);">
                                <span><b>Demo Trade</b></span>
                            </div>
                            <div class="col">
                                <input type="text" class="form-control border-primary" value="100">
                            </div>
                            <div class="col-2 pl-0 d-flex align-items-center">
                                <button class="btn btn-primary w-100 py-2" type="button">SEND SCORE</button>
                            </div>
                        </div>
                    </div>
                </div>
                <hr style="border: 2px solid #B48B3D;">
            </div>

            <div class="col-lg-12">
                <div style="margin-bottom: 2rem;">
                    <h4 class="mb-3">Create Exam Schedule</h4>
                    <div class="mx-4">
                        <div class="row">
                            <div class="col-2 border border-5 border-primary d-flex align-items-center" style="background-color: rgba(180, 139, 61, 0.2);">
                                <span><b>Title</b></span>
                            </div>
                            <div class="col">
                                <input type="text" class="form-control border-primary text-white" value="Title of course">
                            </div>
                        </div>
                        <div class="row my-3">
                            <div class="col-2 border border-5 border-primary d-flex align-items-center" style="background-color: rgba(180, 139, 61, 0.2);">
                                <span><b>Mentor</b></span>
                            </div>
                            <div class="col">
                                <input type="text" class="form-control border-primary text-white" value="Leonardo Da Vinci">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-2 border border-5 border-primary d-flex align-items-center" style="background-color: rgba(180, 139, 61, 0.2);">
                                <span><b>Start Date</b></span>
                            </div>
                            <div class="col">
                                <input type="date" class="form-control border-primary text-white" value="<?= date('Y-m-d') ?>">
                            </div>
                        </div>
                        <div class="row my-3">
                            <div class="col-2 border border-5 border-primary d-flex align-items-center" style="background-color: rgba(180, 139, 61, 0.2);">
                                <span><b>TIme</b></span>
                            </div>
                            <div class="col">
                                <input type="time" class="form-control border-primary text-white" value="12:00">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-2 border border-5 border-primary d-flex align-items-center" style="background-color: rgba(180, 139, 61, 0.2);">
                                <span><b>Duration</b></span>
                            </div>
                            <div class="col">
                                <input type="time" class="form-control border-primary text-white" value="01:00">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-2 border border-5 border-primary d-flex align-items-center" style="background-color: rgba(180, 139, 61, 0.2);">
                                <span><b>Save to</b></span>
                            </div>
                            <div class="col">
                                <select class="form-control border-primary text-white" name="course_id" id="">
                                    <option value="">Course 1</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-2 invisible" style="background-color: rgba(180, 139, 61, 0.2);">
                                <span><b>Save to</b></span>
                            </div>
                            <div class="col">
                                <small style="color: #B48B3D;">"Save to" is the location where recorded live videos are stored.</small>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end mx-4">
                        <button type="submit" class="btn btn-primary text-uppercase"><b>Save Schedule</b></button>
                    </div>
                </div>
                <hr style="border: 2px solid #B48B3D;">
            </div>

            <div class="col-lg-12 dash-table-referralmember mt-4">
                <h4 class="text-white my-3 text-uppercase fw-bold">Result Score</h4>
                <table id="tbl_freemember" class="table table-striped" style="width:100%">
                    <thead class="thead_freemember">
                        <tr>
                            <th>EMAIL</th>
                            <th>MATERIAL EXAM SCORE</th>
                            <th>DEMO TRADE SCORE</th>
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
