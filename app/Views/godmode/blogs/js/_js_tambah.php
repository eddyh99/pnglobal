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

  </style>


<script>
    document.addEventListener('DOMContentLoaded', function () {
      $('#content').summernote({
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
            $('#content').summernote('insertImage', e.target.result);
            $('#summerModal').modal('hide');
          };
          reader.readAsDataURL(file);
        }
      });
    });


</script>