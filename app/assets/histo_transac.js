var btn_arrows = document.querySelectorAll(".ht_arrow");
var btn_arrow2s = document.querySelectorAll(".ht_arrow2");
var itemsList = document.querySelectorAll("#ITEMS");

btn_arrows.forEach(function(btn_arrow, index) {
    btn_arrow.addEventListener("click", function() {
        itemsList[index].style.display = "block";
        btn_arrow.style.display = "none";
        btn_arrow2s[index].style.display = "block";
    });
});

btn_arrow2s.forEach(function(btn_arrow2, index) {
    btn_arrow2.addEventListener("click", function() {
        itemsList[index].style.display = "none";
        btn_arrow2.style.display = "none";
        btn_arrows[index].style.display = "block";
    });
});