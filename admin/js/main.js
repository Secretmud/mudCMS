function toggleFunction() {
    var x = document.getElementById("navDemo");
    if (x.className.indexOf("") == -1) {
        x.className += " ";
    } else {
        x.className = x.className.replace(" ", "");
    }
}

const code = document.getElementById("code");
const link = document.getElementById("link");
const test = document.getElementById("test");
const contentBox = document.getElementById("contentBox");

code.addEventListener("click", function() {
	let val = contentBox.value + "\[code\]\[/code\]"  
    contentBox.value = val;
});
link.addEventListener("click", function() {
    let val = contentBox.value + "\[link\]\[/link\]"  
    contentBox.value = val;
});
test.addEventListener("click", function() {
    let val = contentBox.value + "\[test\]\[/test\]";
    contentBox.value = val;
});
contentBox.addEventListener("keydown", function() {
    if (event.key === "Tab") {
        event.preventDefault();
        console.log(content());
    }
})

function content() {
    let x = contentBox.setSelectionRange(0, contentBox.value.length);

    return x;
}
