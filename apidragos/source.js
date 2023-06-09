//OBTENER NOMBRE DE LA EMPRESA POR ID DE LA EMPRESA
function obtenerNombreEmpresa(idEmpresa) {
  return new Promise(async (resolve, reject) => {
    try {
      // Obtener el nombre de la empresa desde la API
      let response = await fetch(
        `http://apidragos.com/datos_empresas.php?id=${idEmpresa}`
      );
      let data = await response.json();

      // Obtener el nombre de la empresa
      let nombreEmpresa = data[idEmpresa].nombre; // Ajusta esto según la estructura de la respuesta de la API

      resolve(nombreEmpresa);
    } catch (error) {
      console.error("Error al obtener el nombre de la empresa:", error);
      reject(error);
    }
  });
}
//MOSTRAR DATOS DE CADA ALUMNO EN SU PERFIL
async function mostrarDatosAlumno(idAlumno) {
  try {
    let response = await fetch(
      `http://apidragos.com/datos_alumno.php?id=${idAlumno}`,
      {
        cache: "no-store", // Desactiva la caché del navegador
      }
    );
    let data = await response.json();

    // Obtener el contenedor en el que se mostrarán los datos del alumno
    let contenedor = document.getElementById("datosAlumno");

    // Limpiar el contenedor antes de mostrar los nuevos datos
    document.getElementById("datosAlumno").innerHTML = "";

    // Mostrar los datos del alumno
    let alumno; // Suponiendo que la respuesta devuelve un único alumno

    if (idAlumno === 1) {
      alumno = data[idAlumno];
    } else {
      alumno = data[idAlumno - 1];
    }

    // Crear la card de Bootstrap
    let card = document.createElement("div");
    card.classList.add("card");
    card.classList.add("w-50"); // Ocupa el 50% del ancho

    // Crear el contenido de la card
    let cardBody = document.createElement("div");
    cardBody.classList.add("card-body");

    // Agregar los datos del alumno al contenido de la card
    let nombre = document.createElement("p");
    nombre.classList.add("fw-bold"); // Texto en negrita
    nombre.textContent = `Nombre: ${alumno.nombre}`;
    cardBody.appendChild(nombre);

    let apellidos = document.createElement("p");
    apellidos.classList.add("fw-bold"); // Texto en negrita
    apellidos.textContent = `Apellidos: ${alumno.apellidos}`;
    cardBody.appendChild(apellidos);

    let dni = document.createElement("p");
    dni.classList.add("fw-bold"); // Texto en negrita
    dni.textContent = `DNI: ${alumno.dni}`;
    cardBody.appendChild(dni);

    let direccion = document.createElement("p");
    direccion.classList.add("fw-bold"); // Texto en negrita
    direccion.textContent = `Dirección: ${alumno.direccion}`;
    cardBody.appendChild(direccion);

    let fechaNacimiento = document.createElement("p");
    fechaNacimiento.classList.add("fw-bold"); // Texto en negrita
    fechaNacimiento.textContent = `Fecha de Nacimiento: ${alumno.fecha_nac}`;
    cardBody.appendChild(fechaNacimiento);

    let email = document.createElement("p");
    email.classList.add("fw-bold"); // Texto en negrita
    email.textContent = `Email: ${alumno.email}`;
    cardBody.appendChild(email);

    let telefono = document.createElement("p");
    telefono.classList.add("fw-bold"); // Texto en negrita
    telefono.textContent = `Teléfono: ${alumno.telefono}`;
    cardBody.appendChild(telefono);

    // Agregar el contenido a la card
    card.appendChild(cardBody);

    // Agregar la card al contenedor
    contenedor.appendChild(card);
    idAlumno = null;
  } catch (error) {
    console.error("Error al obtener los datos del alumno:", error);
  }
}
//MOSTRAR CANDIDATURAS DE CADA ALUMNO EN SU PERFIL
async function mostrarCandidaturasAlumno(idAlumno) {
  try {
    // Obtener las candidaturas del alumno desde la API
    let response = await fetch(
      `http://apidragos.com/datos_candi_alumno.php?id_alumno=${idAlumno}`
    );
    let data = await response.json();

    // Obtener el contenedor en el que se mostrarán las candidaturas
    let contenedor = document.getElementById("candidaturasAlumno");

    // Limpiar el contenedor antes de mostrar las nuevas candidaturas
    contenedor.innerHTML = "";

    let candidaturas = data.filter(
      (candidatura) => candidatura.id_alumno === idAlumno
    );

    // Verificar si el alumno tiene candidaturas
    if (candidaturas.length === 0) {
      // Mostrar mensaje de que no hay candidaturas
      let mensaje = document.createElement("p");
      mensaje.textContent = "No tienes candidaturas.";
      contenedor.appendChild(mensaje);
    } else {
      // Recorrer las candidaturas y mostrar los datos
      candidaturas.forEach(async (candidatura) => {
        // Obtener el nombre de la empresa asociada a la candidatura
        let nombreEmpresa = await obtenerNombreEmpresa(candidatura.id_empresa);

        // Crear una card para mostrar la candidatura
        let card = document.createElement("div");
        card.classList.add("card", "mb-3");
        card.classList.add("w-50"); // Ocupa el 50% del ancho

        // Crear el contenido de la card
        let cardBody = document.createElement("div");
        cardBody.classList.add("card-body");

        // Mostrar el ID de la candidatura
        let idElemento = document.createElement("h5");
        idElemento.classList.add("card-title");
        idElemento.textContent = `Candidatura: ID ${candidatura.id_candidatura}`;
        cardBody.appendChild(idElemento);

        // Mostrar el nombre de la empresa
        let empresaElemento = document.createElement("p");
        empresaElemento.classList.add("card-text");
        empresaElemento.textContent = `Empresa: ${nombreEmpresa}`;
        cardBody.appendChild(empresaElemento);

        // Mostrar el estado de aprobación
        let aprobadoElemento = document.createElement("p");
        aprobadoElemento.classList.add("card-text");

        if (candidatura.aprobado == 1) {
          aprobadoElemento.textContent = `Estado: Aprobado  `;
        } else {
          aprobadoElemento.textContent = `Estado: Denegado  `;
        }
        cardBody.appendChild(aprobadoElemento);

        // Agregar el cuerpo de la card a la card
        card.appendChild(cardBody);

        // Agregar la card al contenedor
        contenedor.appendChild(card);
      });
    }
  } catch (error) {
    console.error("Error al obtener las candidaturas del alumno:", error);
  }
}


