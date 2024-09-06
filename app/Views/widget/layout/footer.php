    
    	
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
    
    <!-- Telephone Code -->
    <script src="<?= base_url()?>assets/libs/intl-tel-input-master/build/js/intlTelInput.js"></script>
    
    <!-- Custom General Javascript -->
    <script src="<?= base_url() ?>assets/js/script.js"></script>

    <?php
        if (@isset($extra)) {
            echo view(@$extra);
        }
    ?>

</body>
</html>