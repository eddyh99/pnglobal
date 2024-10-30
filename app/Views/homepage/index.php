<!-- Start of Banner -->
<div class="banner-homepage">
    <div class="wrapper-banner-homepage" >
        <video autoplay="" preload="" muted="" loop="" playsinline="">
            <source src="<?= BASE_URL ?>assets/vid/banner.webm" type="video/webm">
        </video>
        <div class="logo-banner">
            <div>
                <p id="g-text-banner-homepage" class="logo-text-banner" >
                    <span class="line-animation">
                        YOUR GOAL IS FINANCIAL FREEDOM. <br>
                        <span style="color: #BFA573;">
                            OUR GOAL IS TO MAKE IT HAPPEN.
                        </span>
                    </span>
                </p>    
            </div>

        </div>
    </div>
</div>
<!-- End of Banner -->

<!-- Start of Team Expert -->
<section class="content team-expert-homepage">
    <div class="container">
        <div class="row">
            <div class="col-12 col-lg-7 order-1 order-lg-0 left-side">
                <h2 class="text-primary-pnglobal">Efficiency and Professionalism at the Highest Levels</h2>
                <h5 class="text-primary-pnglobal mt-4">A Team of Experts at Your Service</h5>
                <p>
                    <span translate='no'> PN Global </span> is an Asset Management company that operates mainly in the Bitcoin field without, obviously, neglecting traditional markets.
We operate as a Bitcoin broker and have established an Edge Fund to manage Bitcoin mining. <br>
                    Our operations are mainly aimed at institutional clients and we have chosen to make the operations of our brokers transparent so that all the necessary information is available to all those interested in operating and earning independently.
                </p>
            </div>
            <div class="col-12 col-lg-5 order-0 order-lg-1 bg-team-expert">
            </div>
        </div>
    </div>
</section>
<!-- End of Team Expert -->

<section id="satoshi" class="service-homepage">
    
    <div class="wrapper-big-title">
        <h1 class=" text-uppercase fw-bold">
            Bitcoin Brokerage guidance for buy/sell decisions
        </h1>
    </div>

    <a href="<?php echo BASE_URL . "homepage/service?service=" . base64_encode("satoshi_signal")?>" class="bg-desc-service d-block">
        <div class="container">
            <div class="row">
                <div class="d-none d-lg-block col-1"></div>
                <div class="col-12 col-lg-5 order-1 order-lg-0">
                    <p class="text-desc-service f-noto">
                        Satoshi Signal is not the classic signal room, in reality it is a real App which not only shows when to buy or sell Bitcoin from the signals section but inside it has a messages section where you can choose the language in which to receive messages from the APP setting.
                    </p>
                    <p class="text-desc-service f-noto">
                        These messages explain the motivations and reasoning that lead to the decisions of our brokers which, we hope, will provide lessons to help users create their own strategy over time.
                    </p>
                </div>
                <div class="d-none d-lg-block col-1"></div>
                <div class="col-12 col-lg-5 order-0 order-lg-1 px-5 bg-img-satoshi-homepage">
                    
                </div>
            </div>
        </div>
    </a>
</section>

