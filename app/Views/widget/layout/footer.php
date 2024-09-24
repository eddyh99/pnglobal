    
    	
				</div>
			</div>
		</div>
	</div>
    <!-- JQUERY -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/foundation/6.4.3/js/foundation.min.js"></script>
    
    <!-- GSAP -->
    <script src="https://cdn.jsdelivr.net/npm/gsap@3.12.5/dist/gsap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/gsap@3.12.5/dist/ScrollTrigger.min.js"></script>
    <script src="https://unpkg.com/split-type"></script>

    <!-- Datatables JS -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    
    <!-- Telephone Code -->
    <script src="<?= BASE_URL?>assets/libs/intl-tel-input-master/build/js/intlTelInput.js"></script>
    
    <!-- Format Price -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/autonumeric/1.8.2/autoNumeric.js"></script>

    <!-- Sweet Alert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <!-- Custom General Javascript -->
    <script src="<?= BASE_URL ?>assets/js/script.js"></script>


    <script>
        $(".price-input").autoNumeric('init', {
            aSep: ',',
            aDec: '.',
            aForm: true,
            vMax: '99999999999',
            vMin: '0'
        });
    </script>

    <?php
        if (@isset($extra)) {
            echo view(@$extra);
        }
    ?>

</body>
</html>