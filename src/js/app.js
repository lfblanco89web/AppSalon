//DEFINICION de Variables
let paso = 1;
const pasoInicial = 1;
const pasoFinal = 3;

//DEFINICION de Objetos
const cita = {

    NOMBRE: '',
    FECHA: '',
    HORA: '',
    SERVICIOS: []

}

//INICIO del Proyecto
document.addEventListener('DOMContentLoaded', function () {

    iniciarApp();

});

//FUNCION iniciarApp
function iniciarApp() {

    //FUNCION MOSTRAR SECCION -- Muestra la sección activa inicialmente
    mostrarSeccion();

    //FUNCION TABS -- Cambia de sección cuando se aprietan los botones tabs
    tabs();

    //FUNCION PAGINADOR -- Lee la posición del paginador
    botonesPaginador();
    botonAnterior();
    botonSigiente();

    //FUNCION CITA
    nombreCliente(); // Guarda el nombre del cliente en el objeto cita
    seleccionaFecha(); //Guarda la fecha en el objeto cita
    seleccionaHora(); //Guarda la hora en el objeto cita

    mostrarResumen(); //Muestra el objeto cita

    //API
    consultarAPI(); /*Consulta la API en el BackEnd*/

}


/*FUNCION TABS*/
function tabs() {

    //Arreglo de botones que contienen las clases y etiquetas
    const botones = document.querySelectorAll('.tabs button'); //Selecciono la clase tabs y la etiqueta button

    //Itero sobre los botones
    botones.forEach(boton => {

        //Registro cada evento al hacer click sobre cada boton individual
        boton.addEventListener('click', function (e) {

            //ASIGNAR Valores a Variables
            paso = parseInt(e.target.dataset.paso);

            //LLAMAR a la Función
            mostrarSeccion();
            botonesPaginador();

        });

    });

}

/*FUNCION MOSTRAR SECCION*/
function mostrarSeccion() {

    //OCULTAR las secciones que tengan la clase mostrar
    const seccionAnterior = document.querySelector('.mostrar');

    if (seccionAnterior) {

        seccionAnterior.classList.remove('mostrar');

    }

    //SELECCIONAR la sección con el paso
    const pasoSelector = `#paso-${paso}`;
    const seccion = document.querySelector(pasoSelector);

    //AGREGAR Clase Mostrar
    seccion.classList.add('mostrar');

    //QUITAR la clase actual sobre el Tab activo
    const tabAnterior = document.querySelector('.actual');
    if (tabAnterior) {

        tabAnterior.classList.remove('actual');

    }

    //RESALTAR el Tab activo
    const tab = document.querySelector(`[data-paso="${paso}"]`);

    tab.classList.add('actual');

}

/*FUNCION PAGINADOR*/
function botonesPaginador() {

    //DEFINIR Variables de los Botones
    const paginaAnterior = document.querySelector('#anterior');
    const paginaSiguiente = document.querySelector('#siguiente');

    if (paso === 1) {

        paginaAnterior.classList.add('ocultar');
        paginaSiguiente.classList.remove('ocultar');

    } else if (paso === 3) {

        paginaAnterior.classList.remove('ocultar');
        paginaSiguiente.classList.add('ocultar');
        mostrarResumen();

    } else {

        paginaAnterior.classList.remove('ocultar');
        paginaSiguiente.classList.remove('ocultar');

    }


}

/*FUNCION ANTERIOR*/
function botonAnterior() {

    //DEFINIR el Boton
    const paginaAnterior = document.querySelector('#anterior');

    //ACCIONAR Función cuando se hace click
    paginaAnterior.addEventListener('click', function () {

        if (paso <= pasoInicial) {

            return;

        } else {

            paso--;
            botonesPaginador();
            mostrarSeccion();

        }

    })

}

/*FUNCION SIGUIENTE*/
function botonSigiente() {

    const paginaSiguiente = document.querySelector('#siguiente');

    //ACCIONAR Función cuando se hace click
    paginaSiguiente.addEventListener('click', function () {

        if (paso >= pasoFinal) {

            return;

        } else {

            paso++;
            botonesPaginador();
            mostrarSeccion();

        }

    })

}

