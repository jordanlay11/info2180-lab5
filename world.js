document.getElementById("lookup").onclick = function() {
    const country = document.getElementById("country").value;
    const url = "world.php?country=" + encodeURIComponent(country);
    fetch(url)
        .then(response => response.json())
        .then(data => {
            document.getElementById("result").innerHTML = JSON.stringify(data);
        })
        .catch(error => console.error('Error:', error));
}


