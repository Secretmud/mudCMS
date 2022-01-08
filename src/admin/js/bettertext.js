function BetterText(id) {
    const term = document.getElementById(id);
    term.contentEditable = "true";
    const data = {
        start: term.selectionEnd,
        stop: () => term.innerHTML.split("").length - 3,
        termBackgroundColor: (color) => {
            term.style.backgroundColor = color;
        },
        termTextColor: (color) => {
            term.style.color = color;
        },
        termEvents: () => {
            term.addEventListener("keydown", () => {
                if (event.key === "Enter") {
                    data.insertSpecial("|||");
                }
                if (event.key === "Tab") {
                    data.insertSpecial("----")
                }
            })
        },
        insertSpecial: (replacement) => {
            let data = term.innerHTML;
            let res = data.split("");
            console.log(res);
            if (data.start == data.stop) {
                res.splice(data.start, 0, replacement);
            } else {
                res.splice(data.start, 0, replacement);
                res.splice(data.stop, 0, replacement);
            }
            let x = res.toString().replace(/\,/g, "");
            console.log("start:\t" + data.start + "\nstop:\t" + data.stop);
            console.log("res[" + data.start + "] == " + replacement);
            if (data.start != data.stop) console.log("res[" + data.stop + "] == " + replacement);
            console.log("data:\t" + x.replace(/\,/g, ""));
            term.innerHTML = x;
        }
    }
    return data;
}

const term1 = BetterText("term");
term1.termBackgroundColor("black");
term1.termTextColor("green");
term1.termEvents();
