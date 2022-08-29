/*################################################# HEADER  ##################################*/
const btnMobile = document.getElementById("btn-mobile");

function toggleMenu(event) {
    if (event.type === "touchstart") event.preventDefault();
    const nav = document.getElementById("nav");
    nav.classList.toggle("active");
    const active = nav.classList.contains("active");
    event.currentTarget.setAttribute("aria-expanded", active);
    if (active) {
        event.currentTarget.setAttribute("aria-label", "Fechar Menu");
    } else {
        event.currentTarget.setAttribute("aria-label", "Abrir Menu");
    }
}

btnMobile.addEventListener("click", toggleMenu);
btnMobile.addEventListener("touchstart", toggleMenu);

/*################################################## RODAPE ####################################### */

const date = new Date();
const today = date.getDate() + "/" + date.getMonth() + "/" + date.getFullYear();
document.getElementById("dataHoje").innerText = today;

const horario = date.getHours() + ":" + date.getMinutes();
document.getElementById("horarioAgora").innerText = horario;
