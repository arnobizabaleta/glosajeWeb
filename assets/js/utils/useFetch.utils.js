import message from "./messages.utils.js";
import handleLoad from "./handleLoad.util.js";

const { hideLoader, loader } = handleLoad;
const { activeGlobalMessage, activeGlobalMessageV2 } = message;

export default async function useFetch({

    url, method, useLoader = "",
    failFetchOptions,
    ...fetchBody

}) {

    const {
        messageTimeEndedFetch = "El servidor esta tomando demasiado en responder, por favor, intenta recargar la pagina o espera",
        maxTime = 5000,
        useAbortEndedTime = false
    } = failFetchOptions;

    let controller = "", request = "", result = "";

    if (useLoader) loader(useLoader);

    if (useAbortEndedTime) {
        controller = new AbortController();
        fetchBody.signal = controller.signal;
    }

    const timeout = setTimeout(() => {
        activeGlobalMessageV2({
            message: messageTimeEndedFetch,
            type: "brown"
        });

        if (controller && useAbortEndedTime) {
            controller.abort();
        }

    }, maxTime);

    const startTime = performance.now();

    try {
        request = await fetch(url, { method, ...fetchBody });

    }
    catch (err) {
        if (err.name === "AbortError") {
            if (useLoader) hideLoader(useLoader);
            return {}
        } 
    }

    const contentType = request.headers.get("Content-Type");

    if (contentType.startsWith("application/json")) {
        result = await request.json();
    }

    const endTime = performance.now();

    clearTimeout(timeout);

    if (!request.ok && result && "message" in result) {
        activeGlobalMessage({
            message: result.message,
            type: "warning"
        });
    }

    else if (!request.ok) {

        return activeGlobalMessage({
            message: "SERVER ERROR",
            type: "warning"
        });
    }

    if (useLoader) hideLoader(useLoader);

    return {
        result,
        request,
        timeTaken: endTime - startTime
    }
}