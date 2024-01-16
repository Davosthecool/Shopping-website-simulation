var btn_chgmtmdp = document.querySelector(".chgmt_mdp")
var btn_validmdp = document.querySelector(".valid_mdp")
var btn_cancelmdp = document.querySelector(".cancel_mdp")
var div_chgmtmdp = document.querySelector(".changement_du_mdp")
btn_chgmtmdp.addEventListener("click",listener => {
    btn_chgmtmdp.style.display="none"
    div_chgmtmdp.style.display="block"
    console.log("ok")
});

btn_validmdp.addEventListener("click",listener => {
    btn_chgmtmdp.style.display="block"
    div_chgmtmdp.style.display="none"
});

btn_cancelmdp.addEventListener("click",listener => {
    btn_chgmtmdp.style.display="block"
    div_chgmtmdp.style.display="none"
});
