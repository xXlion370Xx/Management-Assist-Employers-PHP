const llegar = "https://confeccioneslyz.herokuapp.com/php/llegar.php";
const salir = "https://confeccioneslyz.herokuapp.com/php/salir.php";

function newDate(date) {
  let d = date.split("/");
  let data = `${d[2]}-${d[1]}-${d[0]}`;

  return data;
}

async function postData(url = "", data = {}, method = "POST") {
  let options = {};

  if (method === "GET") {
    options = {
      method: method, // *get, post, put, delete, etc.
      mode: "cors", // no-cors, *cors, same-origin
      cache: "no-cache", // *default, no-cache, reload, force-cache, only-if-cached
      credentials: "same-origin", // include, *same-origin, omit
      headers: {
        "content-type": "application/json",
        // 'content-type': 'application/x-www-form-urlencoded',
      },
      redirect: "follow", // manual, *follow, error
      referrerpolicy: "no-referrer", // no-referrer, *no-referrer-when-downgrade, origin, origin-when-cross-origin, same-origin, strict-origin, strict-origin-when-cross-origin, unsafe-url
    };
  } else {
    options = {
      method: method, // *get, post, put, delete, etc.
      mode: "cors", // no-cors, *cors, same-origin
      cache: "no-cache", // *default, no-cache, reload, force-cache, only-if-cached
      credentials: "same-origin", // include, *same-origin, omit
      headers: {
        "content-type": "application/json",
        // 'content-type': 'application/x-www-form-urlencoded',
      },
      redirect: "follow", // manual, *follow, error
      referrerpolicy: "no-referrer", // no-referrer, *no-referrer-when-downgrade, origin, origin-when-cross-origin, same-origin, strict-origin, strict-origin-when-cross-origin, unsafe-url
      body: JSON.stringify(data), // body data type must match "content-type" header
    };
  }
  // Opciones por defecto estan marcadas con un *
  const response = await fetch(url, options);
  return response.json(); // parses JSON response into native JavaScript objects
}

async function registrar() {
  return await postData(
    "https://confeccioneslyz.herokuapp.com/request.php",
    {},
    "GET"
  ).then((x) => {
    if (x) {
      let date = x.split("T")[0];
      let time = x.split("T")[1].split(".")[0];

      return { date, time };
    } else {
      const datos = new Date().toLocaleString("en-GB").split(", ");
      return { date: newDate(datos[0]), time: datos[1] };
    }
  });

  //  return await fetch("http://localhost/ConfeccionesLYZ/request.php", {
  //    method: "GET",
  //  }).then((response) =>
  //    response.json().then((data) => {
  //      if (data.datetime) {
  //        let date = data.datetime.split("T")[0];
  //        let time = data.datetime.split("T")[1].split(".")[0];
  //        console.log(data, time);
  //
  //        return { date, time };
  //      } else {
  //        const datos = new Date().toLocaleString("en-GB").split(", ");
  //
  //        return { date: newDate(datos[0]), time: datos[1] };
  //      }
  //    })
  //  );
}

function prevenirLlegada() {
  const confirmacion = confirm(
    "Estas apunto de registrar llegada, ¿Deseas continuar?"
  );
  if (confirmacion) {
    registrar().then((x) =>
      postData(llegar, x).then((data) => console.log(data))
    );
    alert("Llegada registrada correctamente.");
    location.reload();
  } else if (confirmacion == false) {
    preventDefault();
  }
}

function prevenirSalida() {
  const confirmacion = confirm(
    "Estas apunto de registrar salida, ¿Deseas continuar?"
  );
  if (confirmacion) {
    registrar().then((x) =>
      postData(salir, x).then((data) => console.log(data))
    );
    alert("Salida registrada correctamente.");
    location.reload();
  } else if (confirmacion == false) {
    preventDefault();
  }
}

function hideBtn(data) {
  const { exist } = data;
  console.log(data);

  const btn = document.getElementById("Boton-1");
  const btn2 = document.getElementById("Boton-2");
  if (exist) {
    btn2.removeAttribute("hidden");
    btn.setAttribute("hidden", true);
  } else {
    btn.removeAttribute("hidden");
    btn2.setAttribute("hidden", true);
  }
}

function exist() {
  registrar().then((x) => {
    const { date } = x;

    postData("https://confeccioneslyz.herokuapp.com/php/today.php", {
      date,
    }).then((data) => hideBtn(data));
  });
}

function MostrarTabla() {
  function tdCreator(text, justOne) {
    let col = document.createElement("div");

    if (justOne) {
      col.className = `${justOne}`;
    } else {
      col.className = "col";
    }

    col.innerText = text;

    return col;
  }

  async function getAll(id) {
    return await postData(
      "https://confeccioneslyz.herokuapp.com/crudAsis.php",
      {
        id: id,
        type: "all",
      }
    ).then((x) => x);
  }

  function rowCreator() {
    let d = document.createElement("div");
    d.className = "row fila";

    return d;
  }

  async function insert() {
    const usuario = await postData(
      "https://confeccioneslyz.herokuapp.com/crudAsis.php",
      { type: "id" }
    );

    let data = await getAll(usuario.id);

    let tbody = document.getElementById("tbody");

    for (let i = 0; i < data.length; i++) {
      tbody.append(rowCreator());

      if (i == data.length - 1) {
        let rows = Array.prototype.slice.call(
          document.getElementsByClassName("row")
        );

        rows.splice(0, 3);

        rows.forEach((x, i) => {
          for (let j = 0; j < 3; j++) {
            switch (j) {
              case 0:
                x.append(tdCreator(data[i].entrada, "col body"));
                break;
              case 1:
                x.append(tdCreator(data[i].salida, "col body"));
                break;
              case 2:
                x.append(tdCreator(data[i].fecha, "col body"));
                break;
            }
          }
        });
      }
    }
  }
  insert();
}

exist();
