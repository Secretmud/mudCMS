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

const imgsrc = document.querySelectorAll("img[id^=imgsrc]");
var check = true;

/**
 * Image data
 * id   =>  "imgLocation"
 * id   =>  "imgName"
 * id   =>  "imgDesc"
 * id   =>  "imgSize"
 * id   =>  "imgExtension"
 * id   =>  "imgInc"
 */
const imgLocation = document.getElementById("imgLocation");
const imgName = document.getElementById("imgName");
const imgDesc = document.getElementById("imgDesc");
const imgSize = document.getElementById("imgSize");
const imgExtension = document.getElementById("imgExtension");
const imgInc = document.getElementById("imgInc");

console.log("Found", imgsrc.length, "div which class starts with “button”.");

for (var i = 0; i < imgsrc.length; i++) {
    imgsrc[i].addEventListener('click', function() {
        imgLocation.innerHTML = this.src;
        imgName.innerHTML = this.src.replace(/^.*[\\\/]/, '');
        imgDesc.innerHTML = this.length;
        imgSize.innerHTML = this.i;
        imgExtension.innerHTML = "stuff";
        imgInc.innerHTML ="! "+this.src+" : "+this.src.replace(/^.*[\\\/]/, '');
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
        contentBox.value = insertIntoTextArea(contentBox, "\t");
    }
    if (event.key === "F4") {
        event.preventDefault();
        contentBox.value = insertIntoTextArea(contentBox, "\n~\n");
    }
    if (event.key === "F1") {
        event.preventDefault();
        contentBox.value = insertIntoTextArea(contentBox, "# ");
    }
    if (event.key === "F2") {
        event.preventDefault();
        contentBox.value = insertIntoTextArea(contentBox, "## ");
    }
    if (event.key === "F3") {
        event.preventDefault();
        contentBox.value = insertIntoTextArea(contentBox, "### ");
    }
    if (event.key === "F3") {
        event.preventDefault();
        contentBox.value = insertIntoTextArea(contentBox, "### ");
    }
});

function content() {
    let x = contentBox.setSelectionRange(0, contentBox.value.length);

    return x;
}

function insertIntoTextArea(textarea, replacement) {
    let start = textarea.selectionStart;
    let stop = textarea.selectionEnd;

    let data = textarea.value;
    let res = data.split("");
    if (start == stop) {
        res.splice(start, 0, replacement);
    } else {
        res.splice(start, 0, replacement);
        res.splice(stop + 1, 0, replacement);
    }
    let x = res.toString().replace(/\,/g, "");
    console.log("start:\t" +start+ "\nstop:\t" +stop);
    console.log("res[" + start + "] == " + replacement);
    if (start != stop) console.log("res[" + stop + "] == " + replacement);
    console.log("data:\t" + x.replace(/\,/g, ""));
    return x;
}
