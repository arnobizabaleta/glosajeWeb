import { validateField, messages } from "../../assets/js/utils/index.js";

const handleValidateFields = (element) => {
    console.log("Comming here");
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
}

const handleOnBlurFields = (element) => {
    return element.addEventListener("blur", (event) => {

        const { isValid, ouputMessage } = validateField(event.target.value, event.target.dataset.fieldName);
        if (isValid) return;

        messages.activeGlobalMessage({
            message: ouputMessage,
            type: "warning"
        });
    });
}

export {
    handleValidateFields,
    handleOnBlurFields
}