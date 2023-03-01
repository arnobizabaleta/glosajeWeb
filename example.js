
(async () => {
    const result = await fetch("../practice.php", {
        method: "GET"
    });

    let response = await result.json();
    console.log("result");
    console.log(result);
    console.log("response");
    console.log(response);
})();