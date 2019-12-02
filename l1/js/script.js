window.addEventListener("load", function () {
    let root = document.documentElement;
    let change = true;
    let python = document.getElementById("python");

    setInterval(function () {
        if (change) {
            root.style.setProperty("--secondary-color", "#213769");
            python.textContent = "Python 🐍";
            change = false;
        } else {
            root.style.setProperty("--secondary-color", "#eac67a");
            python.textContent = "Python";
            change = true;
        }
    }, 10000);
});