<!-- Start of Cosulting -->
<section id="productservice" class="content consulting-homepage pt-0">
    <div class="wrapper-big-title">
        <h1 class="fw-bold">
            PRODUCTS AND SERVICES
        </h1>
    </div>

    <!-- Consulting 1 -->
    <div class="row box-consulting-homepage">
        <div onClick="linkproduct('<?php echo BASE_URL . "homepage/service?service=" . base64_encode("finance_advice_investment")?>')" class="col-10 col-lg-8 black" style="cursor: pointer;" >
            <div class="wrapper-consulting">
                <img src="<?= BASE_URL ?>assets/img/img-5.webp" alt="img-2">
                <div class="d-flex justify-content-center w-100">
                    <a 
                        class="link-consulting "
                    >
                        Financial advice, assets <br>
                        and investment
                    </a>
                </div>
            </div>
        </div>
    </div>


    <!-- Consulting 2 -->
    <div class="row box-consulting-homepage justify-content-end">
        <div onClick="linkproduct('<?php echo BASE_URL . "homepage/service?service=" . base64_encode("legal_tax_accounting")?>')" class="col-10 col-lg-8 gold" style="cursor: pointer;">
            <div class="wrapper-consulting">
                <div class="d-flex justify-content-center w-100 order-1 order-lg-0">
                    <a 
                        class="link-consulting textblack "
                    >
                        Law and Tax
                        Optimization
                    </a>
                </div>
                <img class="order-0 order-lg-1" src="<?= BASE_URL ?>assets/img/img-39.webp" alt="img-2">
            </div>
        </div>
    </div>

    <!-- Consulting 3 -->
    <div class="row box-consulting-homepage">
        <div onClick="linkproduct('<?php echo BASE_URL . "homepage/service?service=" . base64_encode("international_expansion_management")?>')" class="col-10 col-lg-8 black" style="cursor: pointer;">
            <div class="wrapper-consulting">
                <img src="<?= BASE_URL ?>assets/img/img-2.webp" alt="img-2">
                <div class="d-flex justify-content-center w-100">
                    <a 
                        class="link-consulting "
                    >
                        Capital Reallocation
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Consulting 4 -->
    <!-- <div class="row box-consulting-homepage justify-content-end">
        <div class="col-10 col-lg-8 gold">
            <div class="wrapper-consulting">
                <div class="d-flex justify-content-center w-100 order-1 order-lg-0">
                    <a 
                        href="<?php echo BASE_URL . "homepage/service?service=" . base64_encode("legal_tax_accounting")?>" 
                        class="link-consulting textblack "
                    >
                        Legal and Tax <br>
                        Advise
                    </a>
                </div>
                <img class="order-0 order-lg-1" src="<?= BASE_URL ?>assets/img/img-4.webp" alt="img-2">
            </div>
        </div>
    </div> -->
</section>
<!-- End of Cosulting -->
     

<!-- Start of Why -->
<section class="content why-homepage">
    <div class="container">
        <div class="row">
            <div class="col-12 col-lg-6 why-left">
                <div class="wrapper-why-logo">
                    <img id="g-logo-why-homepage" class="line-animation" src="<?= BASE_URL ?>assets/img/logo.png" alt="logo PNGLOBAL">
                    <h2 id="g-title-why-homepage" class=" line-animation">
                        Why Choose <br><span translate="no"> PN Global </span>
                    </h2>
                </div>
                <img class="img-competen" src="<?= BASE_URL ?>assets/img/img-25.webp" alt="img-25">
            </div>
            <div class="col-12 col-lg-6 why-right px-4">
                <div class="wrapper-content-why first">
                    <h3 id="g-why-sub-innovation" class="subtitle-why">
                        <span class="line-animation">
                            INNOVATION
                        </span>
                    </h3>
                    <p id="g-why-content-innovation" class=" content-why">
                        <span class="line-animation">
                           <span translate='no'> PN Global </span> is at the forefront on the international scene, its ability to quickly adapt to market changes allows us to constantly offer the best investment and business opportunities.
                        </span>
                    </p>
                </div>
                <div class="wrapper-content-why">
                    <h3 id="g-why-sub-reliability" class=" line-animation subtitle-why">
                        <span class="line-animation">
                            RELIABILITY
                        </span>
                    </h3>
                    <p id="g-why-content-reliability" class=" content-why">
                        <span class="line-animation">
                           <span translate='no'> PN Global </span> is committed to maintaining the highest standards of integrity and transparency in all its activities to repay the trust placed by its clients. You can count on <span translate='no'> PN Global </span> for precise financial consulting and constant support.
                        </span>
                    </p>
                </div>
                <div class="wrapper-content-why">
                    <h3 id="g-why-sub-competence" class=" line-animation subtitle-why">
                        <span class="line-animation">
                            PROFICIENCY
                        </span>
                    </h3>
                    <p id="g-why-content-competence" class=" content-why">
                        <span class="line-animation">
                            The team is made up of professionals located in various jurisdictions; thanks to their wide experience and knowledge acquired in the legal, financial and technological fields they can support their clients in all their needs.
                            <br>
                            The skills of <span translate='no'> PN Global </span> consultants ensure that every decision is based on in-depth analysis and proven strategies, guaranteeing success.
                        </span>
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End of Why -->

