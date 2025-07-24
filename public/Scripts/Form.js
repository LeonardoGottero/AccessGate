function toggleSection() {
    const section = document.getElementById("mySection");
    const arrow = document.querySelector(".arrow");
    section.classList.toggle("open");
    arrow.classList.toggle("rotated");
}
function toggletime() {
    var habilitar = document.getElementById("time").checked;
    var campos = document.querySelectorAll("#times input");
    var timesDiv = document.getElementById("times");
    campos.forEach(function(campo) {
        campo.disabled = !habilitar;
        campo.classList.toggle('disabled', !habilitar);
    });
    if (habilitar) {
        timesDiv.style.display = "block";
    } else {
        timesDiv.style.display = "none"; 
    }
}
document.addEventListener('DOMContentLoaded', toggletime);
document.getElementById("checkAll").addEventListener("change", function() {
    let checkboxes = document.querySelectorAll(".custom-checkbox");
    checkboxes.forEach(checkbox => {
        checkbox.checked = this.checked;
    });
});