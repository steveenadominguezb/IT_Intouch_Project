document.getElementById("icon-menu").addEventListener("click", show_menu);
document.getElementById("back_menu").addEventListener("click", hide_menu);

nav = document.getElementById("navegation");
background_menu = document.getElementById("back_menu");

function show_menu() {
    nav.style.right = "0px";
    background_menu.style.display = "block";
}

function hide_menu() {
    nav.style.right = "-250px";
    background_menu.style.display = "none";
}
