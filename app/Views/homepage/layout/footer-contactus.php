    
     <!-- JQUERY -->
     <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
     <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
    
    <!-- Telephone Code -->
    <script src="<?= base_url()?>assets/libs/intl-tel-input-master/build/js/intlTelInput.js"></script>

     <!-- Google tag (gtag.js) -->
     <script async src="https://www.googletagmanager.com/gtag/js?id=G-QG231EBN92"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'G-QG231EBN92');
    </script>
    
    <!-- Custom General Javascript -->
    <script src="<?= base_url()?>assets/js/script.js"></script>

    <?php
        if (@isset($extra)) {
            echo view(@$extra);
        }
    ?>
</body>
</html>