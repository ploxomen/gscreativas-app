function loadPage() {
    let general = new General();
    const cbAnioVentas = document.querySelector("#cbAnioVentas");
    const data = {
        labels: [],
        datasets: [
            {
                type:"bar",
                label: 'Ventas del mes',
                backgroundColor: '#ffb1c1',
                borderColor: '#ffb1c1',
                barThickness: 30,
                data: [],
            },
            {
                type: 'line',
                label: 'Linia indicadora',
                backgroundColor: "#afdaf7",
                borderColor: "#afdaf7",
                data: [],
            }
        ]
    };
    const config = {
        data: data,
        options: {
            responsive: true,
            plugins:{
                tooltip:{
                    callbacks:{
                        label : function(context){
                            console.log(context);
                            let label = context.label ? 'Ventas de ' + context.label : '';
                            if(label){
                                label += ": ";
                            }
                            if (context.parsed.y !== null) {
                                label += general.resetearMoneda(context.parsed.y);
                            }
                            return label;
                        }
                    }
                }
            },
            scales: {
                responsive: true,
            }
        }
    };
    const chartVentas = new Chart(
        document.getElementById('grafico-1').getContext('2d'),
        config
    );
    const data2 = {
        labels: [],
        datasets: [{
            label: '',
            data: [],
            backgroundColor: [
                'rgb(255, 99, 132)',
                'rgb(54, 162, 235)',
                'rgb(60, 205, 86)',
                'rgb(255, 87, 51)',
                'rgb(255, 230, 51)'
            ],
        }]
        };
        const config2 = {
            type: 'doughnut',
            data: data2,
            options: {
                responsive: true,
                scales: {
                    responsive: true,
                }
            }
        };
        const chartDona = new Chart(
            document.getElementById('grafico-2').getContext('2d'),
            config2
        );
    function addDataChart(chart, labels, data) {
        chart.data.labels = labels;
        chart.data.datasets.forEach(dataset => {
            if(dataset.type == "line"){
                data = data.map(v => v+5);
            }
            dataset.data = data;
        });
        chart.update();
    }
    async function obtenerAnioVentas() {
        let datos = new FormData();
        datos.append("accion","ver-ventas-anio");
        datos.append("anio",cbAnioVentas.value);
        try {
            const response = await general.funcfetch("inicio/administrador",datos);
            let meses = [];
            let costos = [];
            response.ventas.forEach(v => {
                meses.push(general.obtenerNombresMes(v.mes));
                costos.push(parseFloat(v.total));
            });
            addDataChart(chartVentas,meses,costos);
        } catch (error) {
            console.error(error)
        }
    }
    async function obtenerProductosMasVendidos() {
        let datos = new FormData();
        datos.append("accion","ver-productos-anio");
        try {
            const response = await general.funcfetch("inicio/administrador",datos);
            let data = [];
            let labels = [];
            response.productos.forEach(v => {
                labels.push(v.nombreProducto);
                data.push(parseFloat(v.total));
            });
            addDataChart(chartDona,labels,data);
        } catch (error) {
            console.error(error)
        }
    }
    const tablaPerecederos = document.querySelector("#tablaPerecedero tbody");
    async function obtenerProductosPerecedero() {
        let datos = new FormData();
        datos.append("accion","ver-perecedero");
        try {
            const response = await general.funcfetch("inicio/administrador",datos);
            let template = "";
            response.productos.forEach((v,k) => {
                template += `
                <tr>
                    <td class="text-center">${(k + 1)}</td>
                    <td>${v.nombreProducto}</td>
                    <td class="text-center">${v.cantidad}</td>
                    <td class="text-center">${v.fechaVencimiento}</td>
                    <td class="text-center">${v.diasPasados}</td>
                </tr>
                `
            });
            tablaPerecederos.innerHTML = template == "" ? `<tr><td class="text-center" colspan="100%">No se encontró productos</td></tr>` : template;
        } catch (error) {
            console.error(error)
        }
    }
    obtenerProductosPerecedero();
    obtenerProductosMasVendidos();
    obtenerAnioVentas();
    cbAnioVentas.addEventListener("change",obtenerAnioVentas);
    
    
}
window.addEventListener("DOMContentLoaded",loadPage);