async function mostrarCandidaturas(alumnoId) {
  try {
    // Obtener las candidaturas del alumno desde la API
    let response = await fetch(
      `http://apidragos.com/datos_candi_alumno.php?id_alumno=${alumnoId}`,
      {
        cache: "no-store", // Desactiva la caché del navegador
      }
      );
      let data = await response.json();
      
      // Obtener el contenedor en el que se mostrarán las candidaturas
      let contenedor = document.getElementById("candidaturasAlumno");
      
      // Limpiar el contenedor antes de mostrar las nuevas candidaturas
      contenedor.innerHTML = "";
      
      let candidaturas = data.filter(
        (candidatura) => candidatura.id_alumno === alumnoId
        );
        
    // Verificar si el alumno tiene candidaturas
    if (candidaturas.length === 0) {
      // Mostrar mensaje de que no hay candidaturas
      let mensaje = document.createElement("p");
      mensaje.textContent = "No tienes candidaturas.";
      contenedor.appendChild(mensaje);
    } else {
      // Recorrer las candidaturas y mostrar los datos
      candidaturas.forEach(async (candidatura) => {
        // Obtener el nombre de la empresa asociada a la candidatura
        let nombreEmpresa = await obtenerNombreEmpresa(candidatura.id_empresa);
        
        // Crear una card para mostrar la candidatura
        let card = document.createElement("div");
        card.classList.add("card", "mb-3");
        card.classList.add("w-50"); // Ocupa el 50% del ancho
        
        // Crear el contenido de la card
        let cardBody = document.createElement("div");
        cardBody.classList.add("card-body");
        
        // Mostrar el ID de la candidatura
        let idElemento = document.createElement("h5");
        idElemento.classList.add("card-title");
        idElemento.textContent = `Candidatura: ID ${candidatura.id_candidatura}`;
        cardBody.appendChild(idElemento);
        
        // Mostrar el nombre de la empresa
        let empresaElemento = document.createElement("p");
        empresaElemento.classList.add("card-text");
        empresaElemento.textContent = `Empresa: ${nombreEmpresa}`;
        cardBody.appendChild(empresaElemento);
        
        // Mostrar el estado de aprobación
        let aprobadoElemento = document.createElement("p");
        aprobadoElemento.classList.add("card-text");
        
        if (candidatura.aprobado == 1) {
          aprobadoElemento.textContent = `Estado: Aprobado  `;
        } else {
          aprobadoElemento.textContent = `Estado: Denegado  `;
        }
        cardBody.appendChild(aprobadoElemento);
        // Crear el botón "Modificar Candidatura"
        let modificarBtn = document.createElement("button");
        modificarBtn.textContent = "Modificar Candidatura";
        modificarBtn.classList.add("btn", "btn-primary");
        modificarBtn.addEventListener("click", () => {
          // Redirigir a la ventana de modificación de candidatura
          window.location.href = `modificar_candidatura.php?id_candidatura=${candidatura.id_candidatura}`;
        });
        cardBody.appendChild(modificarBtn);
        
        // Agregar el cuerpo de la card a la card
        card.appendChild(cardBody);
        
        // Agregar la card al contenedor
        contenedor.appendChild(card);
      });
    }
  } catch (error) {
    console.error("Error al obtener las candidaturas del alumno:", error);
  }
}

