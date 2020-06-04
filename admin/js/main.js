function toggleFunction() {
    var x = document.getElementById("navDemo");
    if (x.className.indexOf("") == -1) {
        x.className += " ";
    } else {
        x.className = x.className.replace(" ", "");
    }
}

const contentBox = document.getElementById("contentBox");
const image = document.getElementById("btnModal");
const modal = document.getElementById("imgModal");
const image_pick = document.querySelectorAll("div[class^=images_pick]");
const imgLocation = document.getElementById("imgLocation");
const imgsrc = document.querySelectorAll("img[id^=imgsrc]");
var check = true;


console.log("Found", imgsrc.length, "div which class starts with “button”.");

for (var i = 0; i < imgsrc.length; i++) {
    imgsrc[i].addEventListener('click', function() {
        imgLocation.innerHTML = this.src;
    });
}
image.addEventListener("click", function() {
    modal.classList.toggle("imgModal");
    modal.classList.toggle("displayModal");
    image.classList.toggle("btnModal");
    if (check) {
        image.innerHTML = "X";
        check = false;
    }
    else {
        image.innerHTML = "Insert images";
        check = true;
    } 
});

contentBox.addEventListener("keydown", function() {
    if (event.key === "Tab") {
        event.preventDefault();
        contentBox.value = contentBox.value + "    ";
    }
    if (event.key === "Enter") {
        
    }
});

function content() {
    let x = contentBox.setSelectionRange(0, contentBox.value.length);

    return x;
}

