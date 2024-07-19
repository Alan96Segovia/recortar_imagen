let cropper = null;

$('#input-file').on('change',() => {
    //alert('hola');
    //imagen donde voy a cargar mi imagen
    let image = document.getElementById('img-cropper');
    //capturo el input que selecciona la foto
    let input = document.getElementById('input-file');


    //guardo en una variable los archivos seleccionados 
    let archivos =  input.files //de esta manera accedo al archivo

    //hago que los archivos seleccionado solo sean de tipo imagen y no de pdf 
    let extensiones = input.value.substring(input.value.lastIndexOf('.'), input.value.lenght) // de esta manera capturo la extension ejemplo = .jpg o .pdf

    if(!archivos || !archivos.lenght ){
        //no selecciono ningun archivo
        image.src = "";
        input.value = "";
    }else if(input.getAttribute('accept').split(',').indexOf(extensiones) < 0  ){  //verificamos si selecciono una imagen
        // no es una imagen
        alert('Debe Seleccionar Una Imagen');
        input.value = ""; // de esta manera limpiamos nuestro input
    }else{
        //si selecciono imagen
            //creamos una url
            let imagenUrl = URL.createObjectURL(archivos[0]) 
            image.src = imagenUrl


            //recortamos la imagen con cropper js
            cropper = new Cropper(image, {
                aspecRatio:1,//configurar el recorte
                preview:'img-sample',//donde se va visualizar la imagen cortada
                zoomable:false,//para no realizar zoom
                viewMode:1,//para que no estire la imagen al contenedor
                responsive:false,//para que no reacomode la imagen
                dragMode:'none',//para que no arrastre nada
                ready(){ //configuramos el alto y ancho del contendor
                        //la clase cropper-container es propio de la libreia
                    document.querySelector('.cropper-container').computedStyleMap.width = '100%'
                    document.querySelector('.cropper-container').computedStyleMap.height = '100%'
                }

            })
            $('.modal').addClass('active')
            $('.modal-content').addClass('active')

            $('.modal').removeClass('remove')
            $('.modal-content').removeClass('remove')
    }
})