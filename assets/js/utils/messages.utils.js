
const messages = {
    activeGlobalMessage: ({ type, message, error }) => {
        const Toast = Swal.mixin({
            toast: true,
            position: "top-end",
            showConfirmButton: false,
            timer: 5000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener("mouseenter", Swal.stopTimer);
                toast.addEventListener("mouseleave", Swal.resumeTimer);
            }
        })
        Toast.fire({
            icon: type,
            title: message,
            text: error
        });
    },

    activeGlobalMessageV2: ({ message, type = "#00FF7F", useOkFunction = "" }) => {
        Swal.fire({
            text: message,
            toast: true,
            position: "top",
            color: type
        }).then(async (result) => {
            if (result.isConfirmed && useOkFunction ) {
                await useOkFunction();
            }
        });
    },
}

export default messages;