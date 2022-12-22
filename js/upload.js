const list_page = document.getElementById("list_page");
const upload_page = document.getElementById("upload_page");
const nav_item = document.getElementsByClassName("nav-item");
const delete_text = document.getElementById("delete_text");
const showPage = document.getElementById("showPage");
const phpSays = document.getElementById("phpSays");
const resultUploadList = document.getElementById("resultUploadList");
const list_page_error = document.getElementById("list_page_error");
const myList = document.getElementById("myList");

// 1 upload xlx file
async function uploadFile() {
  let formData = new FormData();
  formData.append("file", fileupload.files[0]);
  const response = await fetch("php/upload.php", {
    method: "POST",
    body: formData,
  })
    .then(function (response) {
      if (response.status >= 200 && response.status < 300) {
        return response.text();
      }
      throw new Error(response.statusText);
    })
    .then(function (response) {
      let answer = JSON.parse(response);
      phpSays.innerHTML = answer.text;
      console.log(`response from php: ${answer.text},${answer.location}`);
      loadToDb(answer.location);
    });
}

//2 upload load xlx file ToDb
function loadToDb(location) {
  console.log(`will now upload to db with php`);
  const response = fetch("php/openFile.php?location=" + location)
    .then(function (response) {
      if (response.status >= 200 && response.status < 300) {
        console.log("response.status >= 200 && response.status < 300");
        return response.text();
      }
      throw new Error(response.statusText);
    })
    .then(function (response) {
      console.log("response????:" + response);
      let answer = JSON.parse(response);
      console.log(typeof answer);
      showResult(answer);
    });
}

let deleteDB = () => {
  const response = fetch("php/deleteDb.php")
    // fetch() returns a promise. When we have received a response from the server,
    // the promise's `then()` handler is called with the response.
    .then((response) => {
      console.log("respomse then 1");
      // Our handler throws an error if the request did not succeed.
      if (!response.ok) {
        throw new Error(`HTTP error: ${response.status}`);
      }
      // Otherwise (if the response succeeded), our handler fetches the response
      // as text by calling response.text(), and immediately returns the promise
      // returned by `response.text()`.
      return response.text();
    })

    // When response.text() has succeeded, the `then()` handler is called with
    // the text, and we copy it into the `poemDisplay` box.
    .then((text) => {
      console.log("respomse then 2");
      delete_text.innerText = text;
    })
    // Catch any errors that might happen, and display a message
    // in the `delete_text` box.
    .catch((error) => {
      console.log("respomse then 3");
      delete_text.innerText = `Could not fetch: ${error}`;
    });
};

function showDB() {
  const response = fetch("php/showDb.php", {
    method: "get",
  })
    .then(function (response) {
      if (response.status >= 200 && response.status < 300) {
        console.log("response.status >= 200 && response.status < 300");
        return response.text();
      }
    })
    .then(function (response) {
      console.log("showDB????");
      console.log(response);
      console.log("---------------------");
      const obj = JSON.parse(response);
      console.log(obj);
      console.log(obj.error);
      if (obj.error > 0) {
        list_page_error.style.display = "block";
      } else {
        myList.style.display = "block";
        console.log(`obj`);
        console.log(obj);
        console.log(`obj[0]`);
        console.log(Object.keys(obj[0]).length);
        console.log(obj[0]);
        for (const [key, value] of Object.entries(obj)) {
          if (key == "error") {
            continue;
          }
          let singleList = document.createElement("div");
          singleList.className = "singleList";
          singleList.id = "single_list_" + value["id"];

          let singleListInfo = document.createElement("div");
          singleListInfo.className = "singleListInfo";

          let listBitId = document.createElement("div");
          listBitId.className = "listBitId";
          listBitId.innerHTML = value.id;

          let listBitKurz = document.createElement("div");
          listBitKurz.className = "listBitKurz";
          listBitKurz.innerHTML = value.kurz;

          let listBitLang = document.createElement("div");
          listBitLang.className = "listBitLang";
          listBitLang.innerHTML = value.lang;

          let listBitFach = document.createElement("div");
          listBitFach.className = "listBitFach";
          listBitFach.innerHTML = value.fach;

          let listBitMeaning = document.createElement("div");
          listBitMeaning.className = "listMeaning";
          listBitMeaning.innerHTML = value.meaning;

          let listBitImg = document.createElement("div");
          listBitImg.className = "listBitImg";
          let image = document.createElement("img");
          image.src = "img/img" + value.id.charAt(value.id.length - 1) + ".jpg";
          image.setAttribute("alt", value.lang);

          let listButtons = document.createElement("div");
          listButtons.className = "listButtons";

          let listBitDelete = document.createElement("div");
          listBitDelete.className = "listBitDelete";
          let listBitDeleteButton = document.createElement("button");
          listBitDeleteButton.innerHTML = "DELETE";
          listBitDeleteButton.className = "listBitDeleteButton";
          listBitDeleteButton.id = "listBitDelete_" + value.id;
          listButtons.appendChild(listBitDeleteButton);

          let listBitEdit = document.createElement("div");
          listBitEdit.className = "listBitEdit";
          let listBitEditButton = document.createElement("button");
          listBitEditButton.innerHTML = "EDIT";
          listBitEditButton.className = "listBitEditButton";
          listBitEditButton.id = "listBitEdit_" + value.id;
          listButtons.appendChild(listBitEditButton);

          // 👇️ optionally ERROR

          image.onerror = function handleError() {
            console.log("Image could not be loaded");
          };
          listBitImg.appendChild(image);

          singleListInfo.append(listBitId);
          singleListInfo.append(listBitKurz);
          singleListInfo.append(listBitLang);
          singleListInfo.append(listBitFach);
          singleListInfo.append(listBitMeaning);
          singleListInfo.append(listBitImg);
          singleListInfo.append(listButtons);

          singleList.append(singleListInfo);
          myList.append(singleList);
          // console.log(`${key}: ${value}`);
          // addToList(value);
        }
      }
    })
    .then(function (response) {
      console.log("what happens");

      const listBitEditButton2 =
        document.getElementsByClassName("listBitEditButton");
      const listBitDeleteButton2 = document.getElementsByClassName(
        "listBitDeleteButton"
      );
      console.log(Object.keys(listBitEditButton2).length);
      console.log(Object.keys(listBitDeleteButton2).length);

      Object.keys(listBitDeleteButton2).forEach((key) => {
        listBitDeleteButton2[key].addEventListener("click", function (event) {
          deleteMe(event);
        });
      });
      // //edit button
      Object.keys(listBitEditButton2).forEach((key) => {
        listBitEditButton2[key].addEventListener("click", function (event) {
          editMe(event);
        });
      });
    });

  // //delete buttonaleert
}

