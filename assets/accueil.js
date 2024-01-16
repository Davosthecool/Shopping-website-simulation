document.addEventListener("DOMContentLoaded", function() {
    var btn_arrows = document.querySelectorAll(".flechegauche");
    var btn_arrow2s = document.querySelectorAll(".flechedroite");
    var containers = document.querySelectorAll(".container");

    btn_arrows.forEach(function(btn_arrow, index) {
        btn_arrow.addEventListener("click", function() {
            var i = index
            containers[i].style.display = "none";
            var taille = containers.length;
            if (i === 0){
                i = taille
            }
            containers[i-1].style.display = "flex";
        });
    });

    btn_arrow2s.forEach(function(btn_arrow2, index2) {
        btn_arrow2.addEventListener("click", function() {
            var j = index2
            containers[j].style.display = "none";
            var taille = containers.length-1;
            if (j === taille){
                j = -1
            }
            containers[j+1].style.display = "flex";
        });
    });
});