/*FUNCION MOSTRAR ALERTA*/
function mostrarAlerta(tipo, mensaje, elemento, desaparece = true) {

    //REVISO si hay Alertas Activas
    const alertaPrevia = document.querySelector('.alerta');
    if (alertaPrevia) {

        alertaPrevia.remove();

    };

    //CREAR Contenedor Alerta
    const alerta = document.createElement('DIV');

    //GENERO valores del contenedor
    alerta.textContent = mensaje;
    alerta.classList.add('alerta');
    alerta.classList.add(tipo);

    //IMPRIMIR Alertas en Formulario
    const referencia = document.querySelector(elemento);
    referencia.appendChild(alerta);

    if (desaparece) {

        //ELIMINAR Impresión
        setTimeout(() => {

            alerta.remove();

        }, 3000); /*Se elimina la alerta en 3seg = 3000ms*/

    }

}

//FUNCION CITA
/*FUNCION NOMBRE Cita*/
function nombreCliente() {

    //ASIGNAR el nombre del Cliente a la Cita
    cita.NOMBRE = document.querySelector('#NOMBRE').value;

}

/*FUNCION FECHA Cita*/
function seleccionaFecha() {

    //SELECCIONAR la Fecha del campo del formulario
    const inputFecha = document.querySelector('#FECHA');

    inputFecha.addEventListener('input', function (e) {

        //ASIGNAR Dia
        const dia = new Date(e.target.value).getUTCDay();

        if ([0, 6].includes(dia)) {/* Si Sabado o Domingo está inculida en la variable día */

            //SETEAR Fecha en Null
            e.target.value = '';

            //MOSTRAR Alerta
            mostrarAlerta('error', 'No se toman Citas en fines de semana', '.formulario');

        } else {

            cita.FECHA = e.target.value; /*Se registra la fecha*/

        }

    });

}

/*FUNCION HORA Cita*/
function seleccionaHora() {

    const inputHora = document.querySelector('#HORA');

    inputHora.addEventListener('input', function (e) {

        const horaCita = e.target.value;
        const hora = horaCita.split(":")[0];

        if (hora < 10 || hora > 18) { /*LOCAL CERRADO*/

            //SETEAR Fecha en Null
            e.target.value = '';

            //MOSTRAR Alerta
            mostrarAlerta('error', 'Las reservas se pueden tomar entre las 10:00 y las 18:00 horas', '.formulario');

        } else {

            cita.HORA = e.target.value; //Se registra la hora

        }

    })

}

//FUNCIONES API
//FUNCION ASYNCRONA Consultar API
async function consultarAPI() {

    try {

        //Fuente de los Servicios
        const url = 'http://localhost:3000/api/servicios';

        //Recuperación de Datos
        const resultado = await fetch(url); /* Las funciones que estan debajo se ejecutan una vez recuperados todos los datos */

        //Recuperación de Servicios JSON
        const servicios = await resultado.json();

        //FUNCION Mostrar Servicios
        mostrarServicios(servicios);

    } catch (error) {

        console.log(error);

    }

}

//FUNCION Mostrar Servicios
function mostrarServicios(servicios) {

    //Itero sobre el arreglo de Servicios
    servicios.forEach(servicio => {

        //Creo los objetos servicio
        const { ID, NOMBRE, PRECIO } = servicio;

        //Creo los atributos del objeto
        const nombreServicio = document.createElement('P'); /*P = <p>*/
        nombreServicio.classList.add('nombre-servicio');
        nombreServicio.textContent = NOMBRE;

        const precioServicio = document.createElement('P');
        precioServicio.classList.add('precio-servicio');
        precioServicio.textContent = `$${PRECIO}`; /*${ variable } Inyecta la Variable*/

        //Creo el Contenedor de los objetos
        const servicioDiv = document.createElement('DIV'); /*DIV = <div>*/
        servicioDiv.classList.add('servicio');
        servicioDiv.dataset.idServicio = ID;
        servicioDiv.onclick = function () { /*Llamo a la FUNCION Seleccionar Servicios al hacer CLICK*/

            seleccionarServicio(servicio);

        };

        servicioDiv.appendChild(nombreServicio);
        servicioDiv.appendChild(precioServicio);

        //Busco el contenedor de servicios en el DIV del index
        document.querySelector('#servicios').appendChild(servicioDiv);

    });

}

//FUNCION Seleccionar Servicios
function seleccionarServicio(servicio) {

    //Extraigo los datos del Arreglo SERVICIOS del objeto CITA
    const { ID } = servicio;
    const { SERVICIOS } = cita;

    //SELECCIONAR la clase sobre la que hago click
    const divServicio = document.querySelector(`[data-id-servicio="${ID}"]`);

    //VALIDACION sobre si un servicio existe en el arreglo del objeto CITA y concuerda con el SERVICIO que estoy clickeando
    if (SERVICIOS.some(agregado => agregado.ID === ID)) {

        //ELIMINAR
        cita.SERVICIOS = SERVICIOS.filter(agregado => agregado.ID !== ID);/* ELIMINO el servicio que COINCIDE con el ID */
        divServicio.classList.remove('seleccionado');

    } else {

        //AGREGAR
        cita.SERVICIOS = [...SERVICIOS, servicio]; /*...SERVICIOS => SERVICIOS extraidos*/
        divServicio.classList.add('seleccionado');

    }

}

