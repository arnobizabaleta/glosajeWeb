import neighborhoods from "../../assets/js/domicilios.js";
import { useFetch, messages, validateField } from "../../assets/js/utils/index.js";

const {
    activeGlobalMessage
} = messages;

const comuna_barrio = document.querySelector("#comuna_barrio");

comuna_barrio.onclick = function (event) {
    const target = event.target;

    const otro2 = document.querySelector("[name='otro2']");

    if (target.tagName === "SELECT" && target.value === "Otra" && !!!otro2) {

        const HTML = `
                        <input type="text" name="otro2" placeholder="Su barrio" required="required"/>
                    `;
        return target.closest("div").insertAdjacentHTML("afterend", HTML);
    }

    if (!!otro2) {
        otro2.parentNode.removeChild(otro2);
    }
}

const department = document.querySelector("select[id='municipio']");

window.onload = () => {
    let HTML_NEIGHBORHOODS = "<option value='notfound'>Not found</option>";

    if (!!!neighborhoods.city.length) return;
    else HTML_NEIGHBORHOODS = "";


    for (let city of neighborhoods.city) {
        HTML_NEIGHBORHOODS += `
                    <option value="${city}">${city}</option>
                    `;
    }


    department.innerHTML = HTML_NEIGHBORHOODS;
}

const loginForm = document.querySelector("[data-login]");
const registerForm = document.querySelector("[data-register]");

[loginForm, registerForm].forEach(element => {

    element.addEventListener("submit", async function (event) {
        event.preventDefault();

        const formData = new FormData(this);
        const dataset = this.dataset;

        let {
            request = {},
            result = {}
        } = await useFetch({
            url: this.action,
            useLoader: this.querySelector("button[type='submit']"),
            method: "POST",
            body: formData,
            failFetchOptions: {
                useAbortEndedTime: true,
                maxTime: 6000
            }
        });

        if (!request?.ok) return;

        if (dataset?.register) {
            return activeGlobalMessage({
                message: "Para terminar el proceso de inscripcion, siga las instrucciones que le hemos enviado en el correo registrado",
                type: "success"
            });
        }
        else if (dataset?.login) {
            if (Object.values(result) && result?.location) return location.href = result.location;
        }

    });

    return element.addEventListener("input", function (event) {
        const target = event.target;
        const {
            isValid = false
        } = validateField(event.target.value, event.target.dataset.fieldName);
        const button = this.querySelector("button[type='submit']");

        if (!isValid) {
            if (!button.hasAttribute("disabled")) button.disabled = true;

            if (target.dataset.valid === "true") target.dataset.valid = "false";
            return;
        }

        target.dataset.valid = "true";
        const inputValues = Array.from(this.querySelectorAll("[data-field-name]")).every(input => input.dataset.valid === "true");
        button.disabled = !inputValues;
    });
});

document.querySelectorAll("[data-field-name='email'], [data-field-name='password']").forEach(element => {
    return element.addEventListener("blur", (event) => {

        const { isValid, ouputMessage } = validateField(event.target.value, event.target.dataset.fieldName);
        if (isValid) return;

        activeGlobalMessage({
            message: ouputMessage,
            type: "warning"
        });
    });
});