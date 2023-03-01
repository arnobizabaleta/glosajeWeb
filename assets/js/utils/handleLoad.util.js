
const handleLoad = {
    loader: (target, position = "afterbegin") => {
        let spinner = "<div class='implemetnsLoader'></div>";

        return target.insertAdjacentHTML(position, spinner);
    },

    hideLoader: (parentTarget) => {
        let child = parentTarget?.querySelector(".implemetnsLoader");

        if (child) {
            parentTarget?.removeChild(child);
        }
        else {
            child = document.querySelector(".implemetnsLoader");
            child.remove();

        }
    },
}

export default handleLoad;