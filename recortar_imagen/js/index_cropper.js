// Obtener referencias a los elementos HTML
const inputFile = document.getElementById('input-file');
const cropImage = document.getElementById('crop-image');
const imgCropper = document.getElementById('img-cropper');
const imgCroppered = document.getElementById('img-croppered');
const cutButton = document.getElementById('cut');
const closeButton = document.getElementById('close');
const modal = document.querySelector('.modal');

// Inicializar Cropper.js
let cropper;

// Evento para cargar la imagen
inputFile.addEventListener('change', function(event) {
  const file = event.target.files[0];
  const imageUrl = URL.createObjectURL(file);

  cropImage.src = imageUrl;
  imgCropper.src = imageUrl;

  // Mostrar el modal
  modal.style.display = 'block';

  // Inicializar Cropper.js
  cropper = new Cropper(imgCropper, {
    aspectRatio: 16 / 9, // Relación de aspecto de la imagen recortada
    guides: true, // Mostrar guías de recorte
    autoCropArea: 0.8, // Área inicial de recorte
    movable: true, // Permitir mover la imagen
    zoomable: true, // Permitir acercar/alejar la imagen
    cropBoxMovable: true, // Permitir mover el cuadro de recorte
    cropBoxResizable: true // Permitir redimensionar el cuadro de recorte
  });
});

// Evento para recortar la imagen
cutButton.addEventListener('click', function() {
  // Obtener la imagen recortada
  const croppedCanvas = cropper.getCroppedCanvas();
  const croppedImage = croppedCanvas.toDataURL('image/jpeg'); // Convertir a URL de imagen

  // Actualizar la vista previa de la imagen recortada
  imgCroppered.src = croppedImage;

  // Cerrar el modal
  modal.style.display = 'none';

  // Liberar los recursos de Cropper.js
  cropper.destroy();
});

// Evento para cerrar el modal
closeButton.addEventListener('click', function() {
  // Cerrar el modal
  modal.style.display = 'none';

  // Liberar los recursos de Cropper.js
  cropper.destroy();
});