function mostrarAlumnos() {
  fetch("http://apidragos.com/obtener_alumnos.php")
    .then((response) => response.json())
    .then((data) => {
      const dropdownMenu = document.getElementById("dropdownMenu");

      // Limpiar el desplegable antes de mostrar los nuevos datos
      dropdownMenu.innerHTML = "";

      data.forEach((alumno, index) => {
        // Crear el elemento de enlace para el alumno
        const link = document.createElement("a");
        link.classList.add("dropdown-item");

        // Crear el número de enumeración
        const numero = document.createElement("span");
        numero.textContent = `${index + 1}. `;
        link.appendChild(numero);

        // Crear el nombre del alumno
        const nombreAlumno = document.createElement("span");
        nombreAlumno.textContent = `${alumno.nombre} ${alumno.apellidos}`;
        link.appendChild(nombreAlumno);

        // Crear el botón para el perfil del alumno
        const btnPerfil = document.createElement("button");
        btnPerfil.textContent = "Ver perfil";
        btnPerfil.classList.add("btn", "btn-primary", "ms-2");
        btnPerfil.addEventListener("click", (event) => {
          event.stopPropagation();
          // Redirigir al perfil del alumno (reemplazar con la lógica adecuada)
          window.location.href = `perfil_alumno_profesor.php?id=${alumno.id}`;
        });
        link.appendChild(btnPerfil);

        // Agregar el enlace al desplegable
        dropdownMenu.appendChild(link);
      });

      // Resto del código...

      // Inicializar el buscador
      const inputBuscador = document.getElementById("buscadorAlumnos");
      inputBuscador.addEventListener("input", () => {
        const valorBusqueda = inputBuscador.value.toLowerCase();
        const elementos = dropdownMenu.getElementsByTagName("a");

        for (let i = 0; i < elementos.length; i++) {
          const elemento = elementos[i];
          const nombreCompleto = elemento.textContent.toLowerCase();

          if (nombreCompleto.includes(valorBusqueda)) {
            elemento.style.display = "block";
          } else {
            elemento.style.display = "none";
          }
        }

        // Abrir automáticamente el desplegable al buscar algo
        dropdownMenu.classList.add("show");

        // Ocultar el desplegable si se borra el texto del buscador
        if (valorBusqueda === "") {
          dropdownMenu.classList.remove("show");
        }
      });
    })
    .catch((error) => {
      console.error("Error al obtener la lista de alumnos:", error);
    });
}
