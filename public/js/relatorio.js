/* ##################################### RELATORIO ###########################################  */
Chart.defaults.font.size = 16;
const data = {
    labels: ["Faturamento Líquido", "Gastos totais"],
    datasets: [
        {
            label: "Faturamento",
            data: [faturamentoLiquidoDoPeriodo, gastosTotaisDoPeriodo],
            backgroundColor: ["#2ecc71", "#ff7979"],
            hoverOffset: 4,
        },
    ],
};

const config = {
    type: "pie",
    data: data,
};

const faturamentoChart = new Chart(
    document.getElementById("faturamentoChart"),
    config
);

let select = document.querySelector("#intervaloRelatorioSelect");

select.selectedIndex = selectIndex;

if (select.selectedIndex == 1) {
    const labelsFat = [];
    const dataFat = [];
    Object.entries(dataForGraph).forEach((element) => {
        labelsFat.push(element[0]);
        dataFat.push(element[1]);
    });

    const dataBar = {
        labels: labelsFat,
        datasets: [
            {
                label: "Faturamento Bruto",
                data: dataFat,
                backgroundColor: [
                    "rgba(255, 99, 132, 0.4)",
                    "rgba(255, 159, 64, 0.4)",
                    "rgba(255, 205, 86, 0.4)",
                    "rgba(75, 192, 192, 0.4)",
                    "rgba(54, 162, 235, 0.4)",
                    "rgba(153, 102, 255, 0.4)",
                    "rgba(201, 203, 207, 0.4)",
                ],
                borderColor: [
                    "rgb(255, 99, 132)",
                    "rgb(255, 159, 64)",
                    "rgb(255, 205, 86)",
                    "rgb(75, 192, 192)",
                    "rgb(54, 162, 235)",
                    "rgb(153, 102, 255)",
                    "rgb(201, 203, 207)",
                ],
                borderWidth: 1,
            },
        ],
    };
    const configBar = {
        type: "bar",
        data: dataBar,
        options: {
            animation: {
                duration: 2000,
                easing: "easeOutQuart",
            },
        },
    };
    const faturamentoBarChart = new Chart(
        document.getElementById("faturamentoBarChart"),
        configBar
    );

    function addData() {
        let sizeData = faturamentoBarChart.data.datasets[0].data.length;
        faturamentoBarChart.data.datasets[0].data[sizeData] =
            Object.entries(dataForGraph)[sizeData][1];
        faturamentoBarChart.data.labels[sizeData] =
            Object.entries(dataForGraph)[sizeData][0];
        faturamentoBarChart.update();
    }

    function removeData() {
        faturamentoBarChart.data.datasets[0].data.pop();
        faturamentoBarChart.data.labels.pop();
        faturamentoBarChart.update();
    }
} else {
    document.getElementById("faturamentoBarChartContainer").style.display =
        "none";
}

function atualizouSelect() {
    window.location.href = "/relatorio/" + select.selectedIndex;
}
