async function postData(url = "", data = {}) {
  // Opciones por defecto estan marcadas con un *
  const response = await fetch(url, {
    method: "POST", // *GET, POST, PUT, DELETE, etc.
    mode: "cors", // no-cors, *cors, same-origin
    cache: "no-cache", // *default, no-cache, reload, force-cache, only-if-cached
    credentials: "same-origin", // include, *same-origin, omit
    headers: {
      "Content-Type": "application/json",
      // 'Content-Type': 'application/x-www-form-urlencoded',
    },
    redirect: "follow", // manual, *follow, error
    referrerPolicy: "no-referrer", // no-referrer, *no-referrer-when-downgrade, origin, origin-when-cross-origin, same-origin, strict-origin, strict-origin-when-cross-origin, unsafe-url
    body: JSON.stringify(data), // body data type must match "Content-Type" header
  });
  return response.json(); // parses JSON response into native JavaScript objects
}

const url = "https://confeccioneslyz.000webhostapp.com/test.php";

async function admin() {
  const response = await postData(url, { type: "auth" });
  if (!response.status) {
    window.location.href = "https://confeccioneslyz.000webhostapp.com/";
  }
}

admin();

async function getOne(id) {
  return await postData(url, {
    id: id,
    type: "one",
  }).then((x) => x);
}

async function getAll() {
  return await postData(url, {
    type: "all",
  }).then((x) => x);
}

async function modifyOne(data) {
  return await postData(url, data).then((x) => x);
}

async function deleteUser() {
  const id = document.getElementById("idProvider");
  const package = {
    id: id.value,
    type: "delete",
  };

  if (confirm("¿Está seguro que desea eliminar este usuario?")) {
    modifyOne(package).then((x) => {
      console.log(x);
      location.reload();
    });
  }
}

async function updateUser() {
  const id = document.getElementById("idProvider");
  const input = document.getElementById("EditName");
  const userType = document.getElementById("UserType");
  const password = document.getElementById("pass");

  const package = {
    id: id.value,
    Usuario: input.value,
    password: password.value,
    Tipo: userType.value,
    type: "update",
  };

  modifyOne(package).then((x) => {
    console.log(x);
    location.reload();
  });
}

async function fillModal(id) {
  const data = await getOne(id);

  const inputId = document.getElementById("idProvider");
  inputId.setAttribute("value", data.id);

  const passInput = document.getElementById("pass");
  passInput.setAttribute("value", data.Contraseña);

  if (data.Tipo === "Jefe") {
    const option = document.getElementById("boss");
    option.setAttribute("selected", true);
  } else if (data.Tipo === "Empleado") {
    const option = document.getElementById("emp");
    option.setAttribute("selected", true);
  }

  let input = document.getElementById("EditName");
  input.setAttribute("value", data.Usuario);
}

function getAsis(id, name) {
  localStorage.setItem("Uid", id);
  localStorage.setItem("Uname", name);
  window.location.href = "GestionAsistencia.html";
}

function rowCreator() {
  let d = document.createElement("div");
  d.className = "row fila";

  return d;
}

function tdCreator(text, id, username, justOne) {
  let col = document.createElement("div");

  if (justOne) {
    col.className = `${justOne}`;
  } else {
    col.className = "col";
  }

  col.innerText = text;
  col.setAttribute("onclick", `getAsis(${id}, '${username}')`);

  return col;
}

function btColumn(id = null) {
  let buttonColumn = document.createElement("div");
  buttonColumn.className = "col-3";
  buttonColumn.innerHTML = `<button
      type="button"
      id="${id}"
      onclick="fillModal(${id})"
      class="btn btn-primary"
      data-bs-toggle="modal"
      data-bs-target="#staticBackdrop"
    >
     Seleccionar 
    </button>`;

  return buttonColumn;
}

async function insert() {
  let data = await getAll();

  let tbody = document.getElementById("tbody");

  for (let i = 0; i < data.length; i++) {
    tbody.append(rowCreator());

    if (i == data.length - 1) {
      let rows = Array.prototype.slice.call(
        document.getElementsByClassName("row")
      );

      rows.shift();

      rows.forEach((x, i) => {
        for (let j = 0; j < 3; j++) {
          switch (j) {
            case 0:
              x.append(
                tdCreator(data[i].id, data[i].id, data[i].Usuario, "col body")
              );
              break;
            case 1:
              x.append(
                tdCreator(
                  data[i].Usuario,
                  data[i].id,
                  data[i].Usuario,
                  "col body"
                )
              );
              break;
            case 2:
              x.append(
                tdCreator(data[i].Tipo, data[i].id, data[i].Usuario, "col body")
              );
              break;
          }
        }
        x.append(btColumn(data[i].id));
      });
    }
  }
}
