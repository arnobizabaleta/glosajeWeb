const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
const passwordRegex = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[!@#$%^&*()_+\-=[\]{};':"\\|,.<>/?]).{8,}$/;

const types = {
    EMAIL: "email",
    PASSWORD: "password"
}

const validateField = (value, type = "text") => {

    let isValid = true;
    let ouputMessage = "";

    const {
        EMAIL,
        PASSWORD
    } = types;

    switch (type) {

        case EMAIL:
            isValid = emailRegex?.test(value);

            if (!isValid) {
                ouputMessage = "El correo es inválido";
            }
            break;

        case PASSWORD:
            isValid = passwordRegex?.test(value);

            if (!isValid) {
                ouputMessage = `La contraseña debe tener como minimo: 1 digito, 
                1 letra minuscula, 1 letra mayuscula, 1 caracter 
                especial y una longitud de 8.`;
            }
            break;

        default:
            return {
                isValid: value.length > 2,
            }
    }

    return {
        isValid,
        ouputMessage
    }
}

export default validateField;