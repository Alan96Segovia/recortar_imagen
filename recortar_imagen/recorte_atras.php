 <!DOCTYPE html>
  <html lang="en">

  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/cropper.css">
    <link rel="stylesheet" href="css/index.css">
    <title>Recortar Imagen</title>
    <style>
      button.btn.descarga {
        display: inline-block;
        font-size: 16px;
        font-weight: bold;
        text-align: center;
        text-decoration: none;
        padding: 10px 20px;
        border-radius: 4px;
        cursor: pointer;
        transition: background-color 0.3s ease;
        background-color: #007bff;
        color: #fff;
        border: none;
      }

      button.btn.descarga:hover {
        background-color: #0056b3;
      }

      .alert {
        padding: 15px;
        border-radius: 4px;
        margin-bottom: 20px;
        border: 1px solid transparent;
        text-align: center;
      }

      .alert-success {
        color: #155724;
        background-color: #d4edda;
        border-color: #c3e6cb;
      }

      .alert-warning {
        color: #856404;
        background-color: #fff3cd;
        border-color: #ffeeba;
      }
    </style>
  </head>

  <body>
  <?php
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recibir el archivo Blob del formulario

    // Dirección donde se guardará la imagen recortada
    $targetDir = "imagenes_atras/";
    $currentDateTime = date('Y-m-d_H-i-s');
    $targetFile = $targetDir . $currentDateTime = date('Y-m-d_H-i-s') . basename($_FILES["image_data"]["name"]);

    if (move_uploaded_file($_FILES["image_data"]["tmp_name"], $targetFile)) {
      echo "<div class='alert alert-success'>La imagen se ha guardado correctamente.</div>";
    } else {
      echo "<div class='alert alert-warning'>Hubo un error al subir la imagen.</div>";
    }
  }

  ?>
    <h1>Imagen De Atras</h1>
    <div class="container">
      <div class="group">
        <form id="upload-form" method="post" action="recorte_atras.php" enctype="multipart/form-data" onsubmit="return validateForm()">
          <img class="crop-image" id="generatedImage" src="" alt="Aqui visualizara la Imagen Recortada">
          <label for="input-file" class="label-file">Seleccionar Imagen</label>
          <input type="file" name="image_data" id="input-file" accept="image/*">
          <button type="submit" class="btn descarga">Guardar imagen recortada</button>
        </form>
      </div>
    </div>

    <div class="modal">
      <div class="modal-content">
        <div class="modal-header">Recortar Imagen</div>
        <div class="modal-body">
          <div class="content-imagen-cropper">
            <img class="img-cropper" src="" alt="Cropped Image">
          </div>
          <div class="content-imagen-sample">
            <img class="img-sample" src="" alt="Sample Image">
          </div>
        </div>
        <div class="modal-footer">
          <button class="btn primary">Guardar</button>
          <button class="btn secundary">Cancelar</button>
        </div>
      </div>
    </div>

    <script src="js/jquery.js"></script>
    <script src="js/cropper.js"></script>
    <script>
         //valida que no pueda enviar vacio el input de file 
      function validateForm() {
        var fileInput = document.getElementById("input-file");
        if (fileInput.files.length === 0) {
          alert("Debes seleccionar un archivo de imagen.");
          return false;
        }
        return true;
      }


      const inputFile = document.getElementById('input-file');
      const cropImage = document.querySelector('.crop-image');
      const imgCropper = document.querySelector('.img-cropper');
      const imgSample = document.querySelector('.img-sample');
      const modal = document.querySelector('.modal');
      const modalContent = document.querySelector('.modal-content');
      const saveBtn = document.querySelector('.modal-footer .primary');
      const cancelBtn = document.querySelector('.modal-footer .secundary');

      let cropper;

      inputFile.addEventListener('change', (event) => {
        const file = event.target.files[0];
        const imageUrl = URL.createObjectURL(file);
        cropImage.src = imageUrl;
        imgCropper.src = imageUrl;
        imgSample.src = imageUrl;
        modal.classList.add('active');
        modalContent.classList.add('active');

        cropper = new Cropper(imgCropper, {
          aspectRatio: 16 / 9,
          guides: true,
          autoCropArea: 0.8,
          movable: true,
          zoomable: true,
          rotatable: true,
          cropBoxMovable: true,
          cropBoxResizable: true
        });
      });
      ///en esta parte guardo envio la imagen para guardar la imafen recortada
      saveBtn.addEventListener('click', () => {
        const croppedCanvas = cropper.getCroppedCanvas();
        // Convertir el canvas a un formato de imagen
        const imageData = croppedCanvas.toDataURL('image/jpeg'); // Puedes cambiar 'image/jpeg' por 'image/png' o 'image/gif'

        croppedCanvas.toBlob((blob) => {
          // Crear un objeto File con la imagen recortada
          const croppedFile = new File([blob], 'imagen_atras.jpg', {
            type: 'image/jpeg'
          });



          // Aquí puedes guardar el archivo en el servidor o hacer lo que necesites
          // Crear un objeto URL para la imagen
          const imageUrl = URL.createObjectURL(croppedFile);
          // Establecer el atributo 'src' de la imagen
          const generatedImage = document.getElementById('generatedImage');
          generatedImage.src = imageUrl;
          //console.log(croppedFile);
          const imageSource = generatedImage.src;
          console.log('la imagen src :' + imageSource);

          // Crear una nueva instancia de FileList y asignar el croppedFile
          const fileList = new DataTransfer();
          fileList.items.add(croppedFile);
          const inputFile = document.getElementById('input-file');
          inputFile.files = fileList.files;


          modal.classList.remove('active');
          modalContent.classList.remove('active');
          cropper.destroy();
        });
      });

      cancelBtn.addEventListener('click', () => {
        modal.classList.remove('active');
        modalContent.classList.remove('active');
        cropper.destroy();
      });
    </script>
  </body>

  </html>