let names = [];

produtos.forEach(function (produto, index) {
    names.push(produto["nome"]);
});

let sortedNames = names.sort();

let input = document.getElementById("nome-produto");

input.addEventListener("keyup", (e) => {
    removeElements();
    for (let i of sortedNames) {
        if (
            i.toLowerCase().startsWith(input.value.toLowerCase()) &&
            input.value != ""
        ) {
            let listItem = document.createElement("li");

            listItem.classList.add("list-items");
            listItem.style.cursor = "pointer";
            listItem.setAttribute("onclick", "displayNames('" + i + "')");

            let word = "<b>" + i.substr(0, input.value.length) + "</b>";
            word += i.substr(input.value.length);

            listItem.innerHTML = word;
            document.querySelector(".list").appendChild(listItem);
        }
    }
});
function displayNames(value) {
    input.value = value;
    removeElements();
}
function removeElements() {
    let items = document.querySelectorAll(".list-items");
    items.forEach((item) => {
        item.remove();
    });
}

let total = 0;

let produtosVendaAtual = "";

let addButton = document.getElementById("addButton");

addButton.addEventListener("click", function () {
    let nome = document.getElementById("nome-produto").value;
    let produto = produtos.find((el) => el["nome"] == nome);
    let preco = parseInt(produto["precoVenda"]);
    let id = parseInt(produto["id"]);
    total += preco;

    let listItem = document.createElement("li");

    listItem.innerHTML = "<p>" + nome + "</p>" + "<p> R$" + preco + ",00 </p>";

    listItem.classList.add("produto-list-item");
    listItem.style.cursor = "pointer";
    document.querySelector(".venda-list").appendChild(listItem);

    document.getElementById("nome-produto").value = "";
    document.getElementById("totalCompra").innerText = "R$ " + total + ",00";

    if (produtosVendaAtual == "") {
        produtosVendaAtual = id;
    } else {
        produtosVendaAtual += " " + id;
    }
});

let addVendaButton = document.getElementById("btn-adicionar");
addVendaButton.addEventListener("click", function () {
    $.post(
        "/venda",
        { produtos: produtosVendaAtual, _token: _token },
        function () {
            window.location.reload();
        }
    );
});
