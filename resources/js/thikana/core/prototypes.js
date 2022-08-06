String.prototype.htmlToText = function () {
    const tmp = document.createElement("div");
    tmp.innerHTML = this;

    return tmp.textContent || tmp.innerText || "";
};

Array.prototype.insert = function (index, items) {
    const temp = this;
    if (Array.isArray(index)) {
        index.forEach((_, i) => {
            temp.splice.apply(temp, [_, 0].concat(items[i]));
        });
    } else {
        temp.splice.apply(temp, [index, 0].concat(items));
    }

    return temp;
};