//FUNCION Mostrar Cita
function mostrarResumen() {

    const resumen = document.querySelector('.contenido-resumen');

    //Limpiar el contenido de resumen
    while (resumen.firstChild) {

        resumen.removeChild(resumen.firstChild);

    }

    if (Object.values(cita).includes('') || cita.SERVICIOS.lenght === 0) {

        mostrarAlerta('error', 'Faltan datos de Servicios, Fecha u Hora', '.contenido-resumen', false);
        return;
    }

    //FORMATEAR el DIV de Resumen
    const { NOMBRE, FECHA, HORA, SERVICIOS } = cita; //EXTRAER los datos del objeto cita

    //HEADING para Resumen de Servicios
    const headingServicios = document.createElement('H3');
    headingServicios.textContent = 'Resumen de Servicios';
    resumen.appendChild(headingServicios);

    //FORMATEAR Fecha en Español
    const fechaObj = new Date(FECHA);
    const mes = fechaObj.getMonth();
    const dia = fechaObj.getDate() + 2;
    const ano = fechaObj.getFullYear();

    const fechaUTC = new Date(Date.UTC(ano, mes, dia));

    const opciones = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
    const fechaFormato = fechaUTC.toLocaleDateString('es-AR', opciones);

    //ITERAR sobre los servicios seleccionados
    SERVICIOS.forEach(servicio => {

        const { ID, PRECIO, NOMBRE } = servicio;

        const contenedorServicio = document.createElement('DIV');
        contenedorServicio.classList.add('contenedor-servicio');

        const textoServicio = document.createElement('P');
        textoServicio.textContent = NOMBRE;

        const precioServicio = document.createElement('P');
        precioServicio.innerHTML = `<span>Precio: </span> $${PRECIO}`;

        contenedorServicio.appendChild(textoServicio);
        contenedorServicio.appendChild(precioServicio);

        resumen.appendChild(contenedorServicio);

    });

    //HEADING para Resumen de Citas
    const headingCita = document.createElement('H3');
    headingCita.textContent = 'Resumen de Cita';
    resumen.appendChild(headingCita);


    //DEFINO DATOS DEL CLIENTE
    const nombreCliente = document.createElement('P');
    nombreCliente.innerHTML = `<span>Nombre: </span>${NOMBRE}`;

    const fechaCita = document.createElement('P');
    fechaCita.innerHTML = `<span>Fecha: </span>${fechaFormato}`;

    const horaCita = document.createElement('P');
    horaCita.innerHTML = `<span>Hora: </span>${HORA} horas`;

    //BOTON para RESERVAR Cita
    const botonReservar = document.createElement('BUTTON');
    botonReservar.classList.add('boton');
    botonReservar.textContent = 'Reservar Cita';
    botonReservar.onclick = ReservarCita;

    resumen.appendChild(nombreCliente);
    resumen.appendChild(fechaCita);
    resumen.appendChild(horaCita);
    resumen.appendChild(botonReservar);

}

//FUNCION para MANDAR los DATOS al SERVIDO
async function ReservarCita() {

    const { NOMBRE, FECHA, HORA, SERVICIOS } = cita;

    const idServicios = SERVICIOS.map(servicio => servicio.ID);

    const Datos = new FormData();
    Datos.append('NOMBRE', NOMBRE);
    Datos.append('FECHA', FECHA);
    Datos.append('HORA', HORA);
    Datos.append('SERVICIOS', idServicios);

    //PUNTO CRITICO
    try {

        //PETICION a la API
        const url = `/api/citas`;

        const respuesta = await fetch(url, {
            method: 'POST',
            body: Datos
        });

        const resultado = await respuesta.json();

        

        if (resultado['@_status'] !== 'error') {

            Swal.fire({

                icon: 'success',
                title: 'Éxito',
                text: 'Tu cita fue creada correctamente',

            }).then(() => { //Despues de ejecutar la alerta

                window.location.reload(); //Recarga la página

            })

        }

    } catch (error) {

        Swal.fire({

            icon: 'error',
            title: 'Error',
            text: 'Hubo un error al guardar la cita',

        })

    }




}
