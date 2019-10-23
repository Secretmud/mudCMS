document.getElementById("burgerMenu").addEventListener("click", toggleMenu);

function toggleMenu() {
    var menu = document.getElementById("menu");
    var burger = document.getElementById("burgerMenu");
    menu.classList.toggle("menu");
    menu.classList.toggle("menu_side");
    burger.classList.toggle("placement");
}

/*document.getElementById("style-picker").addEventListener("click", function(){
    var selected = this.options[this.selectedIndex].value;
    var color = localStorage.setItem("scheme", JSON.stringify(selected));
    var datarecived = localStorage.getItem('scheme');
    if(!datarecived) {
        setStyleSource ("color", selected);
        console.log("State1:", JSON.parse(color));
    } else {
        setStyleSource("color", JSON.parse(datarecived));
        console.log("State2:", JSON.parse(datarecived));
    }

});

var css_file = "css/colorscheme/dark.css";



function setStyleSource (linkID, sourceLoc) {
    var theLink = document.getElementById(linkID);
    theLink.href = sourceLoc;
    console.log(theLink.href);
}

window.onload = function() {
    setColor();
}
function setColor() {
    var datarecived = localStorage.getItem('scheme');
    if(!datarecived) {
        setStyleSource ("color", "css/colorscheme/dark.css");
        console.log("State1:", JSON.parse(color));
    } else {
        setStyleSource("color", JSON.parse(datarecived));
        console.log("State2:", JSON.parse(datarecived));
    }
}*/