var modal = document.getElementById("myModal");
var btn = document.getElementById("myBtn");
var span = document.getElementsByClassName("close")[0];

var twoFaModal = document.getElementById("twoFaModal");
var twoFaBtn = document.getElementById("twoFaBtn");
var closeTwoFaSpan = document.getElementsByClassName("closeTwoFa")[0];

btn.onclick = function() {
    modal.style.display = "block";
}
span.onclick = function() {
    modal.style.display = "none";
}

twoFaBtn.onclick = function() {
    twoFaModal.style.display = "block";
}
closeTwoFaSpan.onclick = function() {
    twoFaModal.style.display = "none";
}

window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
    if (event.target == twoFaModal) {
        twoFaModal.style.display = "none";
    }
}