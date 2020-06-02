function toggleFunction() {
    var x = document.getElementById("navDemo");
    if (x.className.indexOf("") == -1) {
        x.className += " ";
    } else {
        x.className = x.className.replace(" ", "");
    }
}

const contentBox = document.getElementById("contentBox");

contentBox.addEventListener("keydown", function() {
    if (event.key === "Tab") {
        event.preventDefault();
        contentBox.value = contentBox.value + "    ";
    }
    if (event.key === "Enter") {
        
    }
})

function content() {
    let x = contentBox.setSelectionRange(0, contentBox.value.length);

    return x;
}
