document.getElementById("addpet").addEventListener("click", function () {
  document.querySelector(".bg-modal").style.display = "flex";
});

document.querySelector(".close").addEventListener("click", function () {
  document.querySelector(".bg-modal").style.display = "none";
});

const image_input = document.getElementById("imagine");
const button = document.getElementById("submit");
const imggrid = document.querySelector(".image-grid");
var numePet = "";
button.addEventListener("click", function () {
  const reader = new FileReader();
  reader.addEventListener("load", () => {
    const uploaded_image = reader.result;
    const element = document.createElement("div");
    element.id = "display-image";
    element.style.backgroundImage = `url(${uploaded_image})`;
    numePet = document.getElementById("nume").value;
    const para = document.createElement("p");
    const node = document.createTextNode(numePet);
    para.appendChild(node);
    var newNode = document.createElement("div");
    newNode.classList.add("pet__item");
    para.classList.add("pet__name");
    newNode.appendChild(element);
    newNode.appendChild(para);
    imggrid.appendChild(newNode);
    //locally store name and image of pet in local storage so that it can be accessed later
    localStorage.setItem(numePet, uploaded_image);
    document.querySelector(".bg-modal").style.display = "none";

    var exec = require("child_process").exec;

    exec("php main.php", function (error, stdOut, stdErr) {
      if (error) {
        console.log(error);
      }
      console.log(stdOut);
    });
  });
  reader.readAsDataURL(image_input.files[0]);
});
