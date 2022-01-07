function OnlineEditor(textarea) {
    const data = {
        start: textarea.selectionStart,
        stop: textarea.selectionEnd,
        insertIntoTextArea: (replacement) => {
            let data = textarea.value;
            let res = data.split("");
            if (start == stop) {
                res.splice(start, 0, replacement);
            } else {
                res.splice(start, 0, replacement);
                res.splice(stop, 0, replacement);
            }
            let x = res.toString().replace(/\,/g, "");
            console.log("start:\t" +start+ "\nstop:\t" +stop);
            console.log("res[" + start + "] == " + replacement);
            if (start != stop) console.log("res[" + stop + "] == " + replacement);
            console.log("data:\t" + x.replace(/\,/g, ""));
            return x;
        }
    }
    return data;
}


OnlineEditor(textarea).insertIntoTextArea("# ");
