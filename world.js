document.getElementById("lookup").onclick = function() {
    const country = document.getElementById("country").value;
    const url = "world.php?country=" + encodeURIComponent(country);
    fetch(url)
        .then(response => response.text())
        .then(data => {
            document.getElementById("result").innerHTML = data;
        })
        .catch(error => console.error('Error:', error));
}

document.getElementById("cities").onclick = function() {
    const country = document.getElementById("country").value;
    const url = "world.php?country=" + encodeURIComponent(country) + "&lookup=cities";
    fetch(url)
        .then(response => response.text())
        .then(data => {
            document.getElementById("result").innerHTML = data;
        })
        .catch(error => console.error('Error:', error));
}

