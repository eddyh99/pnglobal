

<!-- Page Content  -->
<div class="content-page mb-5">
    <div class="container-fluid">
        <div class="row content-body">
            <div class="col-lg-12">
                <div class="send-signals">
                    <div class="title-signal-preview d-flex justify-content-between align-items-center">
                        <h4>Send Signals</h4>
                    </div>
                    <div class="main-send-signal d-flex flex-column align-items-center justify-content-center">
                        <div class="insturctions d-flex flex-column align-items-center justify-content-center">
                            <span class="instructions-title">Instructions</span>
                            <div class="box-insturctions d-flex align-items-center justify-content-center">
                                <h4 class="last-insturctions"><?= @$order?></h4>
                            </div>
                        </div>
                        <div class="signal-preview">
                            <div class="row">
                                <div class="col-12 col-md-6 all-buy">
                                    <div class="wrapper-buy">
                                        <!-- BUY A -->
                                        <div class="buy">
                                            <div class="d-flex align-items-end">
                                                <?php if(!empty($buy_a)){ ?>
                                                    <!-- Jika BUY A sudah send signal -->
                                                    <div class="inside-buy">
                                                        <div class="buy-title d-flex justify-content-between align-items-end">
                                                            <span class="buy-text">BUY - A</span>
                                                            <span id="buy-date-a" class="buy-date">
                                                                <?php
                                                                    $newDate = date('d/m/Y H:i', strtotime(@$buy_a['created_at']));
                                                                    echo $newDate;
                                                                ?>
                                                            </span>
                                                        </div>
                                                        <input 
                                                            id="buy-a"
                                                            type="text" 
                                                            class="price-input" 
                                                            value="<?= @$buy_a['entry_price']?>" 
                                                            name="price" 
                                                            readonly>
                                                    </div>
                                                    <button id="send-buy-a" disabled class="btn btn-primary">Send</button>
                                                <?php } else {?>
                                                    <!-- Jika BUY A belum send signal -->
                                                    <div class="inside-buy">
                                                        <div class="buy-title d-flex justify-content-between align-items-end">
                                                            <span class="buy-text">BUY - A</span>
                                                            <span id="buy-date-a" class="buy-date"></span>
                                                        </div>
                                                        <input 
                                                            id="buy-a"
                                                            type="text" 
                                                            class="price-input"  
                                                            name="price">
                                                    </div>
                                                    <button id="send-buy-a" class="btn btn-primary">Send</button>
                                                <?php } ?>
                                            </div>
                                        </div>
                                        <!-- BUY B -->
                                        <div class="buy">
                                            <div class="d-flex align-items-end">
                                                <?php if(!empty($buy_a) && empty($buy_b)){ ?>
                                                    <!-- Jika BUY A sudah send signal DAN Buy B belum send signal -->
                                                    <div class="inside-buy">
                                                        <div class="buy-title d-flex justify-content-between align-items-end">
                                                            <span class="buy-text">BUY - B</span>
                                                            <span id="buy-date-b" class="buy-date"></span>
                                                        </div>
                                                        <input 
                                                            id="buy-b"
                                                            type="text" 
                                                            class="price-input" 
                                                            name="price"
                                                        >
                                                    </div>
                                                    <button id="send-buy-b" class="btn btn-primary">Send</button>
                                                <?php } else {?>
                                                    <!-- Jika Buy B sudah send signal -->
                                                    <div class="inside-buy">
                                                        <div class="buy-title d-flex justify-content-between align-items-end">
                                                            <span class="buy-text">BUY - B</span>
                                                            <span id="buy-date-b" class="buy-date"><?= @$buy_b['created_at']?></span>
                                                        </div>
                                                        <input 
                                                            id="buy-b"
                                                            type="text" 
                                                            class="price-input" 
                                                            name="price"
                                                            value="<?= @$buy_b['entry_price']?>"
                                                            readonly>
                                                    </div>
                                                    <button id="send-buy-b" disabled class="btn btn-primary">Send</button>
                                                <?php } ?>
                                            </div>
                                        </div>
                                        <!-- Buy C -->
                                        <div class="buy">
                                            <div class="d-flex align-items-end">
                                                <?php if(!empty($buy_a) && !empty($buy_b) && empty($buy_c)){ ?>
                                                    <!-- Jika BUY A sudah send signal DAN Buy B sudah send signal DAN Buy C belum send signal -->
                                                    <div class="inside-buy">
                                                        <div class="buy-title d-flex justify-content-between align-items-end">
                                                            <span class="buy-text">BUY - C</span>
                                                            <span id="buy-date-" class="buy-date"></span>
                                                        </div>
                                                        <input 
                                                            id="buy-c"
                                                            type="text" 
                                                            class="price-input" 
                                                            name="price">
                                                    </div>
                                                    <button id="send-buy-c" class="btn btn-primary">Send</button>
                                                <?php } else {?>
                                                    <!-- Jika Buy C sudah send signal -->
                                                    <div class="inside-buy">
                                                        <div class="buy-title d-flex justify-content-between align-items-end">
                                                            <span class="buy-text">BUY - C</span>
                                                            <span id="buy-date-c" class="buy-date"><?= @$buy_c['created_at']?></span>
                                                        </div>
                                                        <input 
                                                            id="buy-c"
                                                            type="text" 
                                                            class="price-input" 
                                                            name="price"
                                                            value="<?= @$buy_c['entry_price']?>"
                                                            readonly>
                                                    </div>
                                                    <button id="send-buy-c" disabled class="btn btn-primary">Send</button>
                                                <?php } ?>
                                            </div>
                                        </div>
                                        <!-- Buy D -->
                                        <div class="buy">
                                            <div class="d-flex align-items-end">
                                                <?php if(!empty($buy_a) && !empty($buy_b) && !empty($buy_c) && empty($buy_d)){ ?>
                                                    <!-- Jika BUY A sudah send signal DAN Buy B sudah send signal DAN Buy C Sudah send signal DAN Buy D belum send signal -->
                                                    <div class="inside-buy">
                                                        <div class="buy-title d-flex justify-content-between align-items-end">
                                                            <span class="buy-text">BUY - D</span>
                                                            <span id="buy-date-d" class="buy-date"></span>
                                                        </div>
                                                        <input 
                                                            id="buy-d"
                                                            type="text" 
                                                            class="price-input" 
                                                            name="price">
                                                    </div>
                                                    <button id="send-buy-d" class="btn btn-primary">Send</button>
                                                <?php } else {?>
                                                    <!-- Jika Buy D sudah send signal -->
                                                    <div class="inside-buy">
                                                        <div class="buy-title d-flex justify-content-between align-items-end">
                                                            <span class="buy-text">BUY - D</span>
                                                            <span id="buy-date-d" class="buy-date"><?= @$buy_d['created_at']?></span>
                                                        </div>
                                                        <input 
                                                            id="buy-d"
                                                            type="text" 
                                                            class="price-input" 
                                                            name="price"
                                                            value="<?= @$buy_d['entry_price']?>"
                                                            readonly>
                                                    </div>
                                                    <button id="send-buy-d" disabled class="btn btn-primary">Send</button>
                                                <?php } ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- SELL SECTION -->
                                <div class="col-12 col-md-6 all-sell mt-5 mt-md-0">
                                    <div class="wrapper-sell">
                                        <!-- Sell A -->
                                        <div class="sell">
                                            <form action="<?=BASE_URL?>godmode/signal/sellsignal" method="POST">
                                                <div class="d-flex align-items-end">
                                                    <input type="hidden" value="Sell A" name="type-sell">
                                                    <?php if(!empty($buy_a)){?>
                                                        <div class="inside-sell">
                                                            <div class="sell-title d-flex justify-content-between align-items-end">
                                                                <span class="sell-text">SELL - A</span>
                                                            </div>
                                                            <input 
                                                                id="sell-a"
                                                                type="text" 
                                                                class="price-input" 
                                                                name="price">
                                                        </div>
                                                        <button id="send-sell-a" class="btn btn-primary">Send</button>
                                                    <?php } else {?>
                                                        <div class="inside-sell">
                                                            <div class="sell-title d-flex justify-content-between align-items-end">
                                                                <span class="sell-text">SELL - A</span>
                                                            </div>
                                                            <input 
                                                                id="sell-a"
                                                                type="text" 
                                                                class="price-input" 
                                                                name="price"
                                                                readonly>
                                                        </div>
                                                        <button id="send-sell-a" disabled class="btn btn-primary">Send</button>
                                                    <?php } ?>
                                                </div>
                                            </form>
                                        </div>
                                        <div class="sell">
                                            <form action="<?=BASE_URL?>godmode/signal/sellsignal" method="POST">
                                                <input type="hidden" value="Sell B" name="type-sell">
                                                <div class="d-flex align-items-end">
                                                    <?php if(!empty($buy_b)){?>
                                                        <div class="inside-sell">
                                                            <div class="sell-title d-flex justify-content-between align-items-end">
                                                                <span class="sell-text">SELL - B</span>
                                                            </div>
                                                            <input 
                                                                id="sell-b"
                                                                type="text" 
                                                                class="price-input" 
                                                                name="price">
                                                        </div>
                                                        <button id="send-sell-b" class="btn btn-primary">Send</button>
                                                    <?php } else {?>
                                                        <div class="inside-sell">
                                                            <div class="sell-title d-flex justify-content-between align-items-end">
                                                                <span class="sell-text">SELL - B</span>
                                                            </div>
                                                            <input 
                                                                id="sell-b"
                                                                type="text" 
                                                                class="price-input" 
                                                                name="price"
                                                                readonly>
                                                        </div>
                                                        <button id="send-sell-b" disabled class="btn btn-primary">Send</button>
                                                    <?php }  ?>
                                                </div>
                                            </form>
                                        </div>
                                        <div class="sell">
                                            <form action="<?=BASE_URL?>godmode/signal/sellsignal" method="POST">
                                                <input type="hidden" value="Sell C" name="type-sell">
                                                <div class="d-flex align-items-end">
                                                    <?php if(!empty($buy_c)){?>
                                                        <div class="inside-sell">
                                                            <div class="sell-title d-flex justify-content-between align-items-end">
                                                                <span class="sell-text">SELL - C</span>
                                                            </div>
                                                            <input 
                                                                id="sell-c"
                                                                type="text" 
                                                                class="price-input" 
                                                                name="price">
                                                        </div>
                                                        <button id="send-sell-c" class="btn btn-primary">Send</button>
                                                    <?php } else {?>
                                                        <div class="inside-sell">
                                                            <div class="sell-title d-flex justify-content-between align-items-end">
                                                                <span class="sell-text">SELL - C</span>
                                                            </div>
                                                            <input 
                                                                id="sell-c"
                                                                type="text" 
                                                                class="price-input" 
                                                                name="price"
                                                                readonly>
                                                        </div>
                                                        <button id="send-sell-c" disabled class="btn btn-primary">Send</button>
                                                    <?php }  ?>
                                                </div>
                                            </form>
                                        </div>
                                        <div class="sell">
                                            <form action="<?=BASE_URL?>godmode/signal/sellsignal" method="POST">
                                                <input type="hidden" value="Sell D" name="type-sell">
                                                <div class="d-flex align-items-end">
                                                    <?php if(!empty($buy_d)){?>
                                                        <div class="inside-sell">
                                                            <div class="sell-title d-flex justify-content-between align-items-end">
                                                                <span class="sell-text">SELL - D</span>
                                                            </div>
                                                            <input 
                                                                id="sell-d"
                                                                type="text" 
                                                                class="price-input" 
                                                                name="price">
                                                        </div>
                                                        <button id="send-sell-d" class="btn btn-primary">Send</button>
                                                    <?php } else {?>
                                                        <div class="inside-sell">
                                                            <div class="sell-title d-flex justify-content-between align-items-end">
                                                                <span class="sell-text">SELL - D</span>
                                                            </div>
                                                            <input 
                                                                id="sell-d"
                                                                type="text" 
                                                                class="price-input" 
                                                                name="price"
                                                                readonly>
                                                        </div>
                                                        <button id="send-sell-d" disabled class="btn btn-primary">Send</button>
                                                    <?php }  ?>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-12 history-table-message">
                <div class="text-white">History</div>
                <table id="table_message" class="table table-striped" style="width:100%">
                    <thead>
                        <tr>
                            <th>ORDER</th>
                            <th>PRICE</th>
                            <th>DATE</th>
                            <th>TIME</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    <?php if(!empty(session('success'))) { ?>
        setTimeout(function() {
            Swal.fire({
                text: `<?= session('success')?>`,
                showCloseButton: true,
                showConfirmButton: false,
                background: '#E1FFF7',
                color: '#000000',
                position: 'top-end',
                timer: 3000,
                timerProgressBar: true,
            });
        }, 100);
    <?php }?>

    <?php if(!empty(session('failed'))) { ?>
        setTimeout(function() {
            Swal.fire({
                text: `<?= session('failed')?>`,
                showCloseButton: true,
                showConfirmButton: false,
                background: '#FFE4DC',
                color: '#000000',
                position: 'top-end',
                timer: 3000,
                timerProgressBar: true,
            });
        }, 100);
    <?php }?>
</script>