<!-- Start of Service -->

<section class="service-homepage">

    <div id="training" class="bg-hot-deal">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h1 class="text-center my-5 text-white  text-uppercase fw-bold">
                        take charge of the future by investing in yourself
                    </h1>
                </div>
            </div>
            <div class="row row-cols-1 row-cols-lg-2 justify-content-center">
                <div class="col my-4">
                    <div class="zoom-box zoom-1">
                        <div class="with-blur-backdrop">
                            <a 
                                href="<?php echo BASE_URL . "homepage/service?service=" . base64_encode("professional_enterpreneurial_training")?>" 
                                class="btn-zoom fw-bold"
                            >
                                free online basic training program 
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col my-4">
                    <div class="zoom-box zoom-2">
                        <div class="with-blur-backdrop">
                            <a 
                                href="<?= BASE_URL ?>homepage/comingsoon" 
                                class="btn-zoom fw-bold"
                            >
                                CAMPUS FOR ADVANCED TRAINING    
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div id="service" class="wrapper-big-title mt-4">
        <h1 class="text-uppercase fw-bold">
            Complementary services offered by our partners
        </h1>
    </div>

    <div class="bg-desc-service">
        <div class="container">
            <div class="row">
                <div class="d-none d-lg-block col-1"></div>
                <div class="col-12 col-lg-5 order-1 order-lg-0">
                    <p class="text-desc-service f-noto">
                        The services offered by our partners allow you to overcome the complexities of international business.  Our team of experts, in collaboration with our partners, will provide you with tailored solutions for a wide range of needs, ensuring compliance and strategic success.  Find out how we can support you every step of the way.
                    </p>
                    <br><br><br><br>
                </div>
                <div class="d-none d-lg-block col-1"></div>
                <div class="col-12 col-lg-5 order-0 order-lg-1 bg-img-service-desc">
                    
                </div>
            </div>
        </div>
    </div>

    <div class="bg-complementary-service">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h2 class="text-center my-5 text-white ">
                        Complementary Services
                    </h2>
                </div>
            </div>
            <div class="row py-4 mb-4 row-cols-1 row-cols-md-2 row-cols-lg-3">
                <div class="col my-3">
                    <div class="flip-box">
                        <div class="flip-box-inner">
                            <div class="flip-box-front flip-1">
                                <p>.</p>
                                <img class="img-fluid" src="<?= BASE_URL?>assets/img/partner/cayman-logo.webp" alt="cayman logo">
                                <div class="btn-flip ">Investment Encrypted bank account</div>
                            </div>
                            <div class="flip-box-back">
                                <div>
                                    <p class=""> 
                                       <span translate='no'> Cayman Financial Group </span> is a financial group based in the Cayman Islands that offers high-profit, zero-risk financial investment plans, as well as encrypted bearer current accounts.  Thanks to the collaboration with PN Global, <span translate='no'> Cayman Financial Group </span> can offer an Edge Fund on BTC Mining with guaranteed interest.
                                        The management of the funds of the financial group and its customers is carried out on the markets by PN Global brokers.
                                    </p>
                                </div>
                                <a target="_blank" class="btn-flip  px-3 py-1" href="https://caymanfinancialgroup.ky/">See More</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col my-3">
                    <div class="flip-box">
                        <div class="flip-box-inner">
                            <div class="flip-box-front flip-2">
                                <p>.</p>
                                <img class="img-fluid" src="<?= BASE_URL?>assets/img/partner/mif-logo.png" alt="MIF logo">
                                <div class="btn-flip " style="padding: 0.3rem 1.5rem;">BITCOIN MINING AND TECHNOLOGY <br> SERVICES</div>
                            </div>
                            <div class="flip-box-back">
                                <div>
                                    <p class="">
                                       <span translate='no'> Money Industrial Factory </span> is a leading company in mining farm construction and cryptocurrency mining. Thanks to the collaboration with the <span translate='no'> PN Global team, Money industrial factorty </span> has managed to transform Cryptocurrency Mining into a zero-risk financial instrument, approved and proposed by the <span translate='no'> Cayman Financial Group</span>.
                                        Through the research and development department, <span translate='no'> Money Industrial Factory </span> provides technical support and innovative technological solutions to its customers.
                                    </p>
                                </div>
                                <a target="_blank" class="btn-flip  px-3 py-1" href="https://moneyindustrialfactory.io/">See More</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col my-3">
                    <div class="flip-box">
                        <div class="flip-box-inner">
                            <div class="flip-box-front flip-3">
                                <p>.</p>
                                <img class="img-fluid" src="<?= BASE_URL?>assets/img/partner/logo-pbs.png" alt="PBS logo">
                                <div class="btn-flip " style="padding: 0.3rem 1.5rem;">Company Formation Services <br> and International Support</div>
                            </div>
                            <div class="flip-box-back">
                                <div>
                                    <p class="">
                                       <span translate='no'> PBS Online </span> specializes in providing comprehensive support services to overcome the complexities of opening or relocating a business abroad. We provide legal and tax support, our team of experts will support you, after a careful feasibility study, in setting up the company and opening bank accounts. We also offer visa and residence permit services.    
                                    </p>
                                </div>
                                <a class="btn-flip  px-3 py-1" href="https://www.pbsonlinellc.com/" target="_blank">See More</a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- <div class="col my-3">
                    <div class="flip-box">
                        <div class="flip-box-inner">
                            <div class="flip-box-front flip-4">
                                <div class="btn-flip ">BUSINESS PLAN AND FEASIBILITY STUDY</div>
                            </div>
                            <div class="flip-box-back">
                                <div>
                                    <h4 class="">Business Plan and Feasibility Study</h4>
                                    <p class="">We deliver specialized services for developing business plans and conducting feasibility studies. Our services include thorough market analysis, financial forecasting, and strategic planning to ensure your business idea is viable and set for success.</p>
                                </div>
                                <a href="<?= BASE_URL ?>homepage/contactform?service=<?= base64_encode("Business Plan and Feasibility Study - Four")?>">Contact us</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col my-3">
                    <div class="flip-box">
                        <div class="flip-box-inner">
                            <div class="flip-box-front flip-5">
                                <div class="btn-flip ">CONTRACT DRAFTING</div>
                            </div>
                            <div class="flip-box-back">
                                <div>
                                    <h4 class="">Contract Drafting</h4>
                                    <p class="">Our legal experts offer professional services in drafting contracts that protect your interests and ensure compliance with all relevant laws. We provide clear, precise, and legally sound contract drafting services to meet your business needs.</p>
                                </div>
                                <a href="<?= BASE_URL ?>homepage/contactform?service=<?= base64_encode("Contract Drafting - Five")?>">Contact us</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col my-3">
                    <div class="flip-box">
                        <div class="flip-box-inner">
                            <div class="flip-box-front flip-6">
                                <div class="btn-flip ">FUNDS REALLOCATION</div>
                            </div>
                            <div class="flip-box-back">
                                <div>
                                    <h4 class="">Fund Reallocation</h4>
                                    <p class="">Maximize profits and minimize risks with our expert services for fund reallocation. We provide 100% legal solutions tailored to enhance profitability and capitalize on market opportunities. Our strategies are designed to meet your specific needs and goals.</p>
                                </div>
                                <a href="<?= BASE_URL ?>homepage/contactform?service=<?= base64_encode("Fund Reallocation - Six")?>">Contact us</a>
                            </div>
                        </div>
                    </div>
                </div> -->
            </div>
        </div>
    </div>


</section>
<!-- End of Service -->