let showResult = (obj) => {
  // reverswe array with map

  let obj1 = [...obj].reverse();

  let table = document.createElement("table");
  for (const [key, value] of Object.entries(obj1)) {
    // console.log(typeof value);
    // console.log(value.length);

    // console.log(value.ERROR ? value.ERROR.length : "no value.error");
    // console.log(value);

    if (!value.ERROR) {
      r = table.insertRow(0);
      c = r.insertCell(0);
      c.innerHTML = value;
    } else {
      r = table.insertRow(0);
      c = r.insertCell(0);
      let toFix = "";

      toFix += "nummer: " + value.number + "<br>";
      toFix += "ERROR: " + value.ERROR + "<br>";
      toFix += "kurz: " + value.kurz + "<br>";
      toFix += "lang: " + value.lang + "<br>";
      toFix += "fach: " + value.fach + "<br>";
      toFix += "def: " + value.def + "<br>";
      c.innerHTML = toFix;
    }
    resultUploadList.appendChild(table);
  }
};

let UpdatePage = (val) => {
  if (val == "list") {
    showPage.innerText = "SHOW DB";
    list_page.style.display = "block";
    upload_page.style.display = "none";
    delete_page.style.display = "none";
    list_page_error.style.display = "none";
    myList.innerText = "";
    showDB();
  } else if (val == "delete") {
    showPage.innerText = "DELETE DB";
    upload_page.style.display = "none";
    list_page.style.display = "none";
    delete_page.style.display = "block";
    deleteDB();
  } else {
    showPage.innerText = "SAVE EXCEL TO DB";
    upload_page.style.display = "block";
    phpSays.innerHTML = "* span * ";
    resultUploadList.innerHTML = "* span resultUploadList *";
    list_page.style.display = "none";
    delete_page.style.display = "none";
  }
};

let preUpdatePage = (e) => {
  let text = e.target.id;
  UpdatePage(text);
};

const deleteMe = (e) => {
  console.log("deleteMe: " + e.target.id);
  let key = e.target.id.replace(/\D/g, "");
  //remove from db

  removeFromDb(key);

  //remove from array??
  removeFromList(key);
};

// let formData = new FormData();
// formData.append("file", fileupload.files[0]);
// const response = await fetch("php/upload.php", {
//   method: "POST",
//   body: formData,
// })
function removeFromList(key) {
  const element = document.getElementById("single_list_" + key);
  element.remove();
}

function removeFromDb(key) {
  let formData = new FormData();
  formData.append("key", key);
  const response = fetch("php/deleteDbSingle.php", {
    method: "POST",
    body: formData,
  }) // Converting to JSON
    .then((response) => response.json())

    // Displaying results to console
    .then((json) => console.log(json));
}

const editMe = (e) => {
  console.log("editMe: " + e.target.id);
  let key = parseInt(e.target.id);
};
//EVENTS
Object.keys(nav_item).forEach((key) => {
  nav_item[key].addEventListener("click", preUpdatePage);
});
