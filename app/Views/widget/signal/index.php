<div class="app-content row  mb-5 pb-5 pt-5">
    <div class="app-member mx-auto col-12 col-lg-8  border-1 border-white">
        <div class="dash-signal-preview">
            <div class="main-signal-preview d-flex flex-column align-items-center justify-content-center">
                <div class="insturctions d-flex flex-column align-items-center justify-content-center mt-4">
                    <span class="instructions-title">Instructions</span>
                    <div class="box-insturctions d-flex align-items-center justify-content-center">
                        <h4><?= @$order?></h4>
                    </div>
                </div>
                <div class="signal-preview">
                    <div class="row">
                        <div class="col-6 all-buy">
                            <div class="wrapper-buy">
                                <div class="buy">
                                    <div class="buy-title d-flex justify-content-between align-items-end">
                                        <span class="buy-text">BUY - A</span>
                                        <span class="buy-date"> 
                                            <?php
                                                $newDate = date('d/m/Y H:i', strtotime(@$buy_a['created_at']));
                                                if(!empty($buy_a)){
                                                    echo $newDate;
                                                }
                                            ?>
                                        </span>
                                    </div>
                                    <?php if(!empty($buy_a)){?>
                                        <input type="text" class="price-input" value="<?= @$buy_a['entry_price'] ?>" readonly>
                                    <?php }else{?>
                                        <input type="text" value="-" readonly>
                                    <?php }?>
                                </div>
                                <div class="buy">
                                    <div class="buy-title d-flex justify-content-between align-items-end">
                                        <span class="buy-text">BUY - B</span>
                                        <span class="buy-date">
                                            <?php
                                                $newDate = date('d/m/Y H:i', strtotime(@$buy_b['created_at']));
                                                if(!empty($buy_b)){
                                                    echo $newDate;
                                                }
                                            ?>
                                        </span>
                                    </div>
                                    <?php if(!empty($buy_b)){?>
                                        <input type="text" class="price-input" value="<?= @$buy_b['entry_price'] ?>" readonly>
                                    <?php }else{?>
                                        <input type="text" value="-" readonly>
                                    <?php }?>
                                </div>
                                <div class="buy">
                                    <div class="buy-title d-flex justify-content-between align-items-end">
                                        <span class="buy-text">BUY - C</span>
                                        <span class="buy-date"> 
                                        <?php
                                            $newDate = date('d/m/Y H:i', strtotime(@$buy_c['created_at']));
                                            if(!empty($buy_c)){
                                                echo $newDate;
                                            }
                                        ?>
                                        </span>
                                    </div>
                                    <?php if(!empty($buy_c)){?>
                                        <input type="text" class="price-input" value="<?= @$buy_c['entry_price'] ?>" readonly>
                                    <?php }else{?>
                                        <input type="text" value="-" readonly>
                                    <?php }?>
                                   
                                </div>
                                <div class="buy">
                                    <div class="buy-title d-flex justify-content-between align-items-end">
                                        <span class="buy-text">BUY - D</span>
                                        <span class="buy-date"> 
                                            <?php
                                                $newDate = date('d/m/Y H:i', strtotime(@$buy_d['created_at']));
                                                if(!empty($buy_d)){
                                                    echo $newDate;
                                                }
                                            ?>
                                        </span>
                                    </div>
                                    <?php if(!empty($buy_d)){?>
                                        <input type="text" class="price-input" value="<?= @$buy_d['entry_price'] ?>" readonly>
                                    <?php }else{?>
                                        <input type="text" value="-" readonly>
                                    <?php }?>
                                </div>
                            </div>
                        </div>
                        <div class="col-6 all-sell">
                            <div class="wrapper-sell">
                                <div class="sell">
                                    <div class="sell-title d-flex justify-content-between align-items-end">
                                        <span class="sell-text">Sell - A</span>
                                        <span class="sell-date">
                                            <?php
                                                $newDate = date('d/m/Y H:i', strtotime(@$sell_a['created_at']));
                                                if(!empty($sell_a)){
                                                    echo $newDate;
                                                }
                                            ?>
                                        </span>
                                    </div>
                                    <?php if(!empty($sell_a)){?>
                                        <input type="text" class="price-input" value="<?= @$sell_a['entry_price'] ?>" readonly>
                                    <?php }else{?>
                                        <input type="text" value="-" readonly>
                                    <?php }?>
                                </div>
                                <div class="sell">
                                    <div class="sell-title d-flex justify-content-between align-items-end">
                                        <span class="sell-text">Sell - B</span>
                                        <span class="sell-date">
                                            <?php
                                                $newDate = date('d/m/Y H:i', strtotime(@$sell_b['created_at']));
                                                if(!empty($sell_b)){
                                                    echo $newDate;
                                                }
                                            ?>
                                        </span>
                                    </div>
                                    <?php if(!empty($sell_b)){?>
                                        <input type="text" class="price-input" value="<?= @$sell_b['entry_price'] ?>" readonly>
                                    <?php }else{?>
                                        <input type="text" value="-" readonly>
                                    <?php }?>
                                    
                                </div>
                                <div class="sell">
                                    <div class="sell-title d-flex justify-content-between align-items-end">
                                        <span class="sell-text">Sell - C</span>
                                        <span class="sell-date">
                                            <?php
                                                $newDate = date('d/m/Y H:i', strtotime(@$sell_c['created_at']));
                                                if(!empty($sell_c)){
                                                    echo $newDate;
                                                }
                                            ?>
                                        </span>
                                    </div>
                                    <?php if(!empty($sell_c)){?>
                                        <input type="text" class="price-input" value="<?= @$sell_c['entry_price'] ?>" readonly>
                                    <?php }else{?>
                                        <input type="text" value="-" readonly>
                                    <?php }?>
                                </div>
                                <div class="sell">
                                    <div class="sell-title d-flex justify-content-between align-items-end">
                                        <span class="sell-text">Sell - D</span>
                                        <span class="sell-date">
                                            <?php
                                                $newDate = date('d/m/Y H:i', strtotime(@$sell_d['created_at']));
                                                if(!empty($sell_d)){
                                                    echo $newDate;
                                                }
                                            ?>
                                        </span>
                                    </div>
                                    <?php if(!empty($sell_d)){?>
                                        <input type="text" class="price-input" value="<?= @$sell_d['entry_price'] ?>" readonly>
                                    <?php }else{?>
                                        <input type="text" value="-" readonly>
                                    <?php }?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>