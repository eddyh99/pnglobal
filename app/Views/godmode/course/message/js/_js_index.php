<script>
    // Tab functionality
    $(document).ready(function() {
        console.log("Document ready, initializing tabs");

        // Default active tab
        const urlParams = new URLSearchParams(window.location.search);
        let activeTab = urlParams.get('tab') || localStorage.getItem('activeTabMsg');
        console.log("Active tab from localStorage:", activeTab);
        
        if (urlParams.get('tab')) {
            localStorage.setItem('activeTabMsg', activeTab);
        }

        // Set active tab on load
        $('.tab-item[data-tab="' + activeTab + '"]').addClass('active').css({
            'background-color': '#BFA573',
            'color': '#000'
        });
        

        $('#' + activeTab).addClass('active').css('display', 'block');

        // Tab click handler
        $('.tab-item').click(function() {
            const tabId = $(this).data('tab');
            console.log("Tab clicked:", tabId);

            // Remove active class and reset styles from all tabs and contents
            $('.tab-item').removeClass('active').css({
                'background-color': '#444',
                'color': '#fff'
            });
            $('.tab-content').removeClass('active').css('display', 'none');

            // Add active class and styles to clicked tab and its content
            $(this).addClass('active').css({
                'background-color': '#BFA573',
                'color': '#000'
            });
            $('#' + tabId).addClass('active').css('display', 'block');

            // Save active tab to localStorage
            localStorage.setItem('activeTabMsg', tabId);
        });
    });
</script>
<style>
  /* Change the border color of the editable area */
  .note-editor .note-editable {
    border: 2px solid #B48B3D; /* Light blue border */
  }

  /* Optional: Add some padding or styling to the editor */
  .note-editor {
    border: 2px solid #B48B3D;
    border-radius: 5px;
  }

  /* Change the background color of the toolbar */
  .note-toolbar {
    background-color: #B48B3D; /* Light grey background */
    border-bottom: 1px solid #ccc;
  }

  /* Optional: Adjust toolbar button styles */
  .note-toolbar .btn {
    border: 1px solid #ddd;
    color: #000;
  }

  /* Optional: Change button hover */
  .note-toolbar .btn:hover {
    background-color: #e0e0e0;
  }
  /* Style the popover container */
    .note-popover {
      background-color: #B48B3D !important;
      border: 1px solid #A0752F !important;
      border-radius: 4px;
    }
    
    /* Style buttons inside the popover */
    .note-popover .popover-content .btn {
      border: 1px solid #ddd;
      color: #000;
    }
    
    /* Hover effect for popover buttons */
    .note-popover .popover-content .btn:hover {
      background-color: #e0e0e0;
    }

/*select2 */
    /* Fix for Select2 selected tags showing vertically */
    .select2-container--bootstrap4 .select2-selection--multiple .select2-selection__rendered {
      display: flex !important;
      flex-wrap: wrap;
      align-items: center;
      gap: 0.25rem;
      padding : 3px;
      text-align: left !important;
    }
    
    /* Fix white text in dropdown list */
    .select2-container--bootstrap4 .select2-results__option {
      color: #000 !important;
      background-color: #fff !important;
    }
    
    /* Optional: highlight selected item */
    .select2-container--bootstrap4 .select2-results__option--highlighted {
      background-color: #B48B3D !important;
      color: #fff !important;
    }
    
    .select2-container--bootstrap4 {
      background-color: #fff !important;
      border: 1px solid #ced4da !important;
    }
    
    /* Style the selected items (tags) */
    .select2-container--bootstrap4 .select2-selection--multiple .select2-selection__choice {
      background-color: #B48B3D !important;
      color: #000 !important;               /* black text */
      border: 1px solid #ced4da !important;
      padding: 0.1rem 0.5rem !important;
      border-radius: 4px;
    }
    
    /* Style the "x" close button on tags */
    .select2-container--bootstrap4 .select2-selection--multiple .select2-selection__choice__remove {
      color: #dc3545 !important;            /* Bootstrap red */
      margin-right: 0.25rem;
      font-weight: bold;
    }
    
    .select2-container--bootstrap4 .select2-selection--multiple .select2-selection__choice__remove:hover {
      color: #bd2130 !important;
    }


  </style>
<script>
    document.addEventListener('DOMContentLoaded', function () {
      $('#editor').summernote({
        height: 400,
        toolbar: [
          ['style', ['bold', 'italic']],
          ['insert', ['btnImage']] // Custom button
        ],
        buttons: {
          btnImage: function (context) {
            var ui = $.summernote.ui;
            var button = ui.button({
              contents: '<i class="note-icon-picture"></i>',
              tooltip: 'Insert Image',
              click: function () {
                $('#summerModal').modal('show');
              }
            });
            return button.render();
          }
        }
      });
    
      // Clear file input when modal is shown
      $('#summerModal').on('shown.bs.modal', function () {
        $('#customImageInput').val('');
      });
    
      // Insert selected image
      $('#insertCustomImage').on('click', function () {
        const fileInput = document.getElementById('customImageInput');
        const file = fileInput.files[0];
        if (file) {
          const reader = new FileReader();
          reader.onload = function (e) {
            $('#editor').summernote('insertImage', e.target.result);
            $('#summerModal').modal('hide');
          };
          reader.readAsDataURL(file);
        }
      });
    });

    $('.subject').on('click', function() {
        $('.subject').removeClass('active');
        $(this).addClass('active');
    });
    
    $('#member').select2({
        theme: 'bootstrap4',
    });
    
    $('.toggle-fav').on('click', function (e) {
        e.stopPropagation();
        const el = $(this);
        const id = el.data('id');
        const status = el.data('status');
        console.log(id);
        $.ajax({
            url: '<?=BASE_URL?>/godmode/course/message/updatestatus', 
            method: 'POST',
            data: { id: id, status: status },
            success: function (res) {
                if (res.success) {
                    location.reload();
                } else {
                    alert(res.message || 'Failed to update.');
                }
            },
            error: function () {
                alert('Server error.');
            }
        });
    });

